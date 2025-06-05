<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SyllabusCotCoF extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable; 

    protected $table = 'syllabus_cot_cos_finals';
    protected $primaryKey = 'syll_cot_co';
    protected $fillable = [
        'syll_co_out_id',
        'syll_co_id',
    ];
}
