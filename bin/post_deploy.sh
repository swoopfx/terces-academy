#!/bin/bash
PWD= `pwd`

echo "-- Running composer --"
 php  ../composer.phar update 

 if [ $? != 0 ]; then
    echo 'There was an error running composer'
    exit -1
else
  rm ../data/cache/module-config-cache.application.config.cache.php

fi

