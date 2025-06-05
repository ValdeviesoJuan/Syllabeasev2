<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SyllabusInstructor extends Model  implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable; 

    protected $primaryKey = 'syll_ins_id';
    protected $fillable = [
        'syll_ins_id',
        'syll_ins_user_id',
        'syll_id'
    ];
    public function Syllabus()
{
    return $this->hasMany(Syllabus::class, 'syll_id');
}
}
