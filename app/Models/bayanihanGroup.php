<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 
use OwenIt\Auditing\Contracts\Auditable;

class BayanihanGroup extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable; 

    protected $primaryKey = 'bg_id';
    protected $fillable = [
        'bg_id',
        'course_id',
        'bg_school_year'
    ];

    public function members()
    {
        return $this->hasMany(BayanihanGroupUsers::class, 'bg_id')->where('bg_role', 'member');
    }

    public function leaders()
    {
        return $this->hasMany(BayanihanGroupUsers::class, 'bg_id')->where('bg_role', 'leader');
    }
}
