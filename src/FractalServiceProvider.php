<?php

namespace Nord\Lumen\Fractal;

use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application;
use Nord\Lumen\Fractal\Contracts\FractalService as FractalServiceContract;

class FractalServiceProvider extends ServiceProvider
{

    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->registerContainerBindings($this->app, $this->app['config']);
    }


    /**
     * @param Application|Container $app
     * @param ConfigRepository      $config
     */
    protected function registerContainerBindings(Application $app, ConfigRepository $config)
    {
        $app->configure('fractal');

        $app->singleton(FractalService::class, function () use ($config) {
            $fractal = new FractalService();

            $this->configureService($fractal, $config->get('fractal'));

            return $fractal;
        });

        $app->alias(FractalService::class, FractalServiceContract::class);

        if (!class_exists(FractalService::class)) {
            class_alias(FractalFacade::class, 'Fractal');
        }
    }


    /**
     * @param FractalService $service
     * @param array          $config
     */
    protected function configureService(FractalService $service, array $config)
    {
        if (!empty($config['default_serializer'])) {
            $service->setDefaultSerializer(new $config['default_serializer']);
        }
    }
}
