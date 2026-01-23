<?php

namespace Modules\Category\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    use HasFactory;
    
    protected $fillable = ['category_id', 'lang_code', 'name'];
}
