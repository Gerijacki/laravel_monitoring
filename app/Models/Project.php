<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'api_token',
        'project_category_id',
    ];

    public function category()
    {
        return $this->belongsTo(ProjectCategory::class, 'project_category_id');
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    protected static function booted(): void
    {
        static::creating(function (Project $project) {
            $project->slug = Str::slug($project->name);
            $project->api_token = hash('sha256', Str::random(60));
        });
    }
}
