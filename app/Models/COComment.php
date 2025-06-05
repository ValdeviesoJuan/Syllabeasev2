<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class COComment extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable; 

    protected $table = 'co_comments';
    protected $primaryKey = 'co_comment_id';
    protected $fillable = [
        'syll_co_id',
        'co_comment_text',
        'user_id',
        'co_comment_created_at',
        'co_comment_resolved_at'
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->co_comment_created_at = now();
        });
    }
}
