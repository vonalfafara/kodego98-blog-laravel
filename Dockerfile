FROM richarvey/nginx-php-fpm:latest

COPY . .

# Image config
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Laravel config
ENV APP_ENV production
ENV APP_DEBUG false
ENV DB_CONNECTION pgsql
ENV DB_HOST dpg-cojmuj8cmk4c73bujd20-a.singapore-postgres.render.com
ENV DB_PORT 5432
ENV DB_DATABASE blog_app_laravel
ENV DB_USERNAME blog_app_laravel_user
ENV DB_PASSWORD 36UkPNV02O4COGczhrus3NHXoCHRe4DE

# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

CMD ["/start.sh"]