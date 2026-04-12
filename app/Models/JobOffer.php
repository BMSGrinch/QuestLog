<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOffer extends Model
{
    /** @use HasFactory<\Database\Factories\JobOfferFactory> */
    use HasFactory;

    Protected $fillable = [
        'recruiter_id',
        'title',
        'company',
        'description',
        'location',
        'contract_type',
        'salary',
        'experience_min',
        'experience_max',
        'skills_required',
        'application_deadline',
        'remote_policy',
        'status',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'application_deadline' => 'date',
    ];

    public function recruiter(){
        return $this->belongsTo(User::class, 'recruiter_id');
    }

    // Plusieurs candidatures peuvent être associées à une offre d'emploi
    public function applications(){
        return $this->hasMany(Application::class);
    }

    public function jobOfferViews(){
        return $this->hasMany(JobOfferView::class);
    }

}
