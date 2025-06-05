<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Syllabus extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable; 


    protected $primaryKey = 'syll_id';
    protected $fillable = [
        'syll_id',
        'bg_id',
        'syll_class_schedule',
        'syll_bldg_rm',
        'syll_ins_consultation',
        'syll_ins_bldg_rm',
        'syll_course_description',
        'course_id',
        'college_id',
        'department_id',
        'curr_id',
        'syll_course_requirements',
        'syll_dean',
        'syll_chair',
        'chair_submitted_at',
        'dean_submitted_at',
        'chair_rejected_at',
        'dean_rejected_at',
        'dean_approved_at',
        'status',
        'version'
    ];
    public function SyllabusInstructors()
    {
        return $this->hasMany(SyllabusInstructor::class, 'syll_id', 'syll_id');
    }
}
