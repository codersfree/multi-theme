<?php

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get('/', function () {

    $filesystem = new Filesystem();

    $strategyPath = app_path('Themes/Strategies');

    $themes = collect($filesystem->files($strategyPath))
        ->filter(function ($file) {
            return Str::endsWith($file->getFilename(), 'Theme.php');
        })->mapWithKeys(function($file){

            $class = $file->getFilenameWithoutExtension(); //DefaultTheme
            $key = Str::kebab(Str::before($class, 'Theme')); //default

            return [
                $key => $class,
            ];
        });

    $imports = $themes->map(function($class){
        return "use App\\Themes\\Contracts\\{$class};";
    })->implode("\n");

    $cases = $themes->map(function($class, $key){
        return "'{$key}' => new {$class}(),";
    })->implode("\n");

    return $cases;
});
