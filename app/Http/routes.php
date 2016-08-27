<?php

Route::group(['middleware' => 'web'], function () {
	Route::get('login', 'Auth\AuthController@getLogin');
	Route::post('login', 'Auth\AuthController@postLogin');

	Route::get('logout', [
		'as' => 'auth.logout',
		'uses' => 'Auth\AuthController@getLogout',
	]);

	if (settings('reg_enabled')) {
		Route::get('register', 'Auth\AuthController@getRegister');
		Route::post('register', 'Auth\AuthController@postRegister');
		Route::get('register/confirmation/{token}', [
			'as' => 'register.confirm-email',
			'uses' => 'Auth\AuthController@confirmEmail',
		]);
	}

	if (settings('forgot_password')) {
		Route::get('password/remind', 'Auth\PasswordController@forgotPassword');
		Route::post('password/remind', 'Auth\PasswordController@sendPasswordReminder');
		Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
		Route::post('password/reset', 'Auth\PasswordController@postReset');
	}

	if (settings('2fa.enabled')) {
		Route::get('auth/two-factor-authentication', [
			'as' => 'auth.token',
			'uses' => 'Auth\AuthController@getToken',
		]);

		Route::post('auth/two-factor-authentication', [
			'as' => 'auth.token.validate',
			'uses' => 'Auth\AuthController@postToken',
		]);
	}

	Route::get('auth/{provider}/login', [
		'as' => 'social.login',
		'uses' => 'Auth\SocialAuthController@redirectToProvider',
		'middleware' => 'social.login',
	]);

	Route::get('auth/{provider}/callback', 'Auth\SocialAuthController@handleProviderCallback');

	Route::get('auth/twitter/email', 'Auth\SocialAuthController@getTwitterEmail');
	Route::post('auth/twitter/email', 'Auth\SocialAuthController@postTwitterEmail');

});

Route::group(['middleware' => ['web', 'auth']], function () {
	Route::localizedGroup(function () {

		Route::get('/', 'Frontend\HomeController@home')->name('frontend.index');
        Route::group(['namespace' => 'Frontend'], function() {

            Route::get('help', [
                'as' => 'help',
                'uses' => 'HelpController@index',
            ]);

        });
		Route::group(['namespace' => 'Dashboard', 'prefix' => 'dashboard'], function () {
			Route::get('/', [
				'as' => 'dashboard',
				'uses' => 'DashboardController@index',
			]);

			Route::get('profile', [
				'as' => 'profile',
				'uses' => 'ProfileController@index',
			]);

			Route::get('profile/activity', [
				'as' => 'profile.activity',
				'uses' => 'ProfileController@activity',
			]);

			Route::put('profile/details/update', [
				'as' => 'profile.update.details',
				'uses' => 'ProfileController@updateDetails',
			]);

			Route::post('profile/avatar/update', [
				'as' => 'profile.update.avatar',
				'uses' => 'ProfileController@updateAvatar',
			]);

			Route::post('profile/avatar/update/external', [
				'as' => 'profile.update.avatar-external',
				'uses' => 'ProfileController@updateAvatarExternal',
			]);

			Route::put('profile/login-details/update', [
				'as' => 'profile.update.login-details',
				'uses' => 'ProfileController@updateLoginDetails',
			]);

			Route::put('profile/social-networks/update', [
				'as' => 'profile.update.social-networks',
				'uses' => 'ProfileController@updateSocialNetworks',
			]);

			Route::post('profile/two-factor/enable', [
				'as' => 'profile.two-factor.enable',
				'uses' => 'ProfileController@enableTwoFactorAuth',
			]);

			Route::post('profile/two-factor/disable', [
				'as' => 'profile.two-factor.disable',
				'uses' => 'ProfileController@disableTwoFactorAuth',
			]);

			Route::get('profile/sessions', [
				'as' => 'profile.sessions',
				'uses' => 'ProfileController@sessions',
			]);

			Route::delete('profile/sessions/{session}/invalidate', [
				'as' => 'profile.sessions.invalidate',
				'uses' => 'ProfileController@invalidateSession',
			]);

			Route::get('user', [
				'as' => 'user.list',
				'uses' => 'UsersController@index',
			]);

			Route::get('user/create', [
				'as' => 'user.create',
				'uses' => 'UsersController@create',
			]);

			Route::post('user/create', [
				'as' => 'user.store',
				'uses' => 'UsersController@store',
			]);

			Route::get('user/{user}/show', [
				'as' => 'user.show',
				'uses' => 'UsersController@view',
			]);

			Route::get('user/{user}/edit', [
				'as' => 'user.edit',
				'uses' => 'UsersController@edit',
			]);

			Route::put('user/{user}/update/details', [
				'as' => 'user.update.details',
				'uses' => 'UsersController@updateDetails',
			]);

			Route::put('user/{user}/update/login-details', [
				'as' => 'user.update.login-details',
				'uses' => 'UsersController@updateLoginDetails',
			]);

			Route::delete('user/{user}/delete', [
				'as' => 'user.delete',
				'uses' => 'UsersController@delete',
			]);

			Route::post('user/{user}/update/avatar', [
				'as' => 'user.update.avatar',
				'uses' => 'UsersController@updateAvatar',
			]);

			Route::post('user/{user}/update/avatar/external', [
				'as' => 'user.update.avatar.external',
				'uses' => 'UsersController@updateAvatarExternal',
			]);

			Route::post('user/{user}/update/social-networks', [
				'as' => 'user.update.socials',
				'uses' => 'UsersController@updateSocialNetworks',
			]);

			Route::get('user/{user}/sessions', [
				'as' => 'user.sessions',
				'uses' => 'UsersController@sessions',
			]);

			Route::delete('user/{user}/sessions/{session}/invalidate', [
				'as' => 'user.sessions.invalidate',
				'uses' => 'UsersController@invalidateSession',
			]);

			Route::post('user/{user}/two-factor/enable', [
				'as' => 'user.two-factor.enable',
				'uses' => 'UsersController@enableTwoFactorAuth',
			]);

			Route::post('user/{user}/two-factor/disable', [
				'as' => 'user.two-factor.disable',
				'uses' => 'UsersController@disableTwoFactorAuth',
			]);

			Route::get('role', [
				'as' => 'role.index',
				'uses' => 'RolesController@index',
			]);

			Route::get('role/create', [
				'as' => 'role.create',
				'uses' => 'RolesController@create',
			]);

			Route::post('role/store', [
				'as' => 'role.store',
				'uses' => 'RolesController@store',
			]);

			Route::get('role/{role}/edit', [
				'as' => 'role.edit',
				'uses' => 'RolesController@edit',
			]);

			Route::put('role/{role}/update', [
				'as' => 'role.update',
				'uses' => 'RolesController@update',
			]);

			Route::delete('role/{role}/delete', [
				'as' => 'role.delete',
				'uses' => 'RolesController@delete',
			]);

			Route::post('permission/save', [
				'as' => 'dashboard.permission.save',
				'uses' => 'PermissionsController@saveRolePermissions',
			]);

			Route::resource('permission', 'PermissionsController');

            Route::get('backup', [
                'as' => 'backup.index',
                'uses' => 'BackupController@index',
            ]);

            Route::post('backup/manual', [
                'as' => 'backup.manual',
                'uses' => 'BackupController@manual',
            ]);

            Route::post('backup/{backup}/recover', [
                'as' => 'backup.recover',
                'uses' => 'BackupController@recover',
            ]);

            Route::post('backup/recover/file', [
                'as' => 'backup.recover.file',
                'uses' => 'BackupController@recoverFile',
            ]);

            Route::get('backup/{backup}/download', [
                'as' => 'backup.download',
                'uses' => 'BackupController@download',
            ]);

            Route::delete('backup/{backup}/delete', [
                'as' => 'backup.delete',
                'uses' => 'BackupController@delete',
            ]);

			Route::get('department', [
				'as' => 'department.index',
				'uses' => 'DepartmentController@index',
			]);

            Route::get('department/jstree', [
                'as' => 'department.jstree',
                'uses' => 'DepartmentController@jsTree',
            ]);

            Route::get('department/form', [
                'as' => 'department.form',
                'uses' => 'DepartmentController@form',
            ]);

            Route::post('department/store', [
                'as' => 'department.store',
                'uses' => 'DepartmentController@store',
            ]);

            Route::post('department/node/move', [
                'as' => 'department.node.move',
                'uses' => 'DepartmentController@nodeMove',
            ]);

            Route::put('department/{department}/update', [
                'as' => 'department.update',
                'uses' => 'DepartmentController@update',
            ]);

            Route::delete('department/{department}/delete', [
                'as' => 'department.delete',
                'uses' => 'DepartmentController@delete',
            ]);

			Route::get('settings', [
				'as' => 'settings.general',
				'uses' => 'SettingsController@general',
				'middleware' => 'permission:settings.general',
			]);

			Route::post('settings/general', [
				'as' => 'settings.general.update',
				'uses' => 'SettingsController@update',
				'middleware' => 'permission:settings.general',
			]);

			Route::get('settings/auth', [
				'as' => 'settings.auth',
				'uses' => 'SettingsController@auth',
				'middleware' => 'permission:settings.auth',
			]);

			Route::post('settings/auth', [
				'as' => 'settings.auth.update',
				'uses' => 'SettingsController@update',
				'middleware' => 'permission:settings.auth',
			]);

			if (env('AUTHY_KEY')) {
				Route::post('settings/auth/2fa/enable', [
					'as' => 'settings.auth.2fa.enable',
					'uses' => 'SettingsController@enableTwoFactor',
					'middleware' => 'permission:settings.auth',
				]);

				Route::post('settings/auth/2fa/disable', [
					'as' => 'settings.auth.2fa.disable',
					'uses' => 'SettingsController@disableTwoFactor',
					'middleware' => 'permission:settings.auth',
				]);
			}

			Route::post('settings/auth/registration/captcha/enable', [
				'as' => 'settings.registration.captcha.enable',
				'uses' => 'SettingsController@enableCaptcha',
				'middleware' => 'permission:settings.auth',
			]);

			Route::post('settings/auth/registration/captcha/disable', [
				'as' => 'settings.registration.captcha.disable',
				'uses' => 'SettingsController@disableCaptcha',
				'middleware' => 'permission:settings.auth',
			]);

			Route::get('settings/notifications', [
				'as' => 'settings.notifications',
				'uses' => 'SettingsController@notifications',
				'middleware' => 'permission:settings.notifications',
			]);

			Route::post('settings/notifications', [
				'as' => 'settings.notifications.update',
				'uses' => 'SettingsController@update',
				'middleware' => 'permission:settings.notifications',
			]);

			Route::get('activity', [
				'as' => 'activity.index',
				'uses' => 'ActivityController@index',
			]);

			Route::get('activity/user/{user}/log', [
				'as' => 'activity.user',
				'uses' => 'ActivityController@userActivity',
			]);

			Route::group([
				'prefix' => 'log-viewer',
				'middleware' => 'role:Admin',
			], function () {
				Route::get('/', [
					'as' => 'log-viewer::dashboard',
					'uses' => '\Arcanedev\LogViewer\Http\Controllers\LogViewerController@index',
				]);
				Route::group([
					'prefix' => 'logs',
				], function () {
					Route::get('/', [
						'as' => 'log-viewer::logs.list',
						'uses' => '\Arcanedev\LogViewer\Http\Controllers\LogViewerController@listLogs',
					]);
					Route::delete('delete', [
						'as' => 'log-viewer::logs.delete',
						'uses' => '\Arcanedev\LogViewer\Http\Controllers\LogViewerController@delete',
					]);
				});
				Route::group([
					'prefix' => '{date}',
				], function () {
					Route::get('/', [
						'as' => 'log-viewer::logs.show',
						'uses' => '\Arcanedev\LogViewer\Http\Controllers\LogViewerController@show',
					]);
					Route::get('download', [
						'as' => 'log-viewer::logs.download',
						'uses' => '\Arcanedev\LogViewer\Http\Controllers\LogViewerController@download',
					]);
					Route::get('{level}', [
						'as' => 'log-viewer::logs.filter',
						'uses' => '\Arcanedev\LogViewer\Http\Controllers\LogViewerController@showByLevel',
					]);
				});
			});
		});
	});

});
