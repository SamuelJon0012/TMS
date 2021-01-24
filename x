chmod -R 777 /var/www/dev/*
chown -R www-data:www-data /var/www/dev/*
php artisan config:clear
php artisan cache:clear
php artisan route:clear
composer dump-autoload
