const elixir = require('laravel-elixir');
require('laravel-elixir-webpack-official')
require('laravel-elixir-vue');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(mix => {
    mix.sass('app.scss')
       .webpack('app.js');

mix.styles([
    'Adres/Adres.css',
    'Adres/Datepicker.css',
], 'public/assets/css/adres/adres.css');


mix.scripts([
    'Adres/MaakBrief.js',
    'Adres/MailBrief.js',
    'Adres/validation.js',
    'Adres/Datepicker.js',
    'ui.datepicker-nl.js'
], 'public/assets/js/adres/adres.js');

mix.scripts([
    'MaakBrief/maak.js',
    'MaakBrief/mail_brief.js',
    'Adres/validation.js',
    'Adres/Datepicker.js',
    'ui.datepicker-nl.js'
], 'public/assets/js/brief/brief.js');
});


