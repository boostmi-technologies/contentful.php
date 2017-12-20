<?php

/**
 * This file is part of the contentful.php package.
 *
 * @copyright 2015-2017 Contentful GmbH
 * @license   MIT
 */

namespace Contentful\Delivery\Cache;

use Contentful\Delivery\ContentType;
use Contentful\Delivery\Space;

class InstanceCache
{
    /**
     * @var Space|null
     */
    private $space;

    /**
     * @var ContentType[]
     */
    private $contentTypes = [];

    /**
     * InstanceCache constructor.
     *
     * Currently empty but exists for forward compatibility.
     */
    public function __construct()
    {
    }

    /**
     * Get the space to which this instance Cache belongs.
     *
     * @return Space|null
     */
    public function getSpace()
    {
        return $this->space;
    }

    /**
     * Set the space to which this instance Cache belongs.
     *
     * @param Space $space
     */
    public function setSpace(Space $space)
    {
        $this->space = $space;
    }

    /**
     * Whether the space has been cached or not.
     *
     * @return bool
     */
    public function hasSpace()
    {
        return null !== $this->space;
    }

    /**
     * @param string $id
     *
     * @return ContentType|null
     */
    public function getContentType($id)
    {
        if (!isset($this->contentTypes[$id])) {
            return null;
        }

        return $this->contentTypes[$id];
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    public function hasContentType($id)
    {
        return isset($this->contentTypes[$id]);
    }

    /**
     * @param ContentType $contentType
     */
    public function addContentType(ContentType $contentType)
    {
        $this->contentTypes[$contentType->getId()] = $contentType;
    }
}
