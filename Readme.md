# Project - SIAMIV2

## Aplikasi yang Dibutuhkan
### Development
- NodeJS : 20.14.0
- PHP : 8.3.8
- MySQL : 8.xx
- Composer : 2.7.6
- Laravel 11.26.0
### Production
- Docker : 25.0.3
- Docker Compose : 1.29

## Pemasangan
### Development
- download project dari git
    ```sh
    git clone https://github.com/reshap0318/PRJK_SIAMIV2.git project
    ```
- buka folder project
    ```sh
    cd project
    ```
- buka folder fe
    ```sh
    cd fe
    ```
- install fe
    ```sh
    yarn
    ```
- jalankan fe
    ```sh
    yarn dev
    ```
- buka folder be
    ```sh
    cd be
    ```
- install be
    ```sh
    composer install
    ```
- init data
    ```sh
    php artisan migrate:fresh --seed
    ```
- jalankan be
    ```sh
    php artisan serve
    ```
- access [http://localhost:5173](http://localhost:5173)
### Production
- generate aplikasi untuk production
    ```sh
    docker-compose up -d
    ```
