<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\Array_\CallableThisArrayToAnonymousFunctionRector;
use Rector\CodeQuality\Rector\Empty_\SimplifyEmptyCheckOnEmptyArrayRector;
use Rector\Config\RectorConfig;
use Rector\Php70\Rector\StaticCall\StaticCallOnNonStaticToInstanceCallRector;
use Rector\Php74\Rector\Closure\ClosureToArrowFunctionRector;
use Rector\Php81\Rector\Array_\FirstClassCallableRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\Strict\Rector\Empty_\DisallowedEmptyRuleFixerRector;

//use RectorLaravel\Rector\MethodCall\RedirectRouteToToRouteHelperRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
            __DIR__ . '/app',
            __DIR__ . '/config',
            __DIR__ . '/database',
            __DIR__ . '/public',
            __DIR__ . '/resources',
            __DIR__ . '/routes',
            __DIR__ . '/tests',
        ]);

    $rectorConfig->sets([
        SetList::DEAD_CODE,
        SetList::CODE_QUALITY,
        LevelSetList::UP_TO_PHP_83,
    ]);

    $rectorConfig->skip([
        SimplifyEmptyCheckOnEmptyArrayRector::class,
        DisallowedEmptyRuleFixerRector::class,
        ClosureToArrowFunctionRector::class,
        CallableThisArrayToAnonymousFunctionRector::class,
        StaticCallOnNonStaticToInstanceCallRector::class,
        FirstClassCallableRector::class,
    ]);
    //$rectorConfig->rule(RedirectRouteToToRouteHelperRector::class);
};
