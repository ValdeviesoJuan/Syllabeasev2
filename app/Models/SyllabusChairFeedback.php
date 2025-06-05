<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SyllabusChairFeedback extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable; 

    protected $table = 'syllabus_chair_feedbacks';
    protected $primaryKey = 'syll_chair_feedback_id';
    protected $fillable = [
        'syll_id',
        'user_id',
        'syll_chair_feedback_text',
        'syll_chair_feedback_created_at'
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->syll_chair_feedback_created_at = now();
        });
    }
}
