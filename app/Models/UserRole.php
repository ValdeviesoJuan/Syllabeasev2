<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\College;
use App\Models\Department;

class UserRole extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable; 

    protected $primaryKey = 'ur_id';
    protected $fillable = [
        'user_id',
        'role_id',
        'entity_type',
        'entity_id',
        'start_validity',
        'end_validity',
    ];

    /**
     * Get the owning entity (College or Department).
     */
    public function entity()
    {
        return $this->morphTo(__FUNCTION__, 'entity_type', 'entity_id');
    }

    /**
     * Get the user that owns this role.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the role (e.g. dean, chairperson, etc.).
     */
    public function role()
    {
        return $this->belongsTo(Roles::class, 'role_id');
    }
}
