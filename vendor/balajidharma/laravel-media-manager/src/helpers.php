<?php

if (! function_exists('media_manager')) {
    /**
     * Get the Debugbar instance
     *
     * @return \BalajiDharma\LaravelMediaManager\MediaManager
     */
    function media_manager()
    {
        return app(\BalajiDharma\LaravelMediaManager\MediaManager::class);
    }
}

if (! function_exists('media_type_icon')) {
    function media_type_icon($media)
    {
        return media_manager()->getMediaTypeIcon($media);
    }
}

if (! function_exists('media_type_as_options')) {
    function media_type_as_options()
    {
        return media_manager()->getMediaTypeAsOptions();
    }
}
