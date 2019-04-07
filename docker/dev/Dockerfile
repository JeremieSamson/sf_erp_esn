FROM ubuntu:16.04

ENV LANG="en_US.UTF-8" \
    LC_ALL="en_US.UTF-8" \
    LANGUAGE="en_US.UTF-8" \
    TERM="xterm" \
    DEBIAN_FRONTEND="noninteractive" \
    SYMFONY_ALLOW_APPDEV=1 \
    NODE_VERSION=8.14.0 \
    GOSU_VERSION=1.11 \
    COMPOSER_ALLOW_SUPERUSER=1

EXPOSE 80
WORKDIR /app

RUN apt-get update -q && \
    apt-get install -qy software-properties-common language-pack-en-base build-essential && \
    export LC_ALL=en_US.UTF-8 && \
    export LANG=en_US.UTF-8 && \
    add-apt-repository ppa:ondrej/php && \
    apt-get update -q && \
    apt-get install --no-install-recommends -qy \
        ca-certificates \
        cron \
        curl \
        nano \
        vim \
        nginx \
        git \
        graphviz \
        mysql-client \
        php5.6 \
        php5.6-bcmath \
        php5.6-common \
        php5.6-curl \
        php5.6-dom \
        php5.6-fpm \
        php5.6-gd \
        php5.6-iconv \
        php5.6-intl \
        php5.6-json \
        php5.6-mbstring \
        php5.6-mcrypt \
        php5.6-mysql \
        php5.6-pdo \
        php5.6-phar \
        php5.6-sqlite \
        php5.6-xdebug \
        php5.6-xml \
        php5.6-zip \
        php5.6-amqp \
        php-apcu \
        php-uuid \
        supervisor \
        tzdata \
        wget \
        wkhtmltopdf && \

    phpdismod xdebug && \

    apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \

    cp /usr/share/zoneinfo/Europe/Paris /etc/localtime && echo "Europe/Paris" > /etc/timezone && \

    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \

    curl -L -o /tmp/nodejs.tar.gz https://nodejs.org/dist/v${NODE_VERSION}/node-v${NODE_VERSION}-linux-x64.tar.gz && \
    tar xfvz /tmp/nodejs.tar.gz -C /usr/local --strip-components=1 && \
    rm -f /tmp/nodejs.tar.gz && \
    npm install yarn -g && \

    mkdir /run/php

RUN curl -L https://github.com/tianon/gosu/releases/download/${GOSU_VERSION}/gosu-$(dpkg --print-architecture) --output /usr/local/bin/gosu && \
    chmod +x /usr/local/bin/gosu && \
    addgroup erp && \
    adduser --home=/home/erp --shell=/bin/bash --ingroup=erp --disabled-password --quiet erp

COPY php.ini /etc/php/5.6/cli/conf.d/50-setting.ini
COPY php.ini /etc/php/5.6/fpm/conf.d/50-setting.ini
COPY pool.conf /etc/php/5.6/fpm/pool.d/www.conf
COPY nginx.conf /etc/nginx/nginx.conf
COPY symfony.conf /etc/nginx/symfony.conf
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY entrypoint.sh /usr/local/bin/

ENTRYPOINT ["entrypoint.sh"]
