<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'body',
        'image',
        'published',
        'user_id',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
/*
    public function getRouteKeyName()
    {
        return 'slug';
    }
*/
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($news) {
            if (!$news->slug) {
                $news->slug = Str::slug($news->title);
            }
        });
    }

    public function getExcerptAttribute()
    {
        $text = strip_tags($this->body);

        $short = Str::limit($text, 250, '');
        $ellipsis=strlen($short)>249?' ...':'';
        // убираем обрыв слова
        return preg_replace('/\s+?(\S+)?$/u', '', $short) . $ellipsis;
    }

}
