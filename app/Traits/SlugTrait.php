<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

trait SlugTrait
{
    public static function bootSlugTrait()
    {
        // Log::info("bootSlugTrait loaded"); // 👈 kiểm tra trait có được gọi không

        static::creating(function ($model) {
            Log::info("Creating book...");
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name ?? $model->title);
            }
        });

        static::updating(function ($model) {
            // Log::info("Updating book...");
            // Log::info("Dirty fields", $model->getDirty());

            if ($model->isDirty('name') || $model->isDirty('title')) {
                Log::info("Slug will be updated");
                $model->slug = Str::slug($model->name ?? $model->title);
            }
        });
    }
}
