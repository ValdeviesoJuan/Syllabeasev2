<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SyllabusCoPo extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable; 

    protected $primaryKey = 'syll_co_po_id';
    protected $table = 'syll_co_pos';
    protected $fillable = [
        'syll_co_po_id',
        'syll_po_id',
        'syll_co_id',
        'syll_po_co_code',
        'syll_id',
    ];
}
