<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use OwenIt\Auditing\Contracts\Auditable;

class College extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable; 

    protected $primaryKey = 'college_id';
    protected $fillable = [
        'college_id',
        'college_code',
        'college_description',
        'college_status'
    ];

    /* -------------------------------------------------------------
     | Polymorphic link to every UserRole that points to this college
     |--------------------------------------------------------------
     */
    public function userRoles(): MorphMany
    {
        return $this->morphMany(UserRole::class, 'entity', 'entity_type', 'entity_id');
    }

    /* -------------------------------------------------------------
     | Convenience: all Dean assignments, past & present
     |--------------------------------------------------------------
     */
    public function deanRoles(): MorphMany
    {
        $deanRoleId = Roles::where('role_name', 'Dean')->value('role_id');

        return $this->userRoles()->where('role_id', $deanRoleId);
    }

    /* -------------------------------------------------------------
     | Convenience: the *current* dean (returns a single UserRole)
     |--------------------------------------------------------------
     */
    public function currentDean()
    {
        $deanRoleId = Roles::where('role_name', 'Dean')->value('role_id');
        $today      = today()->toDateString();

        return $this->deanRoles()
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
