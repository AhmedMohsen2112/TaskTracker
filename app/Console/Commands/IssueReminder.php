<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SendMailJob;
use App\Mail\BoardListIssueReminderMail;
use App\Models\Repositories\Contracts\BoardListIssueRepositoryInterface;

class IssueReminder extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'issue:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Email Reminder According To Issue Due Date';
    private $issue;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(BoardListIssueRepositoryInterface $issue) {
        parent::__construct();
        $this->issue = $issue;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $issue_reminder = $this->issue->getList(['option' => ['reminder']]);
        if ($issue_reminder->count() > 0) {
            foreach ($issue_reminder as $one) {
                $assigned = $one->assigned_list();
                if ($assigned->count() > 0) {
                    foreach ($assigned as $user) {
                        dispatch(new SendMailJob(
                                $user->email, new BoardListIssueReminderMail(['title' => $one->title, 'due_date' => $one->due_date]))
                        );
                    }
                }
                $one->reminder_at = \Carbon\Carbon::now();
                $one->save();
            }
        }
    }

}
