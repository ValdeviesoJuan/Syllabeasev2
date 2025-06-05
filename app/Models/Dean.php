<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Dean extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable; 
    
    protected $primaryKey = 'dean_id';
    protected $fillable = [
        'dean_id',
        'user_id',
        'college_id',
        'start_validity',
        'end_validity',
    ];
}
