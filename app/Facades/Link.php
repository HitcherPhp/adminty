<?php


namespace App\Facades;


class Link
{

    const FRANCHISES = 'franchises';
    const FACTORIES = 'factories';
    const RECEPTIONS = 'receptions';
    const STAFF = 'staff';
    const CUSTOMERS = 'customers';
    const ORDERS = 'orders';
    const PROMO_CODES = 'promo_codes';

    protected function __construct() {}
    protected function __clone() {}
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

}
