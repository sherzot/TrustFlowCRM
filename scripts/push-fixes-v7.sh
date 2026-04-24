#!/usr/bin/env bash
# ----------------------------------------------------------------------------
# TrustFlow CRM — push the macOS-compat hotfix (v7)
#
# One commit:
#   fix(ci): drop GNU `timeout` wrapper from migration step
#
# Why: in the previous deploy the Migration Job ran to Completion in 3
# seconds (init container + migrate container both exit 0), but the CI step
# still failed. Root cause — macOS self-hosted runners don't ship coreutils
# by default (verified: `which timeout gtimeout` => both "not found"), so
# the outer `timeout 330 kubectl wait …` shelled out `bash: timeout:
# command not found`, the `if` branch saw exit 127, and the diagnostics
# block fired as if the Job had failed. Remove the wrapper; kubectl's
# built-in --timeout=300s is sufficient.
#
# Run from the repo root on your Mac:
#   bash scripts/push-fixes-v7.sh
# ----------------------------------------------------------------------------
set -euo pipefail

REPO_ROOT="$(git rev-parse --show-toplevel)"
cd "$REPO_ROOT"

echo "==> Repo:   $REPO_ROOT"
echo "==> Branch: $(git rev-parse --abbrev-ref HEAD)"
echo "==> HEAD:   $(git --no-pager log --oneline -1)"
echo

if [ -f .git/index.lock ]; then
    echo "==> Removing stale .git/index.lock"
    rm -f .git/index.lock
fi

BRANCH="$(git rev-parse --abbrev-ref HEAD)"
if [ "$BRANCH" != "main" ]; then
    echo "ERROR: expected 'main', got '$BRANCH'. Aborting."
    exit 1
fi

echo "==> Dirty files:"
git status --short
echo

read -p "Commit + push fix(ci): macOS timeout hotfix to origin/main? [y/N] " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    echo "Aborted. No changes made."
    exit 1
fi

git add .github/workflows/deploy.yml scripts/push-fixes-v7.sh

git commit -m "fix(ci): drop GNU 'timeout' wrapper from migration step

Previous deploy run (e19401c) looked like a migration failure in the
Actions UI — 'Migration Job did not complete — dumping diagnostics.'
— but inspection of the cluster showed the Job actually succeeded:

    Pod trustflow-migrate-sc298  Status: Succeeded
    Init container wait-for-mysql  Exit 0  (1s)
    Container migrate              Exit 0  (0s)
    Event: Job completed

Root cause was the outer 'timeout 330 kubectl wait …' wrapper I
added as paranoid belt-and-suspenders. On the macOS self-hosted
runner, neither 'timeout' nor 'gtimeout' are on PATH by default
(coreutils is not installed), so the shell returned exit 127
('timeout: command not found') before kubectl wait was ever invoked.
The 'if' branch saw non-zero, skipped to the else, and dumped
diagnostics for a freshly-created-but-already-succeeded pod, which
is why the pod description showed STATUS=Succeeded in the logs even
though CI reported failure.

Drop the wrapper. kubectl's own --timeout=300s is sufficient — Jobs
cannot outrun it.

Also add a comment at the call site so the next person doesn't
re-introduce the same wrapper."

echo
echo "==> New commit:"
git --no-pager log --oneline -2
echo
echo "==> Pushing to origin/main…"
git push origin main

echo
echo "==> DONE."
echo "   Commits:  https://github.com/sherzot/TrustFlowCRM/commits/main"
echo "   Actions:  https://github.com/sherzot/TrustFlowCRM/actions"
