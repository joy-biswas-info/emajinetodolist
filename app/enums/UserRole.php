<?php

namespace App\Enums;

enum UserRole: string
{

    const manager = 'Manager';
    const admin = 'Admin';
    const customer = 'Customer';


    public static function toArray()
    {
        return [
            self::manager,
            self::admin,
            self::customer,
        ];
    }



}