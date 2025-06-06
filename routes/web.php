<?php

use App\Themes\Facades\Theme;
use App\Themes\Factories\ThemeFactory;
use App\Themes\Managers\ThemeManager;
use App\Themes\Strategies\DefaultTheme;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    /* $theme = app('theme');
    return $theme->view('welcome'); */

    return Theme::view('welcome', ['name' => 'World']);

});
