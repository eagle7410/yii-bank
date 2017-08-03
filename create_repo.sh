#!/usr/bin/env bash
echo "# yii-bank" >> README.md
git init
git add README.md
git commit -m "first commit"
git remote add origin git@github.com:eagle7410/yii-bank.git
git push -u origin master
