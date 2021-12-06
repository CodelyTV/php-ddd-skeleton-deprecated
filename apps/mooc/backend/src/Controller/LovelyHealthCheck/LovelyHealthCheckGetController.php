<?php

namespace CodelyTv\Apps\Mooc\Backend\Controller\LovelyHealthCheck;

use CodelyTv\Shared\Domain\ClockInterface;
use CodelyTv\Shared\Domain\RandomNumberGenerator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LovelyHealthCheckGetController
{
    private const MESSAGE_OK = 'Todo va fino %s';
    private $generator;
    private $clock;

    public function __construct(RandomNumberGenerator $generator, ClockInterface $clock)
    {
        $this->generator = $generator;
        $this->clock = $clock;
    }

    public function __invoke(Request $request): Response
    {
        $name = $request->query->get('name');

        return new JsonResponse(
            [
                'mooc-backend' => 'ok',
                'message'      => sprintf(self::MESSAGE_OK, $name),
                'datetime'     => $this->clock->getDateTime()
            ]
        );
    }
}