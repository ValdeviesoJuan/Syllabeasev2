<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TosRowComment extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable; 

    protected $table = 'tos_row_comments';
    protected $primaryKey = 'tos_r_comment_id';
    protected $fillable = [
        'tos_r_id',
        'col_no',
        'tos_r_comment_text',
        'user_id',
        'tos_r_comment_created_at',
        'tos_r_comment_resolved_at'
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->tos_r_comment_created_at = now();
        });
    }
}
