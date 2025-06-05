<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BayanihanLeader;
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

    public function BayanihanLeaders()
    {
        return $this->hasMany(BayanihanLeader::class, 'bg_id', 'bg_id');
    }

    public function BayanihanMembers()
    {
        return $this->hasMany(BayanihanMember::class, 'bg_id', 'bg_id');
    }
}
