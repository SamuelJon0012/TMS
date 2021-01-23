#chmod -R 777 /var/www/app/*
#chown -R www-data:www-data /var/www/app/*
php artisan config:clear
php artisan cache:clear
php artisan route:clear
composer dump-autoload
