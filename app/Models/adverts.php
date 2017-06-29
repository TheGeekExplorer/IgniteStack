<?php namespace igniteStack\app\Models;

use igniteStack\Interfaces\BaseModel;
use igniteStack\System\ErrorHandling\Exception;


class adverts extends baseModel {

    public function __construct(
        $advertid=false,
        $userid=false,
        $pageid=false,
        $supplier_name=false,
        $supplier_contact_name=false,
        $supplier_contact_phone=false,
        $supplier_contact_email=false,
        $product_category=false,
        $featured_brands=false,
        $featured_products=false,
        $target_customers=false,
        $key_b2b_message=false,
        $supplier_objectives=false,
        $brief_description=false,
        $payment_type=false,
        $payment=false,
        $year=false,
        $period=false,
        $status=false,
        $action_userid=false,
        $action_message=false,
        $action_timestamp=false
    ) {
        $this->advertid = $advertid;
        $this->userid = $userid;
        $this->pageid = $pageid;
        $this->supplier_name = $supplier_name;
        $this->supplier_contact_name = $supplier_contact_name;
        $this->supplier_contact_phone = $supplier_contact_phone;
        $this->supplier_contact_email = $supplier_contact_email;
        $this->product_category = $product_category;
        $this->featured_brands = $featured_brands;
        $this->featured_products = $featured_products;
        $this->target_customers = $target_customers;
        $this->key_b2b_message = $key_b2b_message;
        $this->supplier_objectives = $supplier_objectives;
        $this->brief_description = $brief_description;
        $this->payment_type = $payment_type;
        $this->payment = $payment;
        $this->year = $year;
        $this->period = $period;
        $this->status = $status;
        $this->action_userid = $action_userid;
        $this->action_message = $action_message;
        $this->action_timestamp = $action_timestamp;
    }

    public $advertid;
    public $userid;
    public $pageid;
    public $supplier_name;
    public $supplier_contact_name;
    public $supplier_contact_phone;
    public $supplier_contact_email;
    public $product_category;
    public $featured_brands;
    public $featured_products;
    public $target_customers;
    public $key_b2b_message;
    public $supplier_objectives;
    public $brief_description;
    public $payment_type;
    public $payment;
    public $year;
    public $period;
    public $status;
    public $action_userid;
    public $action_message;
    public $action_timestamp;


    protected $Constraints = [
        'advertid' => [
            'type'    => 'int',
            'length'  => 11,
            'indexes' => ['Primary Key', 'Not Null', 'Unique', 'Auto Increment']
        ]
    ];
}
