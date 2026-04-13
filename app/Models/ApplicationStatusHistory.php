<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationStatusHistory extends Model
{
    /** @use HasFactory<\Database\Factories\ApplicationStatusHistoryFactory> */
    use HasFactory;

    protected $fillable = [
        'application_id',
        'changed_by',
        'old_status',
        'new_status',
        'changed_at',
    ];

    public $timestamps = false;

    protected $casts = [
        'changed_at' => 'datetime',
    ];

    public function application(){
        return $this->belongsTo(Application::class, 'application_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'changed_by');
    }
}
