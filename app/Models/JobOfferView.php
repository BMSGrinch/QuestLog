<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOfferView extends Model
{
    /** @use HasFactory<\Database\Factories\JobOfferViewFactory> */
    use HasFactory;

    protected $fillable = [
        'job_offer_id',
        'ip_address',
    ];

    public function jobOffer(){
        return $this->belongsTo(JobOffer::class);
    }

}
