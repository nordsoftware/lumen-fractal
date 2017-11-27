<?php

namespace Nord\Lumen\Fractal;

use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;
use Nord\Lumen\Fractal\Contracts\FractalService as FractalServiceContract;

class FractalServiceProvider extends ServiceProvider
{
    private const CONFIG_KEY = 'fractal';

    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->app->configure(self::CONFIG_KEY);

        $this->registerBindings($this->app, $this->app['config']);
    }

    /**
     * @param Container        $container
     * @param ConfigRepository $config
     */
    protected function registerBindings(Container $container, ConfigRepository $config)
    {
        $container->singleton(FractalService::class, function () use ($config) {
            $fractal = new FractalService();

            $this->configureService($fractal, $config[self::CONFIG_KEY]);

            return $fractal;
        });

        $container->alias(FractalService::class, FractalServiceContract::class);
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
