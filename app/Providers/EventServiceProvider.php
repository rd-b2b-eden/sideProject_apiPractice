<?php

namespace App\Providers;

use App\Events\DataGot;
use App\Listeners\InsertData;
use App\Service\DataService;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot(): void
    {
        Event::listen(DataGot::class, function ($event) {
            app(InsertData::class)
                ->handle($event, app(DataService::class));
        });
    }
}
