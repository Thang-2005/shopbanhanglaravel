<?php

return [

    'default' => 'smtp',

    'mailers' => [

        'smtp' => [
            'transport' => 'smtp',
            'host' => 'smtp.gmail.com',
            'port' => 587,
            'encryption' => 'tls',
            'username' => 'nguyenthang2611205@gmail.com',
            'password' => 'onkbeaqhzhzpzylr',
            'timeout' => null,
            'local_domain' => 'localhost',
        ],

        'log' => [
            'transport' => 'log',
        ],

    ],

    'from' => [
        'address' => 'nguyenthang2611205@gmail.com',
        'name' => 'Shop bán hàng Laravel',
    ],

];
