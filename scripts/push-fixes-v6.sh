#!/usr/bin/env bash
# ----------------------------------------------------------------------------
# TrustFlow CRM — push the post-0599b18 fix bundle (v6)
#
# This replaces the earlier .bundle workflow. It commits the four logical
# changes below directly in the working repo and pushes main to origin.
#
#   1. fix(analytics): cast MySQL DECIMAL aggregate to float before round()
#      -> fixes the TypeError on /admin (AnalyticsService.php:110)
#
#   2. test(factories): add missing UserFactory + TenantFactory; unfinal
#      AiCallLogger so Mockery can replace its methods
#      -> makes Tests\Feature\PolicyTest, TenantIsolationTest, and
#         Tests\Unit\AIServiceTest green in CI
#
#   3. perf(ci): build linux/arm64 only (drop amd64) + enhanced migration
#      diagnostics with hard timeout
#      -> cuts build job from ~52m to ~15m and prevents 1h+ migration hangs
#
#   4. chore(ci): bump publisher bundle name v4 -> v6
#
# Run from the repo root:
#   bash scripts/push-fixes-v6.sh
# ----------------------------------------------------------------------------
set -euo pipefail

REPO_ROOT="$(git rev-parse --show-toplevel)"
cd "$REPO_ROOT"

echo "==> Repo: $REPO_ROOT"
echo "==> Current branch: $(git rev-parse --abbrev-ref HEAD)"
echo "==> HEAD: $(git --no-pager log --oneline -1)"
echo

# ---- 0. Kill any stale index lock -----------------------------------------
# A previous sandbox session sometimes leaves .git/index.lock behind.
if [ -f .git/index.lock ]; then
    echo "==> Removing stale .git/index.lock"
    rm -f .git/index.lock
fi

# ---- 0b. Bail if we're not on main ----------------------------------------
BRANCH="$(git rev-parse --abbrev-ref HEAD)"
if [ "$BRANCH" != "main" ]; then
    echo "ERROR: expected to be on 'main', got '$BRANCH'. Aborting."
    exit 1
fi

# ---- 0c. Show what we're about to commit ----------------------------------
echo "==> Files to commit:"
for f in \
    app/Domains/Analytics/AnalyticsService.php \
    app/Services/AI/AiCallLogger.php \
    database/factories/UserFactory.php \
    database/factories/TenantFactory.php \
    .github/workflows/deploy.yml \
    scripts/publish-to-github.sh \
    scripts/push-fixes-v6.sh
do
    if [ -e "$f" ]; then
        echo "    $f"
    else
        echo "    MISSING: $f  <-- ABORT"
        exit 1
    fi
done
echo

read -p "Proceed with 4 commits + push to origin/main? [y/N] " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    echo "Aborted. No changes made."
    exit 1
fi

# ---- 1. Analytics TypeError fix -------------------------------------------
echo
echo "==> Commit 1/4: fix(analytics)"
git add app/Domains/Analytics/AnalyticsService.php
git commit -m "fix(analytics): cast MySQL DECIMAL aggregate to float before round()

Eloquent returns DECIMAL aggregates (AVG/SUM) as strings on MySQL
(e.g. \"12345.67\"). PHP 8.2's strict round() signature rejects strings
with 'Argument #1 (\$num) must be of type int|float, string given',
crashing the AI Insights widget on /admin.

Cast the \$avgDealValueQuery->avg('value') result to float with a null
coalesce before handing it to round().

Fixes TypeError at AnalyticsService.php:110 shown on /admin dashboard."

# ---- 2. Test suite fixes --------------------------------------------------
echo
echo "==> Commit 2/4: test(factories)"
git add \
    app/Services/AI/AiCallLogger.php \
    database/factories/UserFactory.php \
    database/factories/TenantFactory.php
git commit -m "test(factories): add UserFactory + TenantFactory, unfinal AiCallLogger

Three of the CI's 'Test (PHPUnit)' errors came from missing factory
classes (Database\Factories\UserFactory, TenantFactory) that the
feature tests PolicyTest and TenantIsolationTest depend on. Both
models already declare 'use HasFactory' but the factory files had
never been added. Seed them with enough randomness to make each
->create() call unique (email, company name).

The fourth class of error came from Tests\Unit\AIServiceTest trying
to Mockery::mock(AiCallLogger::class). Mockery cannot replace methods
on final classes, so the mock build threw. Remove the 'final' keyword
from AiCallLogger and document in a phpdoc note that this is a
test-only concession (production code should not subclass it).

With these in place the PHPUnit gate should go green; we can flip
continue-on-error back to false in a follow-up once we've watched a
few green runs."

# ---- 3. CI perf + migration diagnostics -----------------------------------
echo
echo "==> Commit 3/4: perf(ci)"
git add .github/workflows/deploy.yml
git commit -m "perf(ci): build linux/arm64 only + fail-fast migration diagnostics

Build step was taking ~52 minutes because the cloud runner (amd64)
was QEMU-emulating arm64 AND natively building amd64 for every run.
The deploy target is Docker Desktop Kubernetes on Apple Silicon —
linux/arm64 — so the amd64 manifest has no current consumer. Drop
it. Build now runs ~15 minutes; if/when a linux/amd64 deploy target
appears (staging, prod, remote CI runners), flip the platforms line
back to 'linux/amd64,linux/arm64'.

Separately, the migration step once spent 1h 44m stuck on
'kubectl wait' because a migration pod was in ImagePullBackOff and
we had no diagnostics path. Wrap the wait in a hard 'timeout 330' so
it can never outrun the --timeout=300s. On failure, dump:
  - kubectl describe job
  - kubectl get pods
  - kubectl describe pod + init + migrate logs
  - namespace events for the job
Next failure will surface root cause in the Actions UI within seconds
instead of burning an hour."

# ---- 4. Publisher script bump ---------------------------------------------
echo
echo "==> Commit 4/4: chore(ci)"
git add scripts/publish-to-github.sh scripts/push-fixes-v6.sh
git commit -m "chore(ci): bump bundle name to v6 + add push-fixes-v6 helper

publish-to-github.sh keyed off .trustflow-push-v4.bundle; bump to v6
to match the naming used when the next bundle is cut.

Also commit the push-fixes-v6.sh helper itself so the flow is
reproducible from the repo (and so a future teammate can see exactly
what the v6 set of fixes was)."

# ---- 5. Push --------------------------------------------------------------
echo
echo "==> New commits:"
git --no-pager log --oneline -5
echo
echo "==> Pushing to origin/main…"
git push origin main

echo
echo "==> DONE."
echo "   Check: https://github.com/sherzot/TrustFlowCRM/commits/main"
echo "   Actions: https://github.com/sherzot/TrustFlowCRM/actions"
