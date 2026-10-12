# TugasWeb-P10-BlogCRUD — Cara Eksekusi

## 1. Buat project Laravel
    composer create-project laravel/laravel TugasWeb-P10-BlogCRUD
    cd TugasWeb-P10-BlogCRUD

## 2. Salin file dari folder ini
Salin isi folder ini ke project (timpa jika diminta):
  routes/web.php
  app/Models/Post.php
  app/Http/Controllers/PostController.php
  app/Providers/AppServiceProvider.php
  database/migrations/2026_10_12_000000_create_posts_table.php
  database/factories/PostFactory.php
  database/seeders/DatabaseSeeder.php
  resources/views/**   (layouts, components, posts)

## 3. Database
Laravel 11/12 default memakai SQLite (langsung jalan, tanpa setting).
Jika ingin MySQL, ubah .env: DB_CONNECTION=mysql, DB_DATABASE=blog_crud, dst.

## 4. Jalankan
    php artisan migrate --seed
    php artisan storage:link
    php artisan serve

Buka http://127.0.0.1:8000

## 5. Cek route
    php artisan route:list --name=posts

## 6. Upload ke GitHub (repo: TugasWeb-P10-BlogCRUD)
    git init
    git add .
    git commit -m "Tugas P10 Blog CRUD Laravel"
    git branch -M main
    git remote add origin https://github.com/<username>/TugasWeb-P10-BlogCRUD.git
    git push -u origin main
