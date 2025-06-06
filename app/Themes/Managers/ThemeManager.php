<?php

namespace App\Themes\Managers;

use App\Themes\Contracts\ThemeInterface;
use App\Themes\Strategies\DefaultTheme;

class ThemeManager
{
    private ThemeInterface $theme;

    public function __construct(ThemeInterface $theme)
    {
        $this->theme = $theme;
    }

    public function view(string $viewName, array $data = [])
    {
        $viewPath = $this->theme->getViewPath($viewName);
        return view($viewPath, $data);
    }

    public function layout()
    {
        return $this->theme->getLayoutPath();
    }
}