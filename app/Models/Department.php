<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
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

    public function college()
    {
        return $this->belongsTo(College::class, 'college_id');
    }
    /* -------------------------------------------------------------
     | Polymorphic link to every UserRole that points to this department
     |--------------------------------------------------------------
     */
    public function userRoles(): MorphMany
    {
        return $this->morphMany(UserRole::class, 'entity', 'entity_type', 'entity_id');
    }

    /* -------------------------------------------------------------
     | Convenience: all Chairperson assignments, past & present
     |--------------------------------------------------------------
     */
    public function chairpersonRoles(): MorphMany
    {
        $chairRoleId = Roles::where( 'role_name', 'Chairperson')->value('role_id');

        return $this->userRoles()->where('role_id', $chairRoleId);
    }

    /* -------------------------------------------------------------
     | Convenience: the *current* chairperson (returns a single UserRole)
     |--------------------------------------------------------------
     */
    public function currentChairperson()
    {
        $chairRoleId = Roles::where('role_name', 'Chairperson')->value('role_id');
        $today       = today()->toDateString();

        return $this->chairpersonRoles()
            ->where(function ($q) use ($today) {
                $q->whereNull('start_validity')
                  ->orWhere('start_validity', '<=', $today);
            })
            ->where(function ($q) use ($today) {
                $q->whereNull('end_validity')
                  ->orWhere('end_validity', '>=', $today);
            })
            ->latest('start_validity')
            ->first();
    }
}
