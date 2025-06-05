<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class bayanihanMember extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable; 

    protected $primarykey = 'bm_id';
    protected $fillable = [
        'bg_user_id',
        'bg_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'bm_user_id');
    }
}
