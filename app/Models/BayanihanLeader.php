<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class BayanihanLeader extends Model  implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable; 

    protected $primaryKey = 'bl_id';
    protected $fillable = [
        'bl_user_id',
        'bg_id',
    ];
    public function BayanihanGroup()
    {
        return $this->hasMany(BayanihanGroup::class, 'bg_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'bg_user_id');
    }
}
