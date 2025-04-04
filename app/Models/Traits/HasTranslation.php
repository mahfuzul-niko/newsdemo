<?php

namespace App\Models\Traits;

use App\Helpers\System;
use App\Models\Translation;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasTranslation
{
    public function translations(): MorphMany
    {
        return $this->morphMany(Translation::class, 'translateable');
    }

    public function translate($locale = null)
    {
        $locale = $locale ?: System::getLocale();

        if ($locale !== $this->locale) {
            // Use pluck to get column and value pairs and update the model attributes
            $translations = $this->translations()
                ->where('locale', $locale)
                ->pluck('value', 'column');

            foreach ($translations as $column => $value) {
                if($value !== null){
                    $this->$column = $value;
                }
            }
        }

        return $this;
    }

    public function addTranslation($locale, array $data)
    {
        // Use updateOrCreate in a loop for each column/value pair
        foreach ($data as $column => $value) {
            $this->translations()->updateOrCreate(
                ['locale' => $locale, 'column' => $column],
                ['value' => $value]
            );
        }
    }
}
