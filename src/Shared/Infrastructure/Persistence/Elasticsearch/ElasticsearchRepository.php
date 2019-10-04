<?php

declare(strict_types = 1);

namespace CodelyTv\Shared\Infrastructure\Persistence\Elasticsearch;

use CodelyTv\Shared\Domain\ValueObject\Uuid;
use CodelyTv\Shared\Infrastructure\Elasticsearch\ElasticsearchClient;
use Elasticsearch\Common\Exceptions\Missing404Exception;
use function Lambdish\Phunctional\get;
use function Lambdish\Phunctional\get_in;
use function Lambdish\Phunctional\map;

abstract class ElasticsearchRepository
{
    private $client;

    public function __construct(ElasticsearchClient $client)
    {
        $this->client = $client;
    }

    abstract protected function aggregateName(): string;

    protected function persist(string $id, array $plainBody): void
    {
        $this->client->persist($this->aggregateName(), $id, $plainBody);
    }

    protected function searchInElasticById(Uuid $id): ?array
    {
        try {
            $result = $this->client->get(
                [
                    'index' => $this->indexName(),
                    'type'  => $this->typeName(),
                    'id'    => $id->value(),
                ]
            );

            return get('_source', $result);
        } catch (Missing404Exception $unused) {
            return null;
        }
    }

    protected function indexName(): string
    {
        return sprintf('%s_%s', $this->client->indexPrefix(), $this->aggregateName());
    }

    protected function searchAllInElastic(): array
    {
        $result = $this->client->client()->search(
            [
                'index' => $this->indexName(),
            ]
        );

        $hits = get_in(['hits', 'hits'], $result, []);

        return map($this->elasticValuesExtractor(), $hits);
    }

    private function elasticValuesExtractor(): callable
    {
        return static function (array $elasticValues): array {
            return $elasticValues['_source'];
        };
    }
}
