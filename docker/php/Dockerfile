FROM php:8.0.5-fpm-alpine

# Set timezone env
ARG TZ='America/Sao_Paulo'
ENV DEFAULT_TZ ${TZ}

# Dependencies required for running "phpize"
# these get automatically installed and removed by "docker-php-ext-*" (unless they're already installed)
ENV PHPIZE_DEPS \
    autoconf \
    dpkg-dev dpkg \
    file \
    g++ \
    gcc \
    libc-dev \
    make \
    pkgconf \
    re2c \
    build-base \
    openssl-dev

# Get install-php-extensions binary.
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/

# Install packages
RUN set -euxo pipefail ;\
    apk upgrade --update-cache ;\
    echo "Base system packages" ;\
    apk add --no-cache \
    bash \
    nano \
    tzdata \
    gnupg \
    libzip-dev  \
    zip  \
    libpng  \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    zlib-dev \
    libxpm-dev \
    gd \
    wkhtmltopdf \
    xvfb \
    fontconfig \
    freetype \
    ttf-dejavu \
    ttf-droid \
    ttf-freefont \
    ttf-liberation \
    ttf-ubuntu-font-family ;\
    echo "Install SOAP PHP extension" ;\
    apk add --no-cache \
    libxml2-dev \
    php-soap

# Install PHP extensions
RUN set -euxo pipefail ;\
    apk add --no-cache --virtual build-dependencies \
    pcre-dev \
    ${PHPIZE_DEPS} ;\
    pecl install redis ;\
    pecl install mongodb ;\
    docker-php-ext-install \
    mysqli \
    soap \
    pdo \
    pdo_mysql \
    bcmath \
    zip \
    pcntl \
    gd \
    opcache ;\
    docker-php-ext-enable redis ;\
    docker-php-ext-enable mongodb ;\
    docker-php-ext-enable pdo_mysql ;\
    apk del build-dependencies

# Download and install sqlsrv and pdo_sqlsrv drivers.
RUN curl -O https://download.microsoft.com/download/e/4/e/e4e67866-dffd-428c-aac7-8d28ddafb39b/msodbcsql17_17.7.2.1-1_amd64.apk ;\
    curl -O https://download.microsoft.com/download/e/4/e/e4e67866-dffd-428c-aac7-8d28ddafb39b/mssql-tools_17.7.1.1-1_amd64.apk

RUN apk add --allow-untrusted \
    msodbcsql17_17.7.2.1-1_amd64.apk \
    mssql-tools_17.7.1.1-1_amd64.apk \
    ln -sfnv /opt/mssql-tools/bin/* /usr/bin ;\
    install-php-extensions sqlsrv pdo_sqlsrv 

# Set timezone and clean
RUN set -euxo pipefail ;\
    cp /usr/share/zoneinfo/${DEFAULT_TZ} /etc/localtime ;\
    apk del tzdata ;\
    rm -rf /var/cache/apk/* ;\
    rm -rf /root/.cache

# Create web user/group.
RUN addgroup -g 1000 web && adduser -G web -g web -s /bin/sh -D web

# Change path owner.
RUN chown -R web:web /var/www/html

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Copy php-fpm config.
ADD ./conf/fpm-www.conf /usr/local/etc/php-fpm.d/www.conf

# Copy PHP ini changes.
ADD ./conf/ini-changes.ini /usr/local/etc/php/conf.d/ini-changes.ini

# Copy OPCache changes.
ADD ./conf/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
