<?php

namespace App\Listeners;

use App\Activity;
use App\Events\Department\Created;
use App\Events\Department\Deleted;
use App\Events\Department\Updated;
use App\Services\Logging\UserActivity\Logger;

class DepartmentEventsSubscriber {
	/**
	 * @var UserActivityLogger
	 */
	private $logger;

	public function __construct(Logger $logger) {
		$this->logger = $logger;
	}

	public function onCreate(Created $event) {
		$message = trans(
			'log.new_department',
			['name' => $event->getDepartment()->name]
		);

		$this->logger->log($message);
	}

	public function onUpdate(Updated $event) {
		$message = trans(
			'log.updated_department',
			['name' => $event->getDepartment()->name]
		);

		$this->logger->log($message);
	}

	public function onDelete(Deleted $event) {
		$message = trans(
			'log.deleted_department',
			['name' => $event->getDepartment()->name]
		);

		$this->logger->log($message);
	}

	/**
	 * Register the listeners for the subscriber.
	 *
	 * @param  \Illuminate\Events\Dispatcher  $events
	 */
	public function subscribe($events) {
		$class = 'App\Listeners\DepartmentEventsSubscriber';

		$events->listen(Created::class, "{$class}@onCreate");
		$events->listen(Updated::class, "{$class}@onUpdate");
		$events->listen(Deleted::class, "{$class}@onDelete");
	}
}
