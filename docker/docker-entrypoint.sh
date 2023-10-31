#!/bin/sh

set -e

cp -R /tmp/.ssh/* /home/deploy/.ssh
chmod 700 /home/deploy/.ssh
chmod 600 /home/deploy/.ssh/*
chmod 644 /home/deploy/.ssh/*.pub
eval `ssh-agent -s` > /dev/null
find ~/.ssh/ -type f -exec grep -l "PRIVATE" {} \; | xargs ssh-add -q &> /dev/null

exec "$@"

