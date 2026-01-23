<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SliderTranslation extends Model
{
    protected $fillable = [
        'slider_id',
        'lang_code',
        'title',
        'small_text',
        'button_text',
    ];
}
