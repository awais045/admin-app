<?php

namespace BalajiDharma\LaravelMediaManager;

use Illuminate\Contracts\Foundation\Application;
use MediaUploader;
use Plank\Mediable\Jobs\CreateImageVariants;
use Plank\Mediable\Media;
use Plank\Mediable\SourceAdapters\SourceAdapterInterface;

class MediaManager
{
    /**
     * The Laravel application instance.
     *
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * @param  Application  $app
     */
    public function __construct($app = null)
    {
        if (! $app) {
            $app = app();   //Fallback when $app is not given
        }
        $this->app = $app;
    }

    public function getMediaTypeIcon(Media $media)
    {
        $fileType = $this->app['config']->get('media-manager.file_type_icons', []);
        $type = $media->extension;
        if ($media->aggregate_type == 'image') {
            $type = 'image';
        }

        return $fileType[$type] ?? '';
    }

    public function createFromSource($file, $type, $name, $alt, ?Media $media = null)
    {
        $mediaType = $this->getMediaTypes()[$type] ?? [];
        $mediaDisk = $mediaType['disk'] ?? 'public';
        $mediaDirectory = $mediaType['directory'] ?? 'media';

        $mediaModel = MediaUploader::fromSource($file)
            ->toDisk($mediaDisk)
            ->toDirectory($mediaDirectory);

        if ($name) {
            $mediaModel->useFilename($name);
        }

        if ($alt) {
            $mediaModel->withAltAttribute($alt);
        }

        $mediaModel->beforeSave(function (Media $model, SourceAdapterInterface $source) use ($type) {
            $model->setAttribute('variant_name', $type);
        });

        if ($media) {
            $originalMedia = $mediaModel->replace($media);
            $media->getAllVariants()->each(function (Media $variant) {
                $variant->delete();
            });
        } else {
            $originalMedia = $mediaModel->upload();
        }
        if ($originalMedia->aggregate_type == 'image') {
            $imageVariants = $mediaType['image_variants'] ?? [];

            if (! empty($imageVariants)) {
                CreateImageVariants::dispatch($originalMedia, $imageVariants);
            }
        }

        return $originalMedia;
    }

    public function getMediaTypes()
    {
        return $this->app['config']->get('media-manager.media_types', []);
    }

    public function getMediaTypeAsOptions()
    {
        $mediaTypes = $this->getMediaTypes();
        $options = [];
        foreach ($mediaTypes as $key => $value) {
            $options[$key] = $key;
        }

        return $options;
    }
}
