<style>
img[src*='#center'] { 
    width: 200px;
    display: block;
    margin: auto;
}
</style>

![FAQ system logo](https://github.com/president-tuychiyev/faq-system/blob/main/public/logo.png?raw=true#center)

# FAQ system

Installation

```bash
git clone https://github.com/president-tuychiyev/faq-system.git

cd faq-system

composer install

cp .env.example .env

php artisan key:generate

npm i
```

Connect to the database and run the following command

```bash
php artisan migrate:fresh --seed

php artisan serve
```
You need to access the following url to access the admin panel
- <you-ip:port>/login
- Email: faq@gmail.com
- password: 123456