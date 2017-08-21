<?php

namespace App\Payment;

class WrongGroupException extends \Exception
{
    public function __construct($message = '')
    {
        parent::__construct($message);
    }
}
