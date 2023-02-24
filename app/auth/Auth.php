<?php

namespace Auth;

use Session\Session;

enum Auth
{
    case signed;
    case guest;
    case admin;

    public function validate(): bool
    {
        return match ($this) {
            Auth::signed => $this->signed(),
            Auth::guest => $this->guest(),
            Auth::admin => $this->admin(),
        };
    }

    private function signed(): bool
    {
        return Session::logged_in();
    }

    private function guest(): bool
    {
        return !Session::logged_in();
    }

    private function admin(): bool
    {
        return !!Session::admin();
    }
}
