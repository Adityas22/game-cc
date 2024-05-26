# Gunakan image resmi PHP sebagai base image
FROM php:apache

# Salin konten dari direktori saat ini ke /var/www/html di dalam kontainer
COPY . /var/www/html/

# Setel izin untuk direktori dan file
RUN chmod -R 755 /var/www/html

# Buat file konfigurasi Apache yang baru
RUN echo '<Directory "/var/www/html">\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride None\n\
    Require all granted\n\
</Directory>\n' > /etc/apache2/conf-available/custom-directory.conf

# Aktifkan konfigurasi Apache yang baru
RUN a2enconf custom-directory

# Ekspos port 80
EXPOSE 80

# Jalankan Apache di foreground
CMD ["apache2-foreground"]
