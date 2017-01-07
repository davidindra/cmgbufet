#!/usr/bin/env bash
git status
echo "Run only on master branch. Confirm with Enter."
read
git commit -a
git checkout live
git merge master
git checkout master
git push --all