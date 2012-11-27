#!/bin/bash

# Set up permissions

set -e

GROUP=www-data
OWNER=tbbc

BINDIR=$(cd `dirname $0`; pwd)
BASEDIR=$(cd "$BINDIR/../.."; pwd)

echo "BASEDIR=$BASEDIR"

if [ ! -d $BASEDIR/protected ] ; then
    echo "BASEDIR incorrect, should be the base htdocs directory"
    exit 1;
fi

# Yii runtime directories
for component in $(echo protected/runtime assets images images/uploads)
do
    the_dir=$BASEDIR/$component
    mkdir -p $the_dir
    chown $OWNER:$GROUP $the_dir
    chmod -R g+rw $the_dir
done
