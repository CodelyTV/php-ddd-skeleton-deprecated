<?php

declare(strict_types = 1);

namespace CodelyTv\Shared\Infrastructure\Bus\Event\RabbitMq;

use CodelyTv\Shared\Domain\Bus\Event\DomainEventSubscriber;
use CodelyTv\Shared\Domain\Utils;
use function Lambdish\Phunctional\last;
use function Lambdish\Phunctional\map;

final class RabbitMqQueueNameFormatter
{
    public static function format(DomainEventSubscriber $subscriber): string
    {
        $subscriberClassPaths = explode('\\', get_class($subscriber));

        return implode('-', map(self::toSnakeCase(), $subscriberClassPaths));
    }

    public static function shortFormat(DomainEventSubscriber $subscriber): string
    {
        $subscriberCamelCaseName = (string) last(explode('\\', get_class($subscriber)));

        return Utils::toSnakeCase($subscriberCamelCaseName);
    }

    private static function toSnakeCase(): callable
    {
        return static function (string $text) {
            return Utils::toSnakeCase($text);
        };
    }
}
