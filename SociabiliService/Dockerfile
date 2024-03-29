# Use the official PHP 5.5.38 image as the base image
FROM php:5.5.38-apache

# Set the working directory in the container
WORKDIR /var/www/html

#First we fix legacy debian (Jessie) issue
RUN rm /etc/apt/sources.list
RUN echo "deb http://archive.debian.org/debian/ jessie main" | tee -a /etc/apt/sources.list
RUN echo "deb-src http://archive.debian.org/debian/ jessie main" | tee -a /etc/apt/sources.list
RUN echo "Acquire::Check-Valid-Until false;" | tee -a /etc/apt/apt.conf.d/10-nocheckvalid
RUN echo 'Package: *\nPin: origin "archive.debian.org"\nPin-Priority: 500' | tee -a /etc/apt/preferences.d/10-archive-pin

RUN apt-get update

RUN apt-get install -y --allow-unauthenticated unzip

# Install dependencies for OCI8 extension
RUN apt-get install -y  --allow-unauthenticated \
    libaio1 \
    libaio-dev \
    libcurl4-openssl-dev \
    libxml2-dev \
    libssl-dev \
    libsqlite3-dev \
    libc-client-dev
    # libtidy-dev \
    # libjpeg-dev \
    # libpng-dev \
    # libexif-dev \
    # libicu-dev \
    # libkrb5-dev

# Enable necessary PHP extensions
RUN docker-php-ext-install mysql mysqli soap pdo_mysql pdo_sqlite openssl

# mbstring gettext curl exif xmlrpc  

# Install oracle client.
COPY oracle/instantclient-basic-linux.x64-11.2.0.4.0.zip /tmp/instantclient-basic-linux.x64-11.2.0.4.0.zip
COPY oracle/instantclient-sdk-linux.x64-11.2.0.4.0.zip /tmp/instantclient-sdk-linux.x64-11.2.0.4.0.zip
COPY oracle/anwser-install-oci8.txt /tmp/anwser-install-oci8.txt

RUN unzip /tmp/instantclient-basic-linux.x64-11.2.0.4.0.zip -d /opt/oracle \
    && unzip /tmp/instantclient-sdk-linux.x64-11.2.0.4.0.zip -d /opt/oracle \
    && cd /opt/oracle \
    && mv instantclient_11_2/* /usr/lib \
    && rmdir instantclient_11_2 \
    && cd /usr/lib \
    && ln -s libocci.so.11.1 libocci.so \
    && ln -s libclntsh.so.11.1 libclntsh.so

# Set environment variables required by OCI8
ENV LD_LIBRARY_PATH=/usr/lib

# Install OCI8 extension
RUN docker-php-ext-configure oci8 --with-oci8=instantclient,/usr/lib \
    && docker-php-ext-install oci8

# Remove copied packages.
RUN rm /tmp/instantclient-basic-linux.x64-11.2.0.4.0.zip \
  && rm /tmp/instantclient-sdk-linux.x64-11.2.0.4.0.zip \
  && rm /tmp/anwser-install-oci8.txt

# Copy the application files into the container
COPY . /var/www/html

# Expose port 80 for Apache
EXPOSE 80

# Start Apache when the container runs
CMD ["apache2-foreground"]