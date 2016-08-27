<?php

namespace App\Providers;

use App\Events\User\Registered;
use App\Listeners\BackupEventsSubscriber;
use App\Listeners\DepartmentEventsSubscriber;
use App\Listeners\PermissionEventsSubscriber;
use App\Listeners\RoleEventsSubscriber;
use App\Listeners\UserEventsSubscriber;
use App\Listeners\UserWasRegisteredListener;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider {
	/**
	 * The event listener mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
		Registered::class => [UserWasRegisteredListener::class],
	];

	/**
	 * The subscriber classes to register.
	 *
	 * @var array
	 */
	protected $subscribe = [
		UserEventsSubscriber::class,
		RoleEventsSubscriber::class,
		PermissionEventsSubscriber::class,
		BackupEventsSubscriber::class,
		DepartmentEventsSubscriber::class,
	];

	/**
	 * Register any other events for your application.
	 *
	 * @param  \Illuminate\Contracts\Events\Dispatcher  $events
	 * @return void
	 */
	public function boot(DispatcherContract $events) {
		parent::boot($events);

		//
	}
}
