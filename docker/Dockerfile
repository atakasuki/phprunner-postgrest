FROM php:8.0-apache

# install and update necessary packages
RUN apt-get update && apt-get install \
    git \
    gnupg2 \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libxml2-dev \
    libxml2-dev \
    libzip-dev \
    odbcinst \
    openssh-client \
    ssmtp \
    unixodbc \
    unixodbc-dev \
    unzip \
    wget \
    -y --no-install-recommends

# php stuff
RUN docker-php-ext-configure pdo_odbc --with-pdo-odbc=unixODBC,/usr
RUN docker-php-ext-install \
      pdo_odbc \
      soap \
      zip
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j$(nproc) gd
RUN pecl install -o -f xdebug-3.1.5 \
    && docker-php-ext-enable xdebug
COPY ./php.ini /usr/local/etc/php/

# mail stuff
COPY ssmtp.conf /etc/ssmtp/ssmtp.conf

# ssh stuff
RUN useradd -m deploy



# driver installation
COPY odbc.ini /etc/odbc.ini
COPY odbcinst.ini /etc/odbcinst.ini
COPY ibm-iaccess-1.1.0.15-1.0.amd64.deb /tmp/ibm-iaccess-1.1.0.15-1.0.amd64.deb
RUN dpkg -i /tmp/ibm-iaccess-1.1.0.15-1.0.amd64.deb
RUN ln -s /opt/ibm/iaccess/lib64/libcwb* /usr/lib

RUN apt-get install -y libpq-dev
RUN docker-php-ext-install pdo pdo_pgsql

RUN docker-php-ext-install \
      pgsql
# composer stuff
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet

# file cleanup
RUN apt-get purge -y g++ \
    && apt-get autoremove -y \
    && rm -r /var/lib/apt/lists/* \
    && rm -rf /tmp/*



WORKDIR /var/www

# apache stuff
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite
RUN chown -R www-data:www-data /var/www

# change the current user
USER deploy

CMD ["apache2-foreground"]
