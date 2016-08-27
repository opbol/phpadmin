<?php

namespace App\Providers;

use App\Repositories\Activity\ActivityRepository;
use App\Repositories\Activity\EloquentActivity;
use App\Repositories\Backup\BackupRepository;
use App\Repositories\Department\DepartmentRepository;
use App\Repositories\Backup\EloquentBackup;
use App\Repositories\Department\EloquentDepartment;
use App\Repositories\Country\CountryRepository;
use App\Repositories\Country\EloquentCountry;
use App\Repositories\Permission\EloquentPermission;
use App\Repositories\Permission\PermissionRepository;
use App\Repositories\Role\EloquentRole;
use App\Repositories\Role\RoleRepository;
use App\Repositories\Session\DbSession;
use App\Repositories\Session\SessionRepository;
use App\Repositories\User\EloquentUser;
use App\Repositories\User\UserRepository;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot() {
		Carbon::setLocale(config('app.locale'));
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register() {
		$this->app->singleton(UserRepository::class, EloquentUser::class);
		$this->app->singleton(ActivityRepository::class, EloquentActivity::class);
		$this->app->singleton(RoleRepository::class, EloquentRole::class);
		$this->app->singleton(PermissionRepository::class, EloquentPermission::class);
		$this->app->singleton(SessionRepository::class, DbSession::class);
		$this->app->singleton(CountryRepository::class, EloquentCountry::class);
		$this->app->singleton(BackupRepository::class, EloquentBackup::class);
		$this->app->singleton(DepartmentRepository::class, EloquentDepartment::class);
	}
}
