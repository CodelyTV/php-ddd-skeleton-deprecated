<?php

namespace CodelyTv\Tests\Mooc\User\Application;

use CodelyTv\Mooc\User\Application\CreateUserUseCase;
use CodelyTv\Mooc\User\Domain\User;
use CodelyTv\Mooc\User\Infrastructure\UserWriterRepositoryInterface;
use Exception;
use PHPUnit\Framework\TestCase;

class CreateUserUseCaseTest extends TestCase
{
    /**
     * @test
     */
    public function create_a_new_user_happy_path(): void
    {
        $expectedUser = self::getRandomUser();

        $repository = $this->createMock(UserWriterRepositoryInterface::class);
        $repository->method('save')
            ->with($expectedUser->name(), $expectedUser->email())
            ->willReturn($expectedUser);

        $useCase = new CreateUserUseCase($repository);
        $user = $useCase->__invoke($expectedUser->name(), $expectedUser->email());

        $this->assertSame($expectedUser, $user);
    }

    /**
     * @test
     */
    public function create_a_new_user_when_raise_an_exception(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Something went wrong');

        $expectedUser = self::getRandomUser();
        $repository = $this->createMock(UserWriterRepositoryInterface::class);
        $repository->method('save')
            ->with($expectedUser->name(), $expectedUser->email())
            ->willThrowException(new Exception('Something went wrong'));

        $useCase = new CreateUserUseCase($repository);
        $useCase->__invoke($expectedUser->name(), $expectedUser->email());
    }

    private static function getRandomUser(): User
    {
        return new User(1, 'fooName', 'foo@name.com');
    }
}