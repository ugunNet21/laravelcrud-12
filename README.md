<!-- How To -->
### How to use this code Laravel 12 and other library
1. Clone the repository to your local machine.
2. Install the required packages by running the command `composer install` in the terminal.
3. Create a new database and update the `.env` file with your database credentials.
4. Run the command `php artisan migrate` to create the tables in the database.
5. Run the command `php artisan db:seed` to seed the database with some data.
6. You can now access the API by running the command `php artisan serve` and visiting
`http://localhost:8000/api/users` in your web browser.
7. You can use a tool like Postman to test the API endpoints.
8. You can also use a library like Guzzle to make HTTP requests to the API.

### Install the required packages

## Install package

````
composer require laravel/wayfinder --dev

````

## install Nwidart modules

- penyebab sering eror adalah terkait mendaftarkan module dengan alamat namespace dan folder yg beda hasil generate module, jadi harus ganti ulang harus disamakan

````
composer require --dev nwidart/laravel-modules
php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider"

````

````
{
  "autoload": {
    "psr-4": {
      "App\\": "app/",
      "Modules\\": "Modules/"
    }
  }
}

````

### Daftarkan di Config/app.php

````
'providers' => [
    Modules\ChatDating\app\Providers\ChatDatingServiceProvider::class, // perhatikan alamat harus sesuai dengan namespace dan penulisan folder
],

````
## di module json perhatikan alamat namespace dan penulisan folder

````
    "providers": [

        "Modules\\ChatDating\\app\\Providers\\ChatDatingServiceProvider"
    ],

````

- cek namespace di controller dan seeder harus sama
- cek namespace di model harus sama

### Install Laravolt

````
composer require laravolt/indonesia
php artisan vendor:publish --provider="Laravolt\Indonesia\ServiceProvider"
php artisan laravolt:indonesia:seed

````

### Install Spatie

````
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

````

## Running Seeder

````
php artisan db:seed --class=Modules\\ChatDating\\database\\seeders\\UserChatSeeder
php artisan db:seed --class=Modules\\ChatDating\\database\\seeders\\FriendshipSeeder
php artisan db:seed --class=Modules\\ChatDating\\database\\seeders\\MessageSeeder

````