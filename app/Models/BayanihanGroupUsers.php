<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BayanihanGroupUsers extends Model
{
    use HasFactory;
    protected $table = 'bayanihan_group_users';

    protected $primaryKey = 'bgu_id';

    protected $fillable = [
        'user_id',
        'bg_id',
        'bg_role',
    ];

    /**
     * Relationships
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bayanihanGroup()
    {
        return $this->belongsTo(BayanihanGroup::class, 'bg_id');
    }
}
