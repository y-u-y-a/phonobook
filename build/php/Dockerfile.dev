FROM php:7.2-fpm

# composerをインストール
RUN cd /usr/bin && curl -s http://getcomposer.org/installer | php && ln -s /usr/bin/composer.phar /usr/bin/composer

# Node.js(ver:12)をインストール
RUN curl -sL https://deb.nodesource.com/setup_12.x | bash --
RUN apt-get install -y nodejs

# ライブラリのインストール
RUN apt-get update \
    && apt-get install -y \
    git \
    zip \
    unzip \
    vim \
    libpq-dev

RUN apt-get update \
    && docker-php-ext-install pdo_mysql pdo_pgsql mysqli mbstring

# nginxのために解放
EXPOSE 9000
