<?php

namespace App\Themes\Contracts;

interface ThemeInterface
{
    public function getViewPath(string $viewName): string;
    public function getLayoutPath(): string;
}