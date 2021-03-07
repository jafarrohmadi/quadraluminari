<?php

namespace App\Console\Commands;

use App\Mail\ReminderEmail;
use App\Repositories\ActiveOpportunityReminderRepository;
use App\Repositories\UserRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ReminderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:day';

    protected $user, $activeOpportunityReminderRepository;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a Daily email to all users with a reminders task today';

    /**
     * Create a new command instance.
     *
     * @param ActiveOpportunityReminderRepository $activeOpportunityReminderRepository
     * @param UserRepository $userRepository
     */
    public function __construct(
        ActiveOpportunityReminderRepository $activeOpportunityReminderRepository, UserRepository $userRepository
    ) {
        parent::__construct();
        $this->activeOpportunityReminderRepository = $activeOpportunityReminderRepository;
        $this->user                                = $userRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user = $this->user->findAllData([['id', '!=', 1]]);

        if (count($user) > 0) {
            foreach ($user as $users) {
                $data = $this->activeOpportunityReminderRepository->findAllData([
                    'user_id'                   => $users->id,
                    'act_history_date_reminder' => date('Y-m-d'),
                ], ['activeOpportunityData', 'activeOpportunityData.activeClientData']);

                $email = explode(';', $users->email);

                if (count($data) > 0) {
                    foreach ($email as $emails) {
                        Mail::to($emails)->send(new ReminderEmail($data, $users->name));
                        $this->info('Send Reminder Success to ' . $emails);
                    }
                }
            }
        }
    }
}
