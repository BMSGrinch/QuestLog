<?php

namespace App\Services;

use App\Models\JobOffer;

class JobOfferService {
    public function createJobOffer (int $userId , array $data):JobOffer {
        $jobOffer = JobOffer::create([...$data , 'recruiter_id'=>$userId]);
        return $jobOffer ;
    }

    public function updateJobOffer ( array $data , JobOffer $jobOffer):JobOffer {
        $jobOffer->update($data);
        return $jobOffer ;
    }
}