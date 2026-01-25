<?php

namespace Modules\Category\Entities;

use Modules\Project\App\Models\Project;
use Modules\Listing\Entities\Listing;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $appends = ['name', 'total_projects'];

    protected $hidden = ['front_translate', 'projects'];

    public function translate(){
        return $this->belongsTo(CategoryTranslation::class, 'id', 'category_id')->where('lang_code', admin_lang());
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function front_translate(){
        return $this->belongsTo(CategoryTranslation::class, 'id', 'category_id')->where('lang_code', front_lang());
    }

    public function getNameAttribute()
    {
        return $this->front_translate->name;
    }

    public function services(){
        return $this->hasMany(Listing::class)->where(['status' => 'enable', 'approved_by_admin' => 'approved']);
    }

    public function getTotalProjectsAttribute()
    {
        return $this->projects()->where('status', 'enable')->count();
    }

    public function subcategories()
{
    return $this->hasMany(SubCategory::class);
}

}
