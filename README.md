# Finanšu izsekošanas sistēma

![Image](https://github.com/user-attachments/assets/baa6fd61-80a4-4597-ae7c-a9290d53ba10)

## Projekta apraksts

Šī ir tīmekļa lietotne budžeta plānošanai un finanšu paradumu uzlabošanai. Lietotne ļauj lietotājiem veidot budžeta plānus, analizēt tēriņu paradumus, kā arī pārskatīt finanšu statistiku.
## Aktuālās funkcionalitātes

- Tēriņu pievienošana, rediģēšana un dzēšana pēc kategorijām
- Budžeta plāna izveide ar ikmēneša ienākumu un kategoriju limitiem
- Budžeta salīdzinājums ar faktiskajiem tēriņiem
- Tēriņu un budžeta vizualizācija
- Padomi un lasāmviela finanšu pamatu izzināšanai

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
