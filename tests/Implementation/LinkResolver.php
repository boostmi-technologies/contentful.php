<?php

/**
 * This file is part of the contentful/contentful package.
 *
 * @copyright 2015-2018 Contentful GmbH
 * @license   MIT
 */

declare(strict_types=1);

namespace Contentful\Tests\Delivery\Implementation;

use Contentful\Core\Api\Link;
use Contentful\Core\Api\LinkResolverInterface;
use Contentful\Core\Resource\ResourceInterface;

class LinkResolver implements LinkResolverInterface
{
    /**
     * {@inheritdoc}
     */
    public function resolveLink(Link $link, array $parameters = []): ResourceInterface
    {
        return MockEntry::withSys();
    }

    /**
     * {@inheritdoc}
     */
    public function resolveLinkCollection(array $links, string $locale = \null): array
    {
        return \array_map(function (Link $link) use ($locale): ResourceInterface {
            return $this->resolveLink($link, $locale);
        }, $links);
    }
}
