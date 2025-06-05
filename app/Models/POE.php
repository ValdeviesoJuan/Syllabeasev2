<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class POE extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable; 

    protected $table= 'poes';
    protected $primaryKey = 'poe_id';
    protected $fillable = [
        'department_id',
        'poe_code',
        'poe_description',
    ];
}
