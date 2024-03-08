<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class Medicine extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasTranslations;

    protected $fillable = ['commercial_name', 'description', 'scientific_name'];
    protected $hidden = ['created_at', 'updated_at', 'company_id', 'category_id'];
    public $translatable = ['commercial_name', 'description', 'scientific_name'];

    public function details() {
        return $this->hasMany(MedicineDetails::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function warehouse() {
        return $this->belongsTo(Warehouse::class);
    }

    public function pharmacist() {
        return $this->belongsToMany(Pharmacist::class, 'favorites');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('details')
              ->width(200)
              ->height(200)
              ->keepOriginalImageFormat();


        $this->addMediaConversion('main')
                // ->fit(Manipulations::FIT_STRETCH, 200, 200);
                ->width(120)
                ->height(120)
                ->keepOriginalImageFormat();
    }
}
