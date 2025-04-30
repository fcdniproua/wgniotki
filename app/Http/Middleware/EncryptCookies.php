<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Cookie\Middleware\EncryptCookies as BaseEncrypter;

class EncryptCookies extends BaseEncrypter
{
    public function __construct(Application $app, Encrypter $encrypter)
    {
        parent::__construct($encrypter);

        $this->except = [
            // Додайте тут cookies, які не потрібно шифрувати
        ];
    }
}