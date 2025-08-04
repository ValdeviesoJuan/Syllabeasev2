<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Memo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'file_name',
        'date',
        'user_id',
        'color',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // ✅ Relationship: Memo belongs to a User (uploader)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
