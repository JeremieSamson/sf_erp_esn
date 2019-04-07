#!/usr/bin/env bash
set -e

uid=$(stat -c %u /app)
gid=$(stat -c %g /app)

if [ $uid == 0 ] && [ $gid == 0 ]; then
    if [ $# -eq 0 ]; then
        supervisord -c /etc/supervisor/conf.d/supervisord.conf
    else
        exec "$@"
    fi
fi

sed -i "s/user = www-data/user = erp/g" /etc/php/5.6/fpm/pool.d/www.conf
sed -i "s/group = www-data/group = erp/g" /etc/php/5.6/fpm/pool.d/www.conf
sed -i -r "s/erp:x:[0-9]+:[0-9]+:/erp:x:$uid:$gid:/g" /etc/passwd
sed -i -r "s/erp:x:[0-9]+:/erp:x:$gid:/g" /etc/group

chown $uid:$gid /home/erp

if [ $# -eq 0 ]; then
    supervisord -c /etc/supervisor/conf.d/supervisord.conf
else
    exec gosu erp "$@"
fi

cat /var/log/nginx/error.log
