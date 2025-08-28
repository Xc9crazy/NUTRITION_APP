FROM php:8.2-apache

# mysqli, PDO MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Apache mod_rewrite
RUN a2enmod rewrite

# 文字化け対策（ロケール）
RUN apt-get update && apt-get install -y locales && \
    locale-gen ja_JP.UTF-8
ENV LANG=ja_JP.UTF-8
ENV LANGUAGE=ja_JP:ja
ENV LC_ALL=ja_JP.UTF-8

# タイムゾーン
RUN ln -snf /usr/share/zoneinfo/Asia/Tokyo /etc/localtime && echo "Asia/Tokyo" > /etc/timezone