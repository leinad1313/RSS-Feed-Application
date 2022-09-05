<?php

declare(strict_types=1);

namespace Feed;

use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'controllers' => [
        'factories' => [
            Controller\FeedController::class => InvokableFactory::class,
        ],
    ],
];
