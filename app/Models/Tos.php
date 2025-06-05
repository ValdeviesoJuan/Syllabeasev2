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
        'tos_no_items',
        'col_1_per',
        'col_2_per',
        'col_3_per',
        'col_4_per',
        'course_id',
        'department_id',
        'tos_cpys',
        'chair_submitted_at',
        'chair_returned_at',
        'chair_approved_at',
        'tos_status',
        'tos_version',
        'bg_id'
    ];
}
