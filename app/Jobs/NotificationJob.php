<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Repositories\Contracts\NotiRepositoryInterface;
use App\Models\Repositories\Contracts\NotiObjectRepositoryInterface;

class NotificationJob implements ShouldQueue {

    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;

    private $auth_user;
    private $entity;
    private $entity_type;
    private $notifiers;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($auth_user, $entity, $entity_type, $notifiers = array()) {
        $this->auth_user = $auth_user;
        $this->entity = $entity;
        $this->entity_type = $entity_type;
        $this->notifiers = $notifiers;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(NotiRepositoryInterface $noti) {

        $noti->create($this->auth_user, $this->entity, $this->entity_type, $this->notifiers);

    }

}
    