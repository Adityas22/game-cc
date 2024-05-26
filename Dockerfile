# Gunakan image resmi PHP sebagai base image
FROM php:apache

# Salin konten dari direktori saat ini ke /var/www/html di dalam kontainer
COPY . /var/www/html/

# Ekspos port 80
EXPOSE 80

# Jalankan Apache di foreground
CMD ["apache2-foreground"]
