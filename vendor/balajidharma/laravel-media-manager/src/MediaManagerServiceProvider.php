<?php

namespace BalajiDharma\LaravelMediaManager;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Intervention\Image\Image;
use Plank\Mediable\Facades\ImageManipulator;
use Plank\Mediable\ImageManipulation;
use Plank\Mediable\Media;

class MediaManagerServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/media-manager.php', 'media-manager'
        );

        $this->registerDriver();
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        if (app()->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/media-manager.php' => config_path('media-manager.php'),
            ], ['config', 'media-manager-config', 'media-manager', 'admin-core', 'admin-core-config']);
        }

        // Define the image variants based on the config
        $this->defineImageVariants();
    }

    protected function registerDriver()
    {
        $imageDriver = config('media-manager.image_driver', 'gd');

        if ($imageDriver == 'imagick') {
            $this->app->bind(\Intervention\Image\Interfaces\DriverInterface::class,
                \Intervention\Image\Drivers\Imagick\Driver::class
            );
        } elseif ($imageDriver == 'gd') {
            $this->app->bind(\Intervention\Image\Interfaces\DriverInterface::class,
                \Intervention\Image\Drivers\Gd\Driver::class
            );
        }
    }

    protected function defineImageVariants()
    {
        $imageVariants = config('media-manager.image_variants');

        try {
            foreach ($imageVariants as $variantName => $variantConfig) {
                ImageManipulator::defineVariant(
                    $variantName,
                    $this->defineImageManipulation($variantConfig)
                );
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    protected function defineImageManipulation($variantConfig)
    {
        $imageManipulation = ImageManipulation::make(function (Image $image, Media $originalMedia) use ($variantConfig) {

            $method = $variantConfig['method'];
            $params = $variantConfig['params'];

            call_user_func_array([$image, $method], $params);

            if (isset($variantConfig['greyscale']) && $variantConfig['greyscale']) {
                $image->greyscale();
            }
        });

        if (isset($variantConfig['format'])) {
            $imageManipulation->setOutputFormat($variantConfig['format']);
        }

        if (isset($variantConfig['quality'])) {
            $imageManipulation->setOutputQuality($variantConfig['quality']);
        }

        return $imageManipulation;
    }
}
