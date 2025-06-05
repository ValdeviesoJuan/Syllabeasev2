<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CotFComment extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable; 

    protected $table = 'cot_f_comments';
    protected $primaryKey = 'cot_f_comment_id';
    protected $fillable = [
        'syll_co_out_id',
        'cot_f_comment_text',
        'user_id',
        'cot_f_comment_created_at',
        'cot_f_comment_resolved_at'
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->cot_f_comment_created_at = now();
        });
    }
}
