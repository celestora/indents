#!/usr/bin/sh 

../vendor/bin/peridot Indents.spec.php
if [ $? -eq 0 ]
then
    ../vendor/bin/peridot IndentGenerator.spec.php
    if [ $? -eq 0 ]
    then
        exit 0
    else
        exit 126
    fi
else
    exit 126
fi
