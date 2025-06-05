<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Curriculum extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable; 

    protected $primaryKey = 'curr_id';
    protected $fillable = [
        'curr_id',
        'department_id',
        'curr_code',
        'effectivity',
    ];
}
