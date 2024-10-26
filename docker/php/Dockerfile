FROM php:8.2.8-fpm-bullseye

ARG TIMEZONE

COPY ./docker/php/php.ini /usr/local/etc/php/conf.d/docker-php-config.ini

RUN apt-get update && apt-get install -y --no-install-recommends \
    locales  \
    apt-utils \
    gnupg \
    gnupg2 \
    g++ \
    procps \
    openssl \
    git \
    unzip \
    zlib1g-dev \
    libzip-dev \
    libfreetype6-dev \
    libpng-dev \
    libjpeg-dev \
    libicu-dev  \
    libonig-dev \
    libpq-dev \
    libxslt-dev \
    libxml2-dev \
    wget \
    curl \
    acl \
    locate \
    ksh  \
    zip \
    nano \
    vim \
    locate \
    && echo 'alias ll="ls -all"' >> ~/.bashrc \
    && echo 'alias sf="php bin/console"' >> ~/.bashrc \
    && echo 'alias pstan="vendor/bin/phpstan analyse"' >> ~/.bashrc

RUN wget https://pear.php.net/go-pear.phar
RUN php go-pear.phar

# Removing /var/lib/apt/lists worked
RUN rm -rf /var/lib/apt/lists/* && curl -sL https://deb.nodesource.com/setup_18.x | bash - \
&& apt-get install nodejs -y

RUN docker-php-ext-configure intl

RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql opcache intl zip calendar dom mbstring zip gd xsl

# Set timezone
RUN echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && \
    echo "fr_FR.UTF-8 UTF-8" >> /etc/locale.gen && \
    locale-gen

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Create Symfony project and log output
#RUN composer create-project symfony/skeleton:"7.1.*" movies --no-interaction > create_project.log 2>&1

# Check if the project was created and list its contents
#RUN ls -la /var/www/html/movies && cat create_project.log


# Change directory to the Symfony project
#WORKDIR /var/www/html/movies

# Require webapp pack for Symfony
#RUN composer require symfony/webapp-pack --no-interaction

# Ensure permissions are set properly for the web server
RUN chown -R www-data:www-data /var/www/html


# Clean up the working directory
#RUN rm -rf /var/www/html/*

# Install Symfony skeleton project
#RUN composer create-project symfony/skeleton:7.0 .
#RUN composer create-project symfony/skeleton:^7.0 . --stability=dev --no-interaction

# Install Symfony 7 using curl
RUN curl -sS https://get.symfony.com/cli/installer | bash && \
    mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Create a new Symfony project
#RUN symfony new we_movies --version=7.0 --full


# Ensure permissions are set properly for the web server
#RUN chown -R www-data:www-data /var/www/html/we_movies


#ENV PATH /root/.composer/vendor/bin:$PATH
# Expose port 9000 for PHP-FPM
EXPOSE 9000

# Set the command to run PHP-FPM
CMD ["php-fpm"]






