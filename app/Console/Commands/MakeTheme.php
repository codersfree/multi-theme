<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class MakeTheme extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:theme {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected Filesystem $filesystem;

    protected $themeSlug;
    protected $studlyName;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->filesystem = new Filesystem();

        $this->themeSlug = Str::slug(Str::snake($this->argument('name')));
        $this->studlyName = Str::studly($this->themeSlug);

        $this->createStrategyClass();
        $this->createLayoutBlade();
        $this->createWelcomeView();
        $this->updateThemeFactory();

        return Command::SUCCESS;
    }

    protected function createStrategyClass(): void
    {
        $path = app_path("Themes/Strategies/{$this->studlyName}Theme.php");
        $content = $this->getStrategyContent();
        $successMsg = "Strategy class created successfully: {$path}";
        $errorMsg = "Strategy class already exists: {$path}";

        $this->createFile($path, $content, $successMsg, $errorMsg);
    }

    protected function createLayoutBlade(): void
    {
        $path = resource_path("views/components/layouts/themes/{$this->themeSlug}.blade.php");
        $content = $this->getLayoutBladeContent();
        $successMsg = "Layout blade created successfully: {$path}";
        $errorMsg = "Layout blade already exists: {$path}";

        $this->createFile($path, $content, $successMsg, $errorMsg);
    }

    protected function createWelcomeView(): void
    {
        $path = resource_path("views/themes/{$this->themeSlug}/welcome.blade.php");
        $content = $this->getWelcomeViewContent();
        $successMsg = "Welcome view created successfully: {$path}";
        $errorMsg = "Welcome view already exists: {$path}";

        $this->createFile($path, $content, $successMsg, $errorMsg);
    }

    protected function updateThemeFactory(): void
    {
        $path = app_path('Themes/Factories/ThemeFactory.php');
        $content = $this->getThemeFactoryContent();

        $this->filesystem->put($path, $content);

        $this->info("Theme factory updated successfully: {$path}");
    }

    protected function getStrategyContent(): string
    {
        return <<<PHP
        <?php

        namespace App\Themes\Strategies;

        use App\Themes\Contracts\ThemeInterface;

        class {$this->studlyName}Theme implements ThemeInterface
        {
            public function getViewPath(string \$viewName): string
            {
                \$viewPath = "themes.{$this->themeSlug}.{\$viewName}";

                if (!view()->exists(\$viewPath)) {
                    \$viewPath = "themes.default.{\$viewName}";
                }

                return \$viewPath;
            }

            public function getLayoutPath(): string
            {
                \$layoutPath = "layouts.themes.{$this->themeSlug}";

                if (!view()->exists('components.' . \$layoutPath)) {
                    \$layoutPath = "layouts.themes.default";
                }
                
                return \$layoutPath;
            }
        }
        PHP;
    }

    protected function getLayoutBladeContent(): string
    {
        return <<<BLADE
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>
                Layout - {$this->studlyName} Theme
            </title>
        </head>
        <body>
            {{ \$slot }}
        </body>
        </html>
        BLADE;
    }

    protected function getWelcomeViewContent(): string
    {
        return <<<BLADE
        <x-layouts.app>
            <h1>
                Esta es la página de bienvenida
            </h1>
        </x-layouts.app>
        BLADE;
    }

    public function getThemeFactoryContent(): string
    {
        $strategyPath = app_path('Themes/Strategies');

        $themes = collect($this->filesystem->files($strategyPath))
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
            return "use App\\Themes\\Strategies\\{$class};";
        })->implode("\n");

        $cases = $themes->map(function($class, $key){
            return "'{$key}' => new {$class}(),";
        })->implode("\n            ");

        return <<<PHP
        <?php

        namespace App\Themes\Factories;

        use App\Themes\Contracts\ThemeInterface;
        {$imports}

        class ThemeFactory
        {
            public static function make(string \$themeName): ThemeInterface
            {
                return match (\$themeName) {
                    {$cases}
                    default => throw new \InvalidArgumentException("Theme {\$themeName} not found"),
                };
            }
        }
        PHP;
    }

    public function createFile(string $path, string $content, string $successMsg, string $errorMsg): void
    {
        if (!$this->filesystem->exists($path)) {
            $this->filesystem->ensureDirectoryExists(dirname($path));
            $this->filesystem->put($path, $content);
            $this->info($successMsg);
        }else{
            $this->warn($errorMsg);
        }
    }
}
