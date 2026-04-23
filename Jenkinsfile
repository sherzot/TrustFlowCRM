// TrustFlow CRM — local Jenkins pipeline
// Expects a Linux agent with Docker + docker compose v2 installed.
// Jenkins credentials used:
//   dockerhub        -> Username/Password (optional push)
//   trustflow-env    -> Secret file (.env for tests)

pipeline {
    agent any

    options {
        ansiColor('xterm')
        timestamps()
        timeout(time: 30, unit: 'MINUTES')
        buildDiscarder(logRotator(numToKeepStr: '20'))
    }

    environment {
        IMAGE            = "trustflow-crm"
        PHP_IMAGE        = "ghcr.io/shivammathur/setup-php/php:8.2-cli"
        COMPOSE_PROJECT  = "trustflow_ci_${BUILD_NUMBER}"
    }

    stages {
        stage('Checkout') {
            steps { checkout scm }
        }

        stage('Composer install') {
            steps {
                sh '''
                    docker run --rm \
                        -v "$PWD:/app" -w /app \
                        composer:2 install --no-interaction --prefer-dist --no-progress
                '''
            }
        }

        stage('Lint (Pint)') {
            steps {
                sh 'vendor/bin/pint --test'
            }
        }

        stage('Static analysis (PHPStan)') {
            steps {
                sh 'vendor/bin/phpstan analyse --memory-limit=1G --no-progress'
            }
        }

        stage('Test (PHPUnit)') {
            steps {
                sh '''
                    cp -n .env.example .env || true
                    php artisan key:generate --force
                    vendor/bin/phpunit --colors=never
                '''
            }
        }

        stage('Composer audit') {
            steps {
                sh 'composer audit || true'
            }
        }

        stage('Docker build') {
            steps {
                sh 'docker build -t ${IMAGE}:${BUILD_NUMBER} -t ${IMAGE}:latest .'
            }
        }

        stage('Docker push') {
            when { branch 'main' }
            steps {
                withCredentials([usernamePassword(
                    credentialsId: 'dockerhub',
                    usernameVariable: 'DH_USER',
                    passwordVariable: 'DH_PASS'
                )]) {
                    sh '''
                        echo "$DH_PASS" | docker login -u "$DH_USER" --password-stdin
                        docker tag ${IMAGE}:${BUILD_NUMBER} $DH_USER/${IMAGE}:${BUILD_NUMBER}
                        docker tag ${IMAGE}:latest        $DH_USER/${IMAGE}:latest
                        docker push $DH_USER/${IMAGE}:${BUILD_NUMBER}
                        docker push $DH_USER/${IMAGE}:latest
                    '''
                }
            }
        }
    }

    post {
        always {
            archiveArtifacts artifacts: 'storage/logs/*.log', allowEmptyArchive: true
            cleanWs()
        }
        failure {
            echo "Build ${BUILD_NUMBER} failed on ${env.BRANCH_NAME}."
        }
    }
}
