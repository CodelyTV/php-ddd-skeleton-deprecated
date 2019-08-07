<?php

declare(strict_types = 1);

namespace CodelyTv\Tests\Shared\Infrastructure\PhpUnit;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class InfrastructureTestCase extends KernelTestCase
{
    protected function setUp(): void
    {
        self::bootKernel(['environment' => 'test']);

        parent::setUp();
    }

    protected function service($id)
    {
        return self::$container->get($id);
    }

    protected function parameter($parameter)
    {
        return self::$container->getParameter($parameter);
    }
}
