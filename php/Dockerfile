FROM php:8.1.4-apache

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
    mv composer.phar /usr/local/bin/composer

WORKDIR /var/www/html