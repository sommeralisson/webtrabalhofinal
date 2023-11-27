FROM php:7.4.33-apache
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql

COPY / /var/www/html

RUN apt-get update

#XDebug
RUN echo "zend_extension=/usr/local/lib/php/extensions/no-debug-non-zts-20190902/xdebug.so\n\
xdebug.mode=develop,coverage,debug,profile\n\
xdebug.idekey=docker\n\
xdebug.start_with_request=yes\n\
xdebug.log=/dev/stdout\n\
xdebug.log_level=0\n\
xdebug.client_port=9003\n\
xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN BEFORE_PWD=$(pwd) \
    && mkdir -p /opt/xdebug \
    && cd /opt/xdebug \
    && curl -k -L https://xdebug.org/files/xdebug-3.1.6.tgz | tar zx \
    && cd xdebug-3.1.6 \
    && phpize \
    && ./configure --enable-xdebug \
    && make clean \
    && sed -i 's/-O2/-O0/g' Makefile \
    && make \
    && make install \
    && cd "${BEFORE_PWD}" \
    && rm -r /opt/xdebug
RUN docker-php-ext-enable xdebug
