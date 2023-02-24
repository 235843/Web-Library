<?php

namespace Session;

class Session
{
    public $user_id;
    private static function __init(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    private static function __deinit(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }
    public static function __callStatic($func, $args)
    {
        $_func = '_'.$func;

        static::__init();

        if (!method_exists(static::class, $_func)) {
            if (count($args) == 0) {
                if (!isset($_SESSION[$func])) {
                    return null;
                }

                return $_SESSION[$func];
            }

            if (count($args) == 1) {
                return $_SESSION[$func] = $args[0];
            }

            return null;
        }

        return static::$_func(...$args);
    }

    public static function _logged_in(): bool
    {
        
        if (isset($_SESSION["logged_in"]) and $_SESSION["logged_in"]) {
            return true;
        } else {
            return false;
        }
    }

    public static function _log_in(?array $assoc = null): void
    {
        $_SESSION["logged_in"] = true;
        foreach ($assoc as $key => $value) {
            $_SESSION[$key] = $value;
        }
    }

    public static function _log_out(): void
    {
        static::__deinit();
    }
}

