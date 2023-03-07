# How to use
- * Clone the project with git clone
- * Copy .env.example file to .env and edit database credentials & add the WEATHER_API_KEY value which you can generate from https://openweathermap.org/api
- * Run composer install
- * Run php artisan key:generate
- * Run php artisan migrate
- * That's it: Now test the api using API collection provided in the public/postman-collection folder