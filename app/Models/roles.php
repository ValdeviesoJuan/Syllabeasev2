<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Role extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable; 
    
    protected $primaryKey = 'role_id'; // <-- Fix typo and use correct column
    protected $table = 'roles';
    protected $fillable = [
        'role_id',
        'role_name',
    ];
}
