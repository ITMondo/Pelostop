# Setup
- activate php7 (preinstalled on mac) : `sudo vim /etc/apache2/httpd.conf` and uncomment php7 module
- install mysql: `brew install mysql`
- setup root user (mysqladmin -u root password 'dirk')
- setup 'Pelostop' database

# Getting Started
- `sudo apachectl start`
- `sudo apachectl restart`
- `brew services start mysql`
- `mysql -u root -p`
- (php version 7.1.16 wants a caching_sha2_password, fixed with: ALTER USER 'username'@'ip_address' IDENTIFIED WITH mysql_native_password BY 'password';)

# Wordpress
username: dirk
password: dirk

# MySQL
username: root
password: dirk
