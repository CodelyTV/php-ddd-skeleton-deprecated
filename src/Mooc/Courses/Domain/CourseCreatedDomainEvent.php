<?php

declare(strict_types = 1);

namespace CodelyTv\Mooc\Courses\Domain;

use CodelyTv\Shared\Domain\Bus\DomainEvent;

final class CourseCreatedDomainEvent extends DomainEvent
{
    private $name;
    private $duration;

    public function __construct(string $id, string $name, string $duration)
    {
        parent::__construct($id);

        $this->name     = $name;
        $this->duration = $duration;
    }

    public static function eventName(): string
    {
        return 'course.created';
    }

    public function plainBody(): array
    {
        return [
            'name'     => $this->name,
            'duration' => $this->duration,
        ];
    }
}
