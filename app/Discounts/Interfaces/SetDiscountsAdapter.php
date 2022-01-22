<?php


namespace App\Discounts\Interfaces;


use App\Facades\Message;

abstract class SetDiscountsAdapter
{

    /**
     * City ids for set discounts.
     *
     * @var array
     */
    protected $city_ids;

    /**
     * Message.
     *
     * @var string|array
     */
    protected $message;

    /**
     * Error excepted.
     *
     * @var array
     */
    protected $error;

}
