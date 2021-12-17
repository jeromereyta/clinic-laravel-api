<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

Prepare your machine.

- This project uses docker. [Install Docker](https://docs.docker.com/install/)
- This project uses Sail and Doctrine

- composer install 
- sudo umount /mnt/c sudo mount -t drvfs C: /mnt/c -o metadata
- chmod 777 -R storage

cd /mnt/c/users/mark/projects/api


drwxrwxrwx 1 mark mark 4096 Nov 25 16:53 patients
drwxrwxrwx 1 1337 root 4096 Dec 14 17:53 patient-images
drwxrwxrwx 1 1337 root 4096 Dec 15 17:00 patient-files




Server Deployment:
composer install
php artisan jwt:secret
php artisan d:m:m
php artisan db:seed

