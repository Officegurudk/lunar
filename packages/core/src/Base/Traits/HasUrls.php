<?php

namespace Lunar\Base\Traits;

use Illuminate\Database\Eloquent\Model;
use Lunar\Models\Url;

trait HasUrls
{
    /**
     * Boot the trait.
     *
     * @return void
     */
    public static function bootHasUrls()
    {
        if (! config('lunar.features.urls', true)) {
            return;
        }

        static::created(function (Model $model) {
            $generator = config("lunar.urls.generator", null);
            if ($generator) {
                app($generator)->handle($model);
            }
        });

        static::deleted(function (Model $model) {
            if (!$model->deleted_at) {
                $model->urls()->delete();
            }
        });
    }

    /**
     * Get all of the models urls.
     */
    public function urls()
    {
        return $this->morphMany(Url::class, "element");
    }

    public function defaultUrl()
    {
        return $this->morphOne(Url::class, "element")->whereDefault(true);
    }
}
