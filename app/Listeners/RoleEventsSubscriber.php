<?php

namespace App\Listeners;

use App\Activity;
use App\Events\Role\Created;
use App\Events\Role\Deleted;
use App\Events\Role\PermissionsUpdated;
use App\Events\Role\Updated;
use App\Services\Logging\UserActivity\Logger;

class RoleEventsSubscriber {
	/**
	 * @var UserActivityLogger
	 */
	private $logger;

	public function __construct(Logger $logger) {
		$this->logger = $logger;
	}

	public function onCreate(Created $event) {
		$message = trans(
			'log.new_role',
			['name' => $event->getRole()->display_name]
		);

		$this->logger->log($message);
	}

	public function onUpdate(Updated $event) {
		$message = trans(
			'log.updated_role',
			['name' => $event->getRole()->display_name]
		);

		$this->logger->log($message);
	}

	public function onDelete(Deleted $event) {
		$message = trans(
			'log.deleted_role',
			['name' => $event->getRole()->display_name]
		);

		$this->logger->log($message);
	}

	public function onPermissionsUpdate(PermissionsUpdated $event) {
		$this->logger->log(trans('log.updated_role_permissions'));
	}

	/**
	 * Register the listeners for the subscriber.
	 *
	 * @param  \Illuminate\Events\Dispatcher  $events
	 */
	public function subscribe($events) {
		$class = 'App\Listeners\RoleEventsSubscriber';

		$events->listen(Created::class, "{$class}@onCreate");
		$events->listen(Updated::class, "{$class}@onUpdate");
		$events->listen(Deleted::class, "{$class}@onDelete");
		$events->listen(PermissionsUpdated::class, "{$class}@onPermissionsUpdate");
	}
}
