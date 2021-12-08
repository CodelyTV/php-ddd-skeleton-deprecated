<?php

namespace CodelyTv\Tests\Mooc\User\Application;

use CodelyTv\Mooc\User\Application\CreateUserRequest;
use CodelyTv\Mooc\User\Application\CreateUserUseCase;
use CodelyTv\Mooc\User\Domain\User;
use CodelyTv\Mooc\User\Domain\UserEmail;
use CodelyTv\Mooc\User\Domain\UserId;
use CodelyTv\Mooc\User\Domain\UserName;
use CodelyTv\Mooc\User\Infrastructure\UserWriterRepositoryInterface;
use Exception;
use PHPUnit\Framework\TestCase;

final class CreateUserUseCaseTest extends TestCase
{
    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function create_a_new_user_happy_path(): void
    {
        // Given
        $expectedUser = self::getRandomUser();

        $repository = $this->createMock(UserWriterRepositoryInterface::class);
        $repository->method('save')
            ->with($expectedUser);

        // When
        $useCase = new CreateUserUseCase($repository);
        $useCase->__invoke(
            new CreateUserRequest(
                $expectedUser->id()->value(),
                $expectedUser->name()->value(),
                $expectedUser->email()->value(),
            )
        );

        // Then any exception is thrown
    }

    /**
     * @test
     */
    public function create_a_new_user_when_raise_an_exception(): void
    {
        // Then
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Something went wrong');

        // Given
        $expectedUser = self::getRandomUser();
        $repository = $this->createMock(UserWriterRepositoryInterface::class);
        $repository->method('save')
            ->with($expectedUser)
            ->willThrowException(new Exception('Something went wrong'));

        // When
        $useCase = new CreateUserUseCase($repository);
        $useCase->__invoke(
            new CreateUserRequest(
                $expectedUser->id()->value(),
                $expectedUser->name()->value(),
                $expectedUser->email()->value(),
            )
        );
    }

    private static function getRandomUser(): User
    {
        return new User(
            new UserId('22222222-1111-2222-1111-222222222222'),
            new UserName('fooName'),
            new UserEmail('foo@name.com')
        );
    }
}