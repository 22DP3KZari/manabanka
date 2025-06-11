# Finanšu izsekošanas sistēma

![Image](https://github.com/user-attachments/assets/baa6fd61-80a4-4597-ae7c-a9290d53ba10)

## Projekta apraksts

Šī ir tīmekļa lietotne personīgo finanšu pārvaldībai un izsekošanai. Lietotne ļauj lietotājiem veidot budžeta plānus, analizēt tēriņu paradumus, kā arī pārskatīt finanšu statistiku.

## Galvenās funkcionalitātes

- Ienākumu un izdevumu pievienošana, rediģēšana un dzēšana
- Budžeta plānošana balstīta pēc lietotāja paradumiem un tēriņiem
- Bilances un statistikas apskate (chart)
- Lietotāja pievienošana/autentifikācija
- Datu eksportēšana
- Drošības un privātuma aizsardzība

## Izmantotās tehnoloģijas

### Back-end

- Laravel Framework
- MySQL

### Front-end

- Apache
- CSS

## Uzstādīšana

### Prasības
- PHP
- Composer
- MySQL

### Back-end palaišana

```bash
cd backend
composer install

cp .env.example .env # Jāiestata datubāzes parametri

php artisan key:generate
php artisan migrate --seed
php artisan serve
```

### Front-end palaišana

```bash
cd frontend
npm install
npm run dev
```
---
