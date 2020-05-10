<?php

namespace App\ZenCart;

/**
 * Class Customer
 * @property integer $customers_id
 * @property string $customers_gender
 * @property string $customers_firstname
 * @property string $customers_lastname
 * @property string $customers_dob
 * @property string $customers_email_address
 * @property string $customers_nick
 * @property integer $customers_default_address_id
 * @property string $customers_telephone
 * @property string $customers_fax
 * @property string $customers_password
 * @property string $customers_newsletter
 * @property integer $customers_group_pricing
 * @property string $customers_email_format
 * @property integer $customers_authorization
 * @property string $customers_referral
 * @property string $customers_paypal_payerid
 * @property boolean $customers_paypal_ec
 * @package App\ZenCart
 */
class Customer extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'customers';

    /**
     * @var string
     */
    protected $primaryKey = 'customers_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'customers_id',
		'customers_gender',
		'customers_firstname',
		'customers_lastname',
		'customers_dob',
		'customers_email_address',
		'customers_nick',
		'customers_default_address_id',
		'customers_telephone',
		'customers_fax',
		'customers_password',
		'customers_newsletter',
		'customers_group_pricing',
		'customers_email_format',
		'customers_authorization',
		'customers_referral',
		'customers_paypal_payerid',
		'customers_paypal_ec'
	];

    /**
      * The attributes that should be hidden for arrays.
      *
      * @var array
      */
     protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

}
