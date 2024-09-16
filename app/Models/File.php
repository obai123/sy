<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'path',
        'mime',
        'size',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
