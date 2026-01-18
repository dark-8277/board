FROM php:8.2.29-apache

RUN apt-get update && apt-get install -y \
    wget zip unzip git \
    build-essential g++ \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libicu-dev \
    libzip-dev \
    libonig-dev

RUN docker-php-ext-install iconv sockets mbstring mysqli pdo pdo_mysql \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install intl \
    && docker-php-ext-install zip

# Configure PHP
RUN echo "\
display_errors = On\n\
log_errors = On\n\
max_execution_time = 6000\n\
memory_limit = 1G\n\
post_max_size = 50M\n\
upload_max_filesize = 50M\n\
max_file_uploads = 50\n\
default_charset = \"UTF-8\"\n\
date.timezone = \"Asia/Seoul\"\n\
short_open_tag = On" > /usr/local/etc/php/php.ini

RUN pecl install xdebug && docker-php-ext-enable xdebug
# Configure xDebug
RUN echo "\
xdebug.enable=1\n\
xdebug.remote_enable=1\n\
xdebug.remote_connect_back=0\n\
xdebug.remote_port=9003\n\
xdebug.remote_host=\"host.docker.internal\"\n\
xdebug.idekey=\"VSCODE\"\n\
xdebug.extended_info=on\n\
xdebug.start_with_request=yes\n\
xdebug.log = /tmp/xdebug.log\n\
xdebug.log_level = 10\n\
xdebug.mode = debug,develop\n\
xdebug.max_nesting_level=400\n\
xdebug.var_display_max_depth=10\n\
">> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer
RUN chmod +x /usr/bin/composer

RUN a2enmod rewrite \
 && a2enmod headers \
 && a2enmod expires

# Custom Apache conf
COPY conf/apache_ext.conf /etc/apache2/conf-available/apache_ext.conf
RUN a2enconf apache_ext

RUN ln -sf /dev/stdout /var/log/apache2/access.log \
    && ln -sf /dev/stderr /var/log/apache2/error.log

RUN usermod -u 1000 www-data && usermod -a -G users www-data

# TimeZone 설정
ENV TZ Asia/Seoul
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
