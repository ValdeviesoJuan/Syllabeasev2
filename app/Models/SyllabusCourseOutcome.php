<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SyllabusCourseOutcome extends Model  implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable; 

    protected $primaryKey = 'syll_co_id';
    protected $fillable = [
        'syll_co_code',
        'syll_co_description',
        'syll_id',
    ];
}
