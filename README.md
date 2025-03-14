## Tutorial Menjalankan Program Backend Aplikasi POS

Installation Steps

1. Composer install

2. cp .env.example .env

3. php artisan key:generate

4. Ubah nama database

5. DB_DATABASE=your_database_name

6. Set password untuk database

7. DB_PASSWORD=your_password

8. php artisan migrate:refresh --seed

9. php artisan storage:link
10. Jalankan perintah Php artisan serve, atau perintah php artisan serve --host=192.168.43.88 --port=8000, ubah ip sesuai ip jaringan wifi yang digunakan oleh komputer/pc
