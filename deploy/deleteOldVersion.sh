prev_ver_count=$(find /var/www/tkt_school  -maxdepth 1  -type d | grep $(date +"%Y") | wc -l) &&
if [ "$prev_ver_count" -gt "3" ]; then sudo rm -rf  $(find  /var/www/tkt_school  -maxdepth 1  -type d| grep $(date +"%Y") | sort | head -n 1); fi
