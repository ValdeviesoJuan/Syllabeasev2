<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Deadline extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable; 

    protected $primaryKey = 'dl_id';
    protected $fillable = [
        'dl_syll',
        'dl_tos_midterm',
        'dl_tos_final',
        'dl_school_year',
        'dl_semester',
        'user_id',
        'college_id'
    ];
}
