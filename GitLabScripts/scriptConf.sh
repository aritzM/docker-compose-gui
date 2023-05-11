#!/bin/bash
apt update && apt upgrade -y
apt install apt-transport-https ca-certificates curl software-properties-common
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /usr/share/keyrings/docker-archive-keyring.gpg
echo "deb [arch=$(dpkg --print-architecture) signed-by=/usr/share/keyrings/docker-archive-keyring.gpg] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null
apt update
sudo apt install docker-ce -y
mkdir -p ~/.docker/cli-plugins/
curl -SL https://github.com/docker/compose/releases/download/v2.3.3/docker-compose-linux-x86_64 -o ~/.docker/cli-plugins/docker-compose
chmod +x ~/.docker/cli-plugins/docker-compose
docker compose version
cat << EOF > /etc/sudoers
#
# This file MUST be edited with the 'visudo' command as root.
#
# Please consider adding local content in /etc/sudoers.d/ instead of
# directly modifying this file.
#
# See the man page for details on how to write a sudoers file.
#
Defaults        env_reset
Defaults        mail_badpass
Defaults        secure_path="/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/snap/bin"

# Host alias specification

# User alias specification

# Cmnd alias specification

# User privilege specification
root    ALL=(ALL:ALL) ALL
#www-data ALL=(ALL) ALL
www-data ALL=(ALL:ALL) NOPASSWD:/usr/bin/docker-managment-backend,/usr/bin/docker-action,/usr/sbin/useradd,/usr/bin/passwd,/usr/bin/mkdir,/usr/bin/chown,/usr/bin/chmod,/usr/sbin/usermod,/usr/bin/mv,/usr/bin/rm
#www-data ALL=(ALL:ALL) ALL
# Members of the admin group may gain root privileges
%admin ALL=(ALL) ALL

# Allow members of group sudo to execute any command
%sudo   ALL=(ALL:ALL) ALL

# See sudoers(5) for more information on "#include" directives:

#includedir /etc/sudoers.d
EOF

cat << EOF > /etc/apache2/sites-enabled/000-default.conf
<VirtualHost *:80>
        ServerAdmin webmaster@localhost
        DocumentRoot /var/www/html/docker-compose-gui
        ErrorLog \${APACHE_LOG_DIR}/error.log
        CustomLog \${APACHE_LOG_DIR}/access.log combined
<Location /server-status>
        SetHandler server-status
        Require local
        Require ip 192.168.1.0/24
</Location>
</VirtualHost>
EOF
echo L3h3nd@k@r1 | sudo -S systemctl restart apache2
echo L3h3nd@k@r1 | sudo -S mysql -u root --execute="CREATE USER IF NOT EXISTS 'akaenterprises'@'%' IDENTIFIED BY 'L3h3nd@k@r1';"
echo L3h3nd@k@r1 | sudo -S mysql -u root --execute="GRANT ALL PRIVILEGES ON *.* TO 'akaenterprises'@'%' ;"
