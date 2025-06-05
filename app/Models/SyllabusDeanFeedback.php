<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SyllabusDeanFeedback extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable; 

    protected $table = 'syllabus_dean_feedbacks';
    protected $primaryKey = 'syllabus_dean_feedback_id';
    protected $fillable = [
        'syll_id',
        'user_id',
        'syll_dean_feedback_text',
        'syll_dean_feedback_created_at',
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->syll_dean_feedback_created_at = now();
        });
    }
}
