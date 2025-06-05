<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SrfChecklist extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable; 

    protected $table = 'srf_checklists';
    protected $primaryKey = 'srf_checklist_id';
    protected $fillable = [
        'srf_id',
        'srf_no',
        'srf_yes_no',
        'srf_remarks',
    ];
}
