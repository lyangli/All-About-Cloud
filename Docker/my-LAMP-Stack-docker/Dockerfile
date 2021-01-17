FROM php:7.4-apache
RUN docker-php-ext-install mysqli
WORKDIR /etc/ssl/mysql
RUN curl -O https://s3.amazonaws.com/rds-downloads/rds-combined-ca-bundle.pem >rds-combined-ca-bundle.pem

COPY HTML/* /var/www/html/

EXPOSE 80
