FROM alpine:edge

RUN apk --update add \
        openjdk8 \
        apache-ant \
        php7 \
        php7-fpm \
        php7-mcrypt \
        php7-mbstring \
        php7-pdo \
        php7-pdo_mysql \
        php7-pdo_pgsql \
        php7-pdo_sqlite \
        php7-curl \
        php7-openssl \
        php7-gettext \
        php7-bcmath \
        php7-zip \
        php7-mysqli \
        php7-json \
        php7-soap \
        php7-zlib \
        php7-xml \
        php7-simplexml \
        php7-dom \
        php7-ctype \
        php7-gd \
        php7-intl \
        php7-posix \
        php7-session \
        php7-iconv \
        php7-phar \
        php7-xmlwriter \
        php7-tokenizer \
        php7-xdebug \
        pdftk \
    && rm -rf /var/cache/apk/*

COPY config/php.ini /etc/php7/php.ini
COPY config/php-fpm.conf /etc/php7/php-fpm.conf
COPY config/xdebug.ini /etc/php7/conf.d/xdebug.ini

EXPOSE 9000

CMD ["php-fpm7", "-F"]

WORKDIR /app