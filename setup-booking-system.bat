@echo off
echo Setting up Shoe Cleaning Booking System...
echo.

echo Running migrations...
php artisan migrate

echo.
echo Seeding services data...
php artisan db:seed --class=ServiceSeeder

echo.
echo Creating admin user...
php artisan make:filament-user

echo.
echo Setup completed! You can now access the admin panel at: http://localhost/fadil/laravel-project/public/admin
echo.
pause