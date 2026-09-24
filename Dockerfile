FROM php:8.2-apache

# Install ekstensi PHP yang dibutuhkan
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Aktifkan mod_rewrite Apache (opsional, untuk URL routing)
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy semua file project ke dalam container
COPY . /var/www/html/

# Buat folder uploads jika belum ada (untuk lab File Upload)
RUN mkdir -p /var/www/html/15_File_Upload/uploads \
    && chmod 777 /var/www/html/15_File_Upload/uploads

# Set permission agar Apache bisa membaca file
RUN chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80

# Jalankan Apache
CMD ["apache2-foreground"]
