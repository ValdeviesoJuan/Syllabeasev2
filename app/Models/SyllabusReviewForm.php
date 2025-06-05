<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SyllabusReviewForm extends Model implements Auditable 
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'syllabus_review_forms';
    protected $primaryKey = 'srf_id';
    protected $fillable = [
        'srf_id',
        'syll_id',
        'srf_course_code',
        'srf_title',
        'srf_sem_year',
        'srf_faculty',
        'user_id',
        'srf_date',
        'srf_reviewed_by',
        'srf_action',
    ];
}
