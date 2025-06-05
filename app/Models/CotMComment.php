<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CotMComment extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable; 

    protected $table = 'cot_m_comments';
    protected $primaryKey = 'cot_m_comment_id';
    protected $fillable = [
        'syll_co_out_id',
        'cot_m_comment_text',
        'user_id',
        'cot_m_comment_created_at',
        'cot_m_comment_resolved_at'
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->cot_m_comment_created_at = now();
        });
    }
}
