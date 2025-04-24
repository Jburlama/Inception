#!/bin/sh

# Start MariaDB safely in the background
mysqld_safe &
sleep 10

# Wait until MariaDB is fully started
until mysqladmin ping -h "localhost" --silent; do
    echo "Waiting for MariaDB to start..."
    sleep 2
done

# Create the database
mysql -u root -p"Jhonas123" -e "CREATE DATABASE IF NOT EXISTS \`wp_site\`;"

# Create a new user and grant privileges
mysql -u root -p"Jhonas123!" -e "CREATE USER IF NOT EXISTS \`jburlama\`@'%' IDENTIFIED BY 'Jhonas123!';"
mysql -u root -p"Jhonas123!" -e "GRANT ALL PRIVILEGES ON \`wp_site\`.* TO \`jburlama\`@'%';"

# Flush privileges to ensure changes are applied
mysql -u root -p"Jhonas123!" -e "FLUSH PRIVILEGES;"

# Modify root user password
mysql -u root -p"Jhonas123!" -e "ALTER USER 'root'@'localhost' IDENTIFIED BY 'Jhonas123!';"

# Shutdown MariaDB to apply changes and restart in safe mode
mysqladmin -u root -p"Jhonas123!" shutdown
sleep 5

# Start MariaDB in safe mode
exec mysqld_safe
