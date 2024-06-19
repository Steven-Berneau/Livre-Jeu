FROM php:8.3-apache
RUN apt-get update && \
    docker-php-ext-install mysqli pdo pdo_mysql
ENV APACHE_DOCUMENT_ROOT=/var/www/livre-jeu/
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN a2enmod rewrite
RUN apt update
#installer GIT
RUN apt install -y git
#Installer zip
RUN apt install -y zip
#pour symfony
RUN apt-get update -y && apt-get install -y libmcrypt-dev
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# RUN apt install -y npm
RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.3/install.sh | bash
RUN apt-get install -y gcc
RUN apt-get install -y libcurl4-openssl-dev
RUN docker-php-ext-install curl
RUN docker-php-ext-enable curl
# Prepare fake SSL certificate
RUN apt-get install -y ssl-cert
# Setup Apache2 mod_ssl
RUN a2enmod ssl
# Setup Apache2 HTTPS env
RUN a2ensite default-ssl.conf
#Setup certbot
# RUN apt-get install certbot python3-certbot-apache -y
# RUN certbot --apache --agree-tos --redirect --hsts --staple-ocsp --email thierry.bru@viaformation.fr -d www.localhost

