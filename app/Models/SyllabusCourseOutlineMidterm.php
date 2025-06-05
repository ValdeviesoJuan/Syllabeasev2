<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Events\Auditing;

class SyllabusCourseOutlineMidterm extends Model  implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use AuditableTrait;

    protected $auditColumn = 'syll_id';

    protected $table = 'syllabus_course_outlines_midterms';
    protected $primaryKey = 'syll_co_out_id';
    protected $fillable = [
        'syll_id',
        'syll_allotted_hour',
        'syll_allotted_time',
        'syll_intended_learning',
        'syll_suggested_readings',
        'syll_topics',
        'syll_learning_act',
        'syll_asses_tools',
        'syll_grading_criteria',
        'syll_remarks',
        'syll_row_no'
    ];
    public function courseOutcomes()
    {
        return $this->hasMany(SyllabusCotCoM::class, 'syll_co_out_id', 'syll_co_out_id');
    }
}
