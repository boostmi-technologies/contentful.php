<?php

/**
 * This file is part of the contentful/contentful package.
 *
 * @copyright 2015-2019 Contentful GmbH
 * @license   MIT
 */

declare(strict_types=1);

namespace Contentful\Tests\Delivery\Implementation;

use Contentful\Core\Api\Link;
use Contentful\Core\Resource\ResourceArray;
use Contentful\Core\Resource\ResourceInterface;
use Contentful\Delivery\Client\ClientInterface;
use Contentful\Delivery\Query;
use Contentful\Delivery\Resource\Asset;
use Contentful\Delivery\Resource\ContentType;
use Contentful\Delivery\Resource\Entry;
use Contentful\Delivery\Resource\Environment;
use Contentful\Delivery\Resource\Space;

class MockClient implements ClientInterface
{
    /**
     * @var Query|null
     */
    private $lastQuery;

    /**
     * @var string
     */
    private $spaceId;

    /**
     * @var string
     */
    private $environmentId;

    /**
     * MockClient constructor.
     */
    public function __construct(string $spaceId = 'spaceId', string $environmentId = 'environmentId')
    {
        $this->spaceId = $spaceId;
        $this->environmentId = $environmentId;
    }

    /**
     * {@inheritdoc}
     */
    public function getAsset(string $assetId, string $locale = null): Asset
    {
        return MockAsset::withSys($assetId, [], $locale);
    }

    /**
     * {@inheritdoc}
     */
    public function getAssets(Query $query = null): ResourceArray
    {
        $this->lastQuery = $query;

        return new ResourceArray(
            [MockAsset::withSys('assetId')],
            1,
            100,
            0
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getContentType(string $contentTypeId): ContentType
    {
        return MockContentType::withSys($contentTypeId);
    }

    /**
     * {@inheritdoc}
     */
    public function getContentTypes(Query $query = null): ResourceArray
    {
        $this->lastQuery = $query;

        return new ResourceArray(
            [MockContentType::withSys('contentTypeId')],
            1,
            100,
            0
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getEnvironment(): Environment
    {
        return MockEnvironment::withSys($this->environmentId);
    }

    /**
     * {@inheritdoc}
     */
    public function getEntry(string $entryId, string $locale = null): Entry
    {
        return MockEntry::withSys($entryId, [], $locale);
    }

    /**
     * {@inheritdoc}
     */
    public function getEntries(Query $query = null): ResourceArray
    {
        $this->lastQuery = $query;

        return new ResourceArray(
            [MockEntry::withSys('entryId')],
            1,
            100,
            0
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getSpace(): Space
    {
        return MockSpace::withSys($this->spaceId);
    }

    /**
     * {@inheritdoc}
     */
    public function resolveLink(Link $link, string $locale = null): ResourceInterface
    {
        return MockEntry::withSys($link->getId());
    }

    /**
     * {@inheritdoc}
     */
    public function resolveLinkCollection(array $links, string $locale = null): array
    {
        return \array_map(function (Link $link): Entry {
            return MockEntry::withSys($link->getId());
        }, $links);
    }

    /**
     * {@inheritdoc}
     */
    public function getApi(): string
    {
        return 'DELIVERY';
    }

    /**
     * {@inheritdoc}
     */
    public function getSpaceId(): string
    {
        return $this->spaceId;
    }

    /**
     * {@inheritdoc}
     */
    public function getEnvironmentId(): string
    {
        return $this->environmentId;
    }

    /**
     * @return Query|null
     */
    public function getLastQuery()
    {
        return $this->lastQuery;
    }
}
