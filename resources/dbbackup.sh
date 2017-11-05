#!/bin/sh
echo Generating backup of the database
mysqldump -u'cuisine' -p'cu1s1n3' --complete-insert=true --extended-insert=false cuisine > /home/cuisine/resources/cuisine.sql
