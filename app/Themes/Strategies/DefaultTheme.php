<?php

namespace App\Themes\Strategies;

use App\Themes\Contracts\ThemeInterface;

class DefaultTheme implements ThemeInterface
{
    public function getViewPath(string $viewName): string
    {
        return "themes.default.{$viewName}";
    }

    public function getLayoutPath(): string
    {
        return "layouts.themes.default";
    }
}