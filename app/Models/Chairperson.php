<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Chairperson extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable; 

    protected $primaryKey = 'chairman_id';
    protected $fillable = [
        'chairperson_id',
        'user_id',
        'department_id',
        'start_validity',
        'end_validity',
    ];
}
