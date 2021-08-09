# Photobooth

This app provides a web based Photobooth application that can be used to also host a gallery of the images taken.
The gallery is updated automatically so no page re-loads are required.

### Setup
1. Clone repository
2. Install requirements for Laravel - `composer install`
3. Copy .env.example to .env
4. Install requirements for Vue - `npm i`
5. Build front end - `npm run build` or for dev `npm run dev`
6. View in your browser - either use `php artisan serve` or Laravel Valet to serve up your application.

### Routes
/ - the photobooth app itself
/gallery - View the gallery of photos taken from the booth
