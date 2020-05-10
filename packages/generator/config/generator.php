<?php
return [
    'default' => [
        'model' => 'DB\Models',
        'filter' => 'DB\Filters',
        'repository' => 'Repositories',
        'controller' => 'Http\Api\Controllers',
        'request' => 'Http\Api\Requests',
        'entity' => 'Entities'
    ],
    'magento' => [
        'model' => 'Magento'
    ],
    'zen-cart' => [
        'model' => 'ZenCart'
    ]
];