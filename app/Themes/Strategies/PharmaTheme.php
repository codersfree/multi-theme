<?php

namespace App\Themes\Strategies;

use App\Themes\Contracts\ThemeInterface;

class PharmaTheme implements ThemeInterface
{
    public function getViewPath(string $viewName): string
    {
        $viewPath = "themes.pharma.{$viewName}";

        if (!view()->exists($viewPath)) {
            $viewPath = "themes.default.{$viewName}";
        }

        return $viewPath;
    }

    public function getLayoutPath(): string
    {
        $layoutPath = "layouts.themes.pharma";

        if (!view()->exists('components.' . $layoutPath)) {
            $layoutPath = "layouts.themes.default";
        }
        
        return $layoutPath;
    }
}