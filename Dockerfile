FROM php:8.2-cli

RUN docker-php-ext-install mysqli

WORKDIR /var/www/html

EXPOSE 8000

# docker-compose.yml overrides this per service (site1 on 8000, site2 on 8001)
CMD ["php", "-S", "0.0.0.0:8000", "-t", "site1"]
