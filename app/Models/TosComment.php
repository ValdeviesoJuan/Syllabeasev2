<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TosComment extends Model  implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable; 

    protected $table = 'tos_comments';
    protected $primaryKey = 'tos_comment_id';
    protected $fillable = [
        'tos_id',
        'col_no',
        'tos_comment_text',
        'user_id',
        'tos_comment_created_at',
        'tos_comment_resolved_at'
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->tos_comment_created_at = now();
        });
    }
}
