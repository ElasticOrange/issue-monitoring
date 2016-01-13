<?php

namespace Issue;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
									AuthorizableContract,
									CanResetPasswordContract
{
	use Authenticatable, Authorizable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'type'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

    protected $guarded = ['id'];

    public function isAdmin()
    {
        return $this->type == 'admin';
    }

    public function isEditor()
    {
        return $this->type == 'editor';
    }

    public function isClient()
    {
        return $this->type == 'client';
    }

    public function isActive()
    {
        return $this->active == true;
    }

    public function subscription()
    {
        return $this->hasOne('Issue\UserSubscription');
    }

    public function syncSubscription($subscriptionData)
    {
        $subscription = $this->subscription;

        if (!$subscription) {
            $subscription = new UserSubscription;
        }

        if (!UserSubscription::isValidSubscriptionData($subscriptionData)) {
            $subscription->delete();

            return true;
        }

        $subscription->fill($subscriptionData);

        $this->subscription()->save($subscription);

        return true;
    }
}
