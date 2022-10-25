# Cafe DITA

Web Cafe DITA merupakan sistem pemantauan layanan kesehatan bagi penderita hipertensi di Puskesmas Karangan, Trenggalek, Jawa Timur.

## Cara Instalasi

Install dependency PHP dengan Composer

```
composer install
```

Install dependency JS dengan NPM

```
npm install
```

Setup .env

```
copy .env.example .env
```

Migrate dan Seed data default

```
php artisan migrate --seed
```

## Cara Run Project

Jalankan server

```
php artisan serve
```

Jalankan vite

```
npm run dev
```
