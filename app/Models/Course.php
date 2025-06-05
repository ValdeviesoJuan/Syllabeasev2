<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Course extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable; 

    protected $primaryKey = 'course_id';
    protected $fillable = [
        'course_id',
        'curr_id',
        'course_title',
        'course_code',
        'course_unit_lec',
        'course_unit_lab',
        'course_credit_unit',
        'course_hrs_lec',
        'course_hrs_lab',
        'course_pre_req',
        'course_co_req',
        'course_year_level',
        'course_semester'
    ];
}
