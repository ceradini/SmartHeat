#!/bin/bash
python3 /home/pi/home-app-backend/commands_reader.py &

while true; do
    php /var/www/html/home-app/index.php sync check_rules
    sleep 4
done