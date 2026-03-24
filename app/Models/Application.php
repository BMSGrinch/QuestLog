<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    /** @use HasFactory<\Database\Factories\ApplicationFactory> */
    use HasFactory;

    Protected $fillable =[
        'candidate_id',
        'job_offer_id',
        'company_name',
        'position',
        'job_link',
        'status',
        'applied_at',
        'notes',
    ];

    protected $casts = [
        'applied_at' => 'datetime',
    ];

    public function candidate(){
        return $this->belongsTo(User::class, 'candidate_id');
    }

    public function jobOffer(){
        return $this->belongsTo(JobOffer::class, 'job_offer_id');
    }

    public function applicationStatusHistories(){
        return $this->hasMany(ApplicationStatusHistory::class);
    }
}
