<?php namespace trupedia\LaravelBladeHaml;

// Dependencies
use MtHaml;
use Illuminate\View\Engines\CompilerEngine;

class LaravelBladeHamlServiceProvider extends \Illuminate\Support\ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register() {

		// Bind the Haml compiler
		$this->app->singleton('haml.compiler', function($app) {

            $environment = config('blade-haml.mthaml.environment');

            if(is_null($environment))
                throw new Exception('Please publish the config file via: php artisan vendor:publish');

            // Instantiate MtHaml, the brains of the operation
            $mthaml = new MtHaml\Environment($environment, config('blade-haml.mthaml.options'), config('blade-haml.mthaml.filters'));

			// Instantiate our Laravel-style compiler
			$cache = $app['config']['view.compiled'];
			return new HamlCompiler($mthaml, $app['files'], $cache);
		});

	}

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot() {

        $this->publishes([
            __DIR__ . '/config/blade-haml.php' => config_path('blade-haml.php')
        ]);

		$app = $this->app;

		// Add the .haml.php extension and register the Haml compiler with
		// Laravel's view engine resolver
		$app['view']->addExtension('haml.php', 'haml', function() use ($app) {
			return new CompilerEngine($app['haml.compiler']);
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides() {
		return array('haml.compiler');
	}

}