<?php

namespace Celebgramme\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Celebgramme\Models\AdminLog;
use Auth;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Celebgramme\Events\SomeEvent' => [
            'Celebgramme\Listeners\EventListener',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        // Fired on successful logins...
        $events->listen('auth.login', function ($user, $remember) {
          if(Auth::user()->type=='admin'){
            $adminlog = new AdminLog;
            $adminlog->user_id = Auth::user()->id;
            $adminlog->description = 'Login';
            $adminlog->save();
          }
        });

        // Fired on logouts...
        $events->listen('auth.logout', function ($user) {
          if(Auth::user()->type=='admin'){
            $adminlog = new AdminLog;
            $adminlog->user_id = Auth::user()->id;
            $adminlog->description = 'Logout';
            $adminlog->save();  
          }
        });
    }
}
