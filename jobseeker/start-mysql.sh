#!/bin/bash
MYSQL_DIR="/opt/lampp/htdocs/lieu/jobseeker/mysql-data"
/opt/lampp/bin/mysqld_safe --defaults-file="$MYSQL_DIR/my.cnf" --datadir="$MYSQL_DIR" &
echo "Waiting for MySQL to start..."
sleep 3
echo "MySQL started on port 3307"
