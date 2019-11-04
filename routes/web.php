<?php

Route::get('/', function () {
    return redirect()->to(route('admin.dashboard'));
});

Route::group(['namespace' => 'Admin', 'prefix' => 'apanel', 'middleware' => ['CheckCurrentLangCookie']], function () {
    //auth
    Route::post('register', 'RegisterController@register')->name('admin.register.submit');
    Route::get('login', 'LoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'LoginController@login')->name('admin.login.submit');
    Route::post('logout', 'LoginController@logout')->name('admin.logout');

    Route::group(['middleware' => ['ShareDataToApanel']], function () {
        //dashboard
        Route::get('/', 'DashboardController@index')->name('admin.dashboard');

        //settings
        Route::get('settings', 'SettingsController@index')->name('admin.settings.index');
        Route::get('settings/{id}/edit', 'SettingsController@edit')->name('admin.settings.edit');
        Route::patch('settings/{id}', 'SettingsController@update');
        Route::get('change_lang', 'AjaxController@change_lang')->name('ajax.change_lang');

        //profile
        Route::get('profile', 'ProfileController@index')->name('admin.profile.index');
        Route::patch('profile/account/edit', 'ProfileController@update')->name('admin.profile.update');

        //ajax
        Route::group(['prefix' => 'ajax'], function() {
            Route::post('upload', 'AjaxController@upload')->name('admin.ajax.upload');
            Route::delete('upload/{id}', 'AjaxController@delete_upload')->name('admin.ajax.upload.delete');
            Route::delete('payments/{id}', 'AjaxController@delete_payment')->name('admin.ajax.payments.delete');
            Route::get('upload/{id}/edit', 'AjaxController@edit_upload')->name('admin.ajax.upload.edit');
            Route::patch('upload/{id}', 'AjaxController@update_upload')->name('admin.ajax.upload.update');
            Route::get('notifications', 'AjaxController@notifications')->name('admin.ajax.notifications');
            Route::get('search', 'AjaxController@search')->name('admin.ajax.search');
            Route::get('search-users', 'AjaxController@searchUsers')->name('admin.ajax.search.users');
        });



        //groups
        Route::group(['prefix' => 'groups'], function() {
            Route::get('/', 'GroupsController@index')->name('admin.groups.index');
            Route::post('/', 'GroupsController@store')->name('admin.groups.store');
            Route::get('data', 'GroupsController@data')->name('admin.groups.data');
            Route::delete('/{id}', 'GroupsController@destroy')->name('admin.groups.delete');
            Route::get('/{id}/edit', 'GroupsController@edit')->name('admin.groups.edit');
            Route::patch('/{id}', 'GroupsController@update')->name('admin.groups.update');
        });


        //users
        Route::group(['prefix' => 'users'], function() {
            Route::get('/', 'UsersController@index')->name('admin.users.index');
            Route::post('/', 'UsersController@store')->name('admin.users.store');
            Route::get('data', 'UsersController@data')->name('admin.users.data');
            Route::delete('/{id}', 'UsersController@destroy')->name('admin.users.delete');
            Route::get('/{id}/edit', 'UsersController@edit')->name('admin.users.edit');
            Route::patch('/{id}', 'UsersController@update')->name('admin.users.update');
        });
        //boards
        Route::group(['prefix' => 'boards'], function() {
            Route::get('/', 'BoardsController@index')->name('admin.boards.index');
            Route::get('{id}', 'BoardsController@show')->name('admin.boards.view');
            Route::post('/', 'BoardsController@store')->name('admin.boards.store');
            Route::get('data', 'BoardsController@data')->name('admin.boards.data');
            Route::delete('/{id}', 'BoardsController@destroy')->name('admin.boards.delete');
            Route::get('/{id}/edit', 'BoardsController@edit')->name('admin.boards.edit');
            Route::patch('/{id}', 'BoardsController@update')->name('admin.boards.update');
        });
         //board lists
        Route::group(['prefix' => 'board-lists'], function() {
            Route::get('/', 'BoardListsController@index')->name('admin.board.lists.index');
            Route::get('{id}', 'BoardListsController@show')->name('admin.board.lists.view');
            Route::post('/', 'BoardListsController@store')->name('admin.board.lists.store');
            Route::get('data', 'BoardListsController@data')->name('admin.board.lists.data');
            Route::delete('/{id}', 'BoardListsController@destroy')->name('admin.board.lists.delete');
            Route::get('/{id}/edit', 'BoardListsController@edit')->name('admin.board.lists.edit');
            Route::patch('/{id}', 'BoardListsController@update')->name('admin.board.lists.update');
        });
         //board lists issues
        Route::group(['prefix' => 'board-list-issues'], function() {
            Route::get('/', 'BoardListIssuesController@index')->name('admin.board.list.issues.index');
            Route::get('sorting', 'BoardListIssuesController@sorting')->name('admin.board.list.issues.sorting');
            Route::post('assign', 'BoardListIssuesController@assign')->name('admin.board.list.issues.assign');
            Route::post('comment', 'BoardListIssuesController@comment')->name('admin.board.list.issues.comment');
            Route::get('{id}', 'BoardListIssuesController@show')->name('admin.board.list.issues.view');
            Route::post('/', 'BoardListIssuesController@store')->name('admin.board.list.issues.store');
            Route::post('upload', 'BoardListIssuesController@upload')->name('admin.board.list.issues.upload.submit');
            Route::get('data', 'BoardListIssuesController@data')->name('admin.board.list.issues.data');
            Route::delete('/{id}', 'BoardListIssuesController@destroy')->name('admin.board.list.issues.delete');
            Route::get('/{id}/edit', 'BoardListIssuesController@edit')->name('admin.board.list.issues.edit');
            Route::patch('/{id}', 'BoardListIssuesController@update')->name('admin.board.list.issues.update');
        });

        //notifications
        Route::group(['prefix' => 'notifications'], function() {
            Route::get('/', 'NotificationsController@index')->name('admin.notifications.index');
            Route::get('data', 'NotificationsController@data')->name('admin.notifications.data');
            Route::get('{id}', 'NotificationsController@show')->name('admin.notifications.view');
        });
    });
});
