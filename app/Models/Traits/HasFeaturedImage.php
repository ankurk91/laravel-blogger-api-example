<?php

namespace App\Models\Traits;

use App\Support\Uploader;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait HasFeaturedImage
{
    public static function bootHasFeaturedImage()
    {
        // Delete previous attachments before storing new
        static::updated(function (self $resource) {
            if (
                // There was a attachment originally
                $resource->getOriginal('featured_image') &&
                // The new attribute is different from previous
                $resource->isDirty('featured_image')) {
                static::deleteFeaturedImage($resource);
            }
        });

        // Delete attached files from storage
        static::deleted(function (self $resource) {
            static::deleteFeaturedImage($resource);
        });
    }

    protected function getFeaturedImageThumbFilePath(string $filePath)
    {
        return dirname($filePath).'/'.'thumb-'.basename($filePath);
    }

    public function initializeHasFeaturedImage()
    {
        $this->mergeFillable(['featured_image']);
        $this->appends[] = 'featured_image_url';
        $this->appends[] = 'featured_image_thumb_url';
        $this->hidden[] = 'featured_image';
    }

    public function setFeaturedImageAttribute(?\Illuminate\Http\UploadedFile $file)
    {
        // This means that user wants to delete previously stored files too
        if (is_null($file)) {
            $this->attributes['featured_image'] = null;

            return;
        }

        /**
         * @var \Intervention\Image\Image $image
         */
        $image = Image::make($file->getRealPath());

        // Resize image
        $image->resize(300, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $fileName = Uploader::generateName($file);
        $dirPath = Uploader::dirPath('featured_images');

        // Upload thumbnail
        Storage::put($dirPath.'/'."thumb-{$fileName}", $image->stream());

        // Upload original image
        $this->attributes['featured_image'] = Storage::putFileAs($dirPath, $file, $fileName);

        // Free up memory
        $image->destroy();
    }

    public function getFeaturedImageUrlAttribute()
    {
        if (! is_null($this->featured_image)) {
            return Storage::url($this->featured_image);
        }

        return null;
    }

    public function getFeaturedImageThumbUrlAttribute()
    {
        if (! is_null($this->featured_image)) {
            return Storage::url($this->getFeaturedImageThumbFilePath($this->featured_image));
        }

        return null;
    }

    public static function deleteFeaturedImage(self $resource)
    {
        if ($resource->getOriginal('featured_image')) {
            Storage::delete([
                $resource->getOriginal('featured_image'),
                $resource->getFeaturedImageThumbFilePath($resource->getOriginal('featured_image')),
            ]);
        }
    }
}
