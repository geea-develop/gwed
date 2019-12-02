#!/usr/bin/env bash

echo "This is a mongod script"

mongod --logpath=/data/log/mongod.log --fork

echo "I am done running mongod"