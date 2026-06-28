FROM php:8.2-apache

# Copie tout le code dans le webroot
COPY . /var/www/html/

# Optionnel : si ton fichier principal n'est pas index.php
# COPY indext.php /var/www/html/index.php

EXPOSE 80
