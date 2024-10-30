<?php

namespace WebinaneCommerce\Models;

use Illuminate\Database\Eloquent\Builder;
use WeDevs\ORM\Eloquent\Model;
use WeDevs\ORM\WP\User as WPUser;
use WebinaneCommerce\Classes\Customers;
use WebinaneCommerce\Models\OrderItems;

class User extends WPUser {

	public $timestamps = false;

	protected $fillable = ['user_login', 'user_email', 'user_pass', 'user_nicename', 'user_url', 'display_name'];


	public function customer() {
		return $this->hasOne(Customer::class);
	}
	
	public function getFirstNameAttribute() {
		return $this->meta->where('meta_key', 'first_name')->first()->meta_value;
	}
	
	public function getLastNameAttribute() {
		return $this->meta->where('meta_key', 'last_name')->first()->meta_value;
	}
	
	public function getDescriptionAttribute() {
		return $this->meta->where('meta_key', 'description')->first()->meta_value;
	}

	public function getAvatarAttribute() {
		return array_get($this->meta_data, 'avatar');
	}
	

	/**
	 * Returns the user meta data as associated array.
	 *
	 * @return array.
	 */
	public function getMetaDataAttribute() {
		return $this->meta->pluck('meta_value', 'meta_key');
	}
}
