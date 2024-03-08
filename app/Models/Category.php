<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class Category extends Model implements HasMedia
{
    use HasFactory, HasTranslations, InteractsWithMedia;

    public $translatable = ['name'];

    public function medicines() {
        return $this->hasMany(Medicine::class);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('card')
            ->crop(Manipulations::CROP_CENTER, 120, 120)
            ->fit(Manipulations::FIT_MAX, 120,120)
            //   ->width(120)
            //   ->height(120)
            ->keepOriginalImageFormat();
    }
}
