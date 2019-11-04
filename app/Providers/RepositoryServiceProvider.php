<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class RepositoryServiceProvider extends ServiceProvider {

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //UserRepository
        $this->app->bind(
                'App\Models\Repositories\Contracts\UserRepositoryInterface', 'App\Models\Repositories\UserRepository'
        );
        //NotiRepository
        $this->app->bind(
                'App\Models\Repositories\Contracts\NotiRepositoryInterface', 'App\Models\Repositories\NotiRepository'
        );
        //NotiObjectRepository
        $this->app->bind(
                'App\Models\Repositories\Contracts\NotiObjectRepositoryInterface', 'App\Models\Repositories\NotiObjectRepository'
        );
        //GroupRepository
        $this->app->bind(
                'App\Models\Repositories\Contracts\GroupRepositoryInterface', 'App\Models\Repositories\GroupRepository'
        );
        //BoardRepository
        $this->app->bind(
                'App\Models\Repositories\Contracts\BoardRepositoryInterface', 'App\Models\Repositories\BoardRepository'
        );
        //BoardListRepository
        $this->app->bind(
                'App\Models\Repositories\Contracts\BoardListRepositoryInterface', 'App\Models\Repositories\BoardListRepository'
        );
        //BoardListIssueRepository
        $this->app->bind(
                'App\Models\Repositories\Contracts\BoardListIssueRepositoryInterface', 'App\Models\Repositories\BoardListIssueRepository'
        );
          //AttachmentFileRepositoryInterface
        $this->app->bind(
                'App\Models\Repositories\Contracts\AttachmentFileRepositoryInterface', 'App\Models\Repositories\AttachmentFileRepository'
        );
    }

}
