<?php

namespace App\Listeners\UserCompanyInteraction;

use App\Approval;
use App\Events\UserCompanyInteraction;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Support\Facades\Mail;

class EmailNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserCompanyInteraction  $event
     * @return void
     */
    public function handle(UserCompanyInteraction $event)
    {
        $action_type = $event->action_type;
        $company_id= $event->company_id;
        $user_id = $event->user_id;
        $company_info = User::find($company_id);
        $user_info = User::find($user_id);
        if($action_type=='user_request_connect') {
            $approval = Approval::where('user_id','=',$user_id)->where('company_id','=',$company_id)->first();
            $data = [
                'email' => $approval->companyProfile->user->email,
                'company_name' => $approval->companyProfile->user->name,
                'user_name' => $approval->userProfile->user->name,
                'subject' => 'New User Approval Request',
            ];

            Mail::send('email.user-company-interaction.new-approval-request', $data, function ($message) use ($data) {
                $message->to($data['email'], $data['company_name'])
                    ->subject($data['subject']);
            });
        }
        elseif($action_type=='user_request_remove') {
            $approval = Approval::where('user_id','=',$user_id)->where('company_id','=',$company_id)->first();
            $data = [
                'email' => $approval->companyProfile->user->email,
                'company_name' => $approval->companyProfile->user->name,
                'user_name' => $approval->userProfile->user->name,
                'subject' => 'New User Removal Request',
            ];

            Mail::send('email.user-company-interaction.removal-request', $data, function ($message) use ($data) {
                $message->to($data['email'], $data['company_name'])
                    ->subject($data['subject']);
            });
        }
        elseif($action_type=='company_approve_user') {

            $data = [
                'email' => $user_info->email,
                'company_name' => $company_info->name,
                'user_name' => $user_info->name,
                'subject' => 'Company Approval Completion',
            ];

            Mail::send('email.user-company-interaction.user-approved', $data, function ($message) use ($data) {
                $message->to($data['email'], $data['user_name'])
                    ->subject($data['subject']);
            });
        }
        elseif($action_type=='company_remove_user') {
            $data = [
                'email' => $user_info->email,
                'company_name' => $company_info->name,
                'user_name' => $user_info->name,
                'subject' => 'Company Removal Completion',
            ];

            Mail::send('email.user-company-interaction.user-removed', $data, function ($message) use ($data) {
                $message->to($data['email'], $data['user_name'])
                    ->subject($data['subject']);
            });
        }
    }
}
