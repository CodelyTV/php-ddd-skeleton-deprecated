<?php

declare(strict_types = 1);

namespace CodelyTv\Mooc\Shared\Infrastructure\Doctrine;

use CodelyTv\Shared\Infrastructure\Doctrine\DoctrineEntityManagerFactory;
use Doctrine\ORM\EntityManagerInterface;

final class MoocEntityManagerFactory
{
    private const SCHEMA_PATH = __DIR__ . '/../../../../../databases/mooc.sql';

    public static function create(array $parameters, string $environment): EntityManagerInterface
    {
        $isDevMode = 'prod' === $environment;

        return DoctrineEntityManagerFactory::create(
            $parameters,
           DoctrinePrefixesSearcher::inPath(__DIR__ . '/../../../../Mooc', 'CodelyTv\Mooc'),
            $isDevMode,
            self::SCHEMA_PATH
        );
    }
}
