<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Department extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable; 

    protected $primaryKey = 'department_id';
    protected $fillable = [
        'college_id',
        'department_code',
        'department_name',
        'program_code',
        'program_name',
        'department_status',
        'college_id'
    ];
}
