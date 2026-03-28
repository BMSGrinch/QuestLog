<?php
namespace App\Services;

use App\Models\Application;
use Illuminate\Support\Facades\DB;

class ApplicationsService {
    

    public function createApplication (int $userId , array $data):Application {
        $application = Application::create([
            ...$data, 'candidate_id' => $userId,
        ]);
        return $application ; 
        
    }

    public function updateApplication(Application $application , array $data , int $userId):Application
    {
        return DB::transaction(function()use ($application , $data , $userId){
             $oldStatus = $application->status;
             $application->update($data);
            
             if($oldStatus!==$data['status']){
                $application->applicationStatusHistories()->create([
                    'old_status'=>$oldStatus,
                    'new_status'=>$data['status'],
                    'changed_by'=> $userId,
                    'changed_at'=>now()
                ]);
             }
             return $application ;
        });
            
             
              
        }
}