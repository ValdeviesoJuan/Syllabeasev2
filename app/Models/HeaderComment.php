<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class HeaderComment extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable; 

    protected $table = 'header_comments';
    protected $primaryKey = 'header_comment_id';
    protected $fillable = [
        'syll_id',
        'header_comment_text',
        'user_id',
        'header_comment_created_at',
        'header_comment_resolved_at'
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->header_comment_created_at = now();
        });
    }
}
