<?php

namespace App;

use App\Presenters\UserPresenter;
use App\Services\Auth\TwoFactor\Authenticatable as TwoFactorAuthenticatable;
use App\Services\Auth\TwoFactor\Contracts\Authenticatable as TwoFactorAuthenticatableContract;
use App\Services\Logging\UserActivity\Activity;
use App\Support\Authorization\AuthorizationUserTrait;
use App\Support\Enum\UserStatus;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Laracodes\Presenter\Traits\Presentable;

class User extends Model implements AuthenticatableContract,
AuthorizableContract,
CanResetPasswordContract,
TwoFactorAuthenticatableContract {
	use TwoFactorAuthenticatable, CanResetPassword, Presentable, AuthorizationUserTrait;

	protected $presenter = UserPresenter::class;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	protected $dates = ['last_login', 'birthday'];

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password', 'username', 'realname', 'phone', 'avatar', 'address',
		'department_id', 'country_id', 'birthday', 'last_login', 'confirmation_token',
		'status', 'remember_token',
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	/**
	 * Always encrypt password when it is updated.
	 *
	 * @param $value
	 * @return string
	 */
	public function setPasswordAttribute($value) {
		$this->attributes['password'] = bcrypt($value);
	}

	public function setBirthdayAttribute($value) {
		$this->attributes['birthday'] = trim($value) ?: null;
	}

	public function gravatar() {
		$hash = hash('md5', strtolower(trim($this->attributes['email'])));

		return sprintf("//www.gravatar.com/avatar/%s", $hash);
	}

	public function isUnconfirmed() {
		return $this->status == UserStatus::UNCONFIRMED;
	}

	public function isActive() {
		return $this->status == UserStatus::ACTIVE;
	}

	public function isBanned() {
		return $this->status == UserStatus::BANNED;
	}

	public function socialNetworks() {
		return $this->hasOne(UserSocialNetworks::class, 'user_id');
	}

    public function department() {
        return $this->belongsTo(Department::class, 'department_id')->withDepth();
    }

	public function country() {
		return $this->belongsTo(Country::class, 'country_id');
	}

	public function activities() {
		return $this->hasMany(Activity::class, 'user_id');
	}
}
