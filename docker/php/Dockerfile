FROM php:7.2-fpm

# composerをインストール
RUN cd /usr/bin && curl -s http://getcomposer.org/installer | php && ln -s /usr/bin/composer.phar /usr/bin/composer
# ライブラリのインストール
RUN apt-get update \
    && apt-get install -y \
    git \
    zip \
    unzip \
    vim \
    nodejs \
    npm \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql pdo_mysql mysqli mbstring

# nginxのために解放
EXPOSE 9000
