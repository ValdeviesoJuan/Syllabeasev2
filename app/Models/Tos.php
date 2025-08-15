<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Tos extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable; 

    protected $table = 'tos';
    protected $primaryKey = 'tos_id';
    protected $fillable = [
        'syll_id',
        'user_id',
        'tos_term',
        'effectivity_date',
        'tos_no_items',
        'col_1_per',
        'col_2_per',
        'col_3_per',
        'col_4_per',
        'course_id',
        'department_id',
        'tos_cpys',
        'chair',
        'chair_submitted_at',
        'chair_returned_at',
        'chair_approved_at',
        'tos_status',
        'tos_version',
        'bg_id'
    ];
    protected $casts = [
        'chair_submitted_at' => 'datetime',
        'chair_returned_at' => 'datetime',
        'chair_approved_at' => 'datetime',
        'chair' => 'array',
    ];
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }
    public function bayanihanGroup()
    {
        return $this->belongsTo(BayanihanGroup::class, 'bg_id', 'bg_id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }
    public function syllabus()
    {
        return $this->belongsTo(Syllabus::class, 'syll_id', 'syll_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
