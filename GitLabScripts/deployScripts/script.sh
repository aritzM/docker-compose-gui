#!/bin/bash
mysqldump -u akaenterprises -pL3h3nd@k@r1 DockerComposeGui > /home/desarrollo/deployScripts/DockerComposeGui.sql
mysql -u akaenterprises -pL3h3nd@k@r1 < /home/desarrollo/deployScripts/script.sql
if [ $? -gt 0 ]; then
  mysql -u akaenterprises -pL3h3nd@k@r1 --execute="DROP DATABASE DockerComposeGui;"
  mysql -u akaenterprises -pL3h3nd@k@r1 < /home/desarrollo/deployScripts/DockerComposeGui.sql
  echo "1"
fi
