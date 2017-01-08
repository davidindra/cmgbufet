git status;
echo "";
echo "Run only on master branch! Confirm with Enter.";
pause;
git commit -a;
git checkout live;
git merge master;
git checkout master;
git push --all;