#!/usr/bin/env bash
# ----------------------------------------------------------------------------
# TrustFlow CRM — publish prepared commits to GitHub
#
# The Cowork session prepared 6 commits as a git bundle
# (.trustflow-push.bundle at the repo root). This script imports those
# commits, resets your local main to match, and pushes to origin
# (https://github.com/sherzot/TrustFlowCRM.git).
#
# IMPORTANT: the working-tree content already matches the bundle's final
# commit (that is how the commits were prepared). This script performs a
# `git reset --hard` to the bundle tip, which:
#   - Advances local main to the new commits.
#   - Keeps every working-tree file that those commits include (no net
#     change to files you've been editing).
#   - Reverts any uncommitted edits to tracked files that were NOT
#     included in the prepared commits (e.g. Laravel runtime caches).
#   - Leaves untracked files alone.
#
# Run on the host machine from the repo root.
# ----------------------------------------------------------------------------
set -euo pipefail

BUNDLE="$(git rev-parse --show-toplevel)/.trustflow-push-v2.bundle"
if [ ! -f "$BUNDLE" ]; then
    echo "ERROR: bundle not found at $BUNDLE"
    echo "Make sure you're in the TrustFlowCRM repo root."
    exit 1
fi

echo "==> Verifying bundle…"
git bundle verify "$BUNDLE"

echo "==> Fetching commits from bundle into publish/main ref…"
git fetch --no-tags "$BUNDLE" refs/heads/main:refs/heads/publish/main

echo
echo "==> Current local main is at:"
git --no-pager log --oneline -1 main

echo
echo "==> Bundle tip is at:"
git --no-pager log --oneline -1 publish/main

echo
echo "==> Commits about to be added:"
git --no-pager log --oneline main..publish/main

echo
read -p "Proceed with hard reset + push? [y/N] " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    echo "Aborted. Bundle is still at $BUNDLE if you want to inspect it."
    git branch -D publish/main
    exit 1
fi

echo "==> Checking out main and hard-resetting to bundle tip…"
git checkout main
git reset --hard publish/main

echo "==> Deleting the temporary ref…"
git branch -D publish/main

echo
echo "==> Pushing main to origin…"
git push origin main

echo
echo "==> DONE. Cleaning up the bundle file."
rm -f "$BUNDLE"

echo
echo "==> SUCCESS. Check: https://github.com/sherzot/TrustFlowCRM/commits/main"
