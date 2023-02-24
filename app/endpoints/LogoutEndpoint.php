<?php

namespace Endpoints;

use db\DB;
use FFI\Exception;
use Session\Session;
use Views\Home;


class LogoutEndpoint
{
    public static function Logout()
    {
        Session::log_out();
        
        return Home::view();
    }
}