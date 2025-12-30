<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('filament.project') }} - {{ $project->name }}</title>
    <style>
        @php
            $locale = app()->getLocale();
        @endphp
        @font-face {
            font-family: 'DejaVu Sans';
            font-style: normal;
            font-weight: normal;
            src: url('{{ storage_path('fonts/DejaVuSans.ttf') }}') format('truetype');
        }
        @font-face {
            font-family: 'DejaVu Sans';
            font-style: normal;
            font-weight: bold;
            src: url('{{ storage_path('fonts/DejaVuSans-Bold.ttf') }}') format('truetype');
        }
        * {
            font-family: 'DejaVu Sans', 'DejaVu Sans Unicode', sans-serif !important;
        }
        body {
            font-family: 'DejaVu Sans', 'DejaVu Sans Unicode', sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            border-bottom: 3px solid #f59e0b;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #f59e0b;
            margin: 0;
            font-size: 24px;
        }
        .project-info {
            margin-bottom: 30px;
        }
        .info-row {
            display: flex;
            margin-bottom: 10px;
        }
        .info-label {
            font-weight: bold;
            width: 150px;
        }
        .info-value {
            flex: 1;
        }
        .section {
            margin-top: 30px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .section h2 {
            margin-top: 0;
            color: #f59e0b;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-top: 20px;
        }
        .stat-box {
            padding: 15px;
            background-color: white;
            border-radius: 5px;
            border-left: 4px solid #f59e0b;
        }
        .stat-label {
            font-size: 10px;
            color: #666;
            text-transform: uppercase;
        }
        .stat-value {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin-top: 5px;
        }
        .tasks-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .tasks-table th,
        .tasks-table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .tasks-table th {
            background-color: #f59e0b;
            color: white;
            font-weight: bold;
        }
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ __('filament.project') }}</h1>
    </div>

    <div class="project-info">
        <div class="info-row">
            <div class="info-label">{{ __('filament.name') }}:</div>
            <div class="info-value">{{ $project->name }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">{{ __('filament.account') }}:</div>
            <div class="info-value">{{ $project->account->name }}</div>
        </div>
        @if($project->deal)
        <div class="info-row">
            <div class="info-label">{{ __('filament.deal') }}:</div>
            <div class="info-value">{{ $project->deal->name }}</div>
        </div>
        @endif
        <div class="info-row">
            <div class="info-label">{{ __('filament.status') }}:</div>
            <div class="info-value">{{ __('filament.' . $project->status) }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">{{ __('filament.start_date') }}:</div>
            <div class="info-value">{{ \App\Helpers\DateHelper::formatDate($project->start_date) }}</div>
        </div>
        @if($project->end_date)
        <div class="info-row">
            <div class="info-label">{{ __('filament.end_date') }}:</div>
            <div class="info-value">{{ \App\Helpers\DateHelper::formatDate($project->end_date) }}</div>
        </div>
        @endif
    </div>

    <div class="section">
        <h2>{{ __('filament.description') }}</h2>
        <p>{{ $project->description ?? __('filament.no_description') }}</p>
    </div>

    <div class="section">
        <h2>{{ __('filament.project_statistics') }}</h2>
        <div class="stats-grid">
            <div class="stat-box">
                <div class="stat-label">{{ __('filament.budget') }}</div>
                <div class="stat-value">{{ number_format($project->budget ?? 0, 2) }} {{ $project->currency ?? 'USD' }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">{{ __('filament.actual_cost') }}</div>
                <div class="stat-value">{{ number_format($project->actual_cost ?? 0, 2) }} {{ $project->currency ?? 'USD' }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">{{ __('filament.profit') }}</div>
                <div class="stat-value">{{ number_format($project->profit ?? 0, 2) }} {{ $project->currency ?? 'USD' }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">{{ __('filament.progress') }}</div>
                <div class="stat-value">{{ $project->progress ?? 0 }}%</div>
            </div>
        </div>
    </div>

    @if($project->tasks->count() > 0)
    <div class="section">
        <h2>{{ __('filament.tasks') }} ({{ $project->tasks->count() }})</h2>
        <table class="tasks-table">
            <thead>
                <tr>
                    <th>{{ __('filament.title') }}</th>
                    <th>{{ __('filament.status') }}</th>
                    <th>{{ __('filament.priority') }}</th>
                    <th>{{ __('filament.due_date') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($project->tasks as $task)
                <tr>
                    <td>{{ $task->title }}</td>
                    <td>{{ __('filament.' . $task->status) }}</td>
                    <td>{{ __('filament.' . $task->priority) }}</td>
                    <td>{{ $task->due_date ? \App\Helpers\DateHelper::formatDate($task->due_date) : '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <div class="footer">
        <p>{{ __('filament.generated_at') }}: {{ \App\Helpers\DateHelper::formatDateTime(now()) }}</p>
        <p>{{ config('app.name') }} - {{ __('filament.project_report') }}</p>
    </div>
</body>
</html>

