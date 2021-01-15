# Create mysql user
GRANT ALL ON `app`.* TO 'root'@'localhost' IDENTIFIED BY 'toor' WITH GRANT OPTION;
GRANT ALL ON `app`.* TO 'root'@'127.0.0.1' IDENTIFIED BY 'toor' WITH GRANT OPTION;
FLUSH PRIVILEGES;

# Illegal mix of collations error
ALTER DATABASE app DEFAULT COLLATE utf8_unicode_ci;
ALTER TABLE app.user CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE app.user_info CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;

# Utwórz bazę danych
# CREATE DATABASE db_name CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
# Uprawnienia do odczytu, zapisu
# GRANT ALL ON *.* TO 'user'@'localhost' IDENTIFIED BY 'toor';
# Uprawnienia do tworzenia tabel
# GRANT ALL ON *.* TO 'user'@'127.0.0.1' IDENTIFIED BY 'toor' WITH GRANT OPTION;
# Update all
# FLUSH PRIVILEGES;

# Variables
# SHOW [GLOBAL|SESSION] VARIABLES LIKE 'query%';
# SHOW STATUS LIKE 'qca%';
# SHOW STATUS LIKE '%key_read%';
# SHOW STATUS LIKE 'thread%';

# Set Variables
# SET GLOBAL query_cache_size = 0;
# SET GLOBAL query_cache_type = 0;