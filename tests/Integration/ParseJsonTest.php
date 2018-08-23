<?php

/**
 * This file is part of the contentful/contentful package.
 *
 * @copyright 2015-2018 Contentful GmbH
 * @license   MIT
 */

namespace Contentful\Tests\Delivery\Integration;

use Contentful\Core\Resource\ResourceArray;
use Contentful\Delivery\Client;
use Contentful\Tests\Delivery\TestCase;

class ParseJsonTest extends TestCase
{
    /**
     * @var Client
     */
    private $client;

    public function setUp()
    {
        $this->client = new Client('b4c0n73n7fu1', 'cfexampleapi');

        parent::setUp();
    }

    public function testParseJsonEmptyArray()
    {
        $resource = $this->client->parseJson('{"sys":{"type":"Array"},"items":[],"total":0,"limit":0,"skip":0}');

        $this->assertInstanceOf(ResourceArray::class, $resource);
    }

    public function testParseJsonSpace()
    {
        $space = $this->client->parseJson($this->getFixtureContent('space.json'));

        $this->assertJsonFixtureEqualsJsonObject('space.json', $space);
    }

    public function parseJsonDataProvider()
    {
        return [
            ['parse_and_encode_content_type.json'],
            ['parse_and_encode_deleted_entry.json'],
            ['parse_and_encode_deleted_asset.json'],
            ['parse_and_encode_deleted_content_type.json'],
            ['parse_and_encode_entry.json'],
        ];
    }

    /**
     * @dataProvider parseJsonDataProvider
     */
    public function testParseAndEncodeJson($file)
    {
        $this->client->parseJson($this->getFixtureContent('parse_and_encode_space.json'));
        $this->client->parseJson($this->getFixtureContent('environment.json'));

        $resource = $this->client->parseJson($this->getFixtureContent($file));
        $this->assertJsonFixtureEqualsJsonObject($file, $resource);
    }

    public function testParseJsonEntry()
    {
        $this->client->parseJson($this->getFixtureContent('space.json'));
        $this->client->parseJson($this->getFixtureContent('environment.json'));
        $this->client->parseJson($this->getFixtureContent('content_type.json'));

        $entry = $this->client->parseJson($this->getFixtureContent('entry.json'));
        $this->assertJsonFixtureEqualsJsonObject('entry.json', $entry);
    }

    public function testParseJsonSingleLocaleEntry()
    {
        $this->client->parseJson($this->getFixtureContent('space.json'));
        $this->client->parseJson($this->getFixtureContent('environment.json'));
        $this->client->parseJson($this->getFixtureContent('content_type.json'));

        $enUsEntry = $this->client->parseJson($this->getFixtureContent('entry_single_locale_en_us.json'));
        $this->assertJsonFixtureEqualsJsonObject('entry_single_locale_en_us.json', $enUsEntry);

        $tlhEntry = $this->client->parseJson($this->getFixtureContent('entry_single_locale_tlh.json'));
        $this->assertJsonFixtureEqualsJsonObject('entry_single_locale_tlh.json', $tlhEntry);
    }

    public function testParseJsonSingleLocaleAsset()
    {
        $this->client->parseJson($this->getFixtureContent('space.json'));
        $this->client->parseJson($this->getFixtureContent('environment.json'));

        $enUsAsset = $this->client->parseJson($this->getFixtureContent('asset_single_locale_en_us.json'));
        $this->assertJsonFixtureEqualsJsonObject('asset_single_locale_en_us.json', $enUsAsset);
    }
}
