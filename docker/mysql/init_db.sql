CREATE USER IF NOT EXISTS 'developer'@'%' IDENTIFIED WITH mysql_native_password BY 'PassW0rd';
CREATE DATABASE IF NOT EXISTS bookstore;
CREATE DATABASE IF NOT EXISTS bookstore_test;
GRANT ALL PRIVILEGES ON bookstore.* TO 'developer'@'%';
GRANT ALL PRIVILEGES ON bookstore_test.* TO 'developer'@'%';
FLUSH PRIVILEGES;
