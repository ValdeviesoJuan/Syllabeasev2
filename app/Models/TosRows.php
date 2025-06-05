<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TosRows extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable; 

    protected $table = 'tos_rows';
    protected $primaryKey = 'tos_r_id';
    protected $fillable = [
        'tos_r_topic',
        'tos_r_no_hours',
        'tos_r_percent',
        'tos_r_no_items',
        'tos_r_col_1',
        'tos_r_col_2',
        'tos_r_col_3',
        'tos_r_col_4',
    ];
}
