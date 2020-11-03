<?php 

namespace Twinkle\Themes;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
/**
 * 
 */
class ThemeServiceProvider extends ServiceProvider
{
	public function register()
	{
		
	}

	public function boot()
	{
		if ($this->app->runningInConsole()) {
			$this->commands([
				ThemeGenerate::class,
			]);
		}

		$file = file_get_contents( base_path().'/twinkle/Themes/theme.json');
		$themes = json_decode($file, true);
		foreach ($themes as $theme) {
			if ($theme['status'] == 'active') {
				$this->loadRoutesFrom(__DIR__.'/'.$theme['Text Domain'].'/routes/web.php');
				$this->loadMigrationsFrom(__DIR__.'/'.$theme['Text Domain'].'/migrations');
				$this->loadViewsFrom(__DIR__.'/'.$theme['Text Domain'].'/views', 'theme');
			}
		}

		$this->publishes([
			__DIR__.'/theme.json' => base_path('twinkle/Themes/theme.json'),
		], 'theme');
	}
}