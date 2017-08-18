<?php

namespace HubToDo\Traits\Tests;

use PHPUnit_Framework_TestCase;

/**
 * Class JsonRenderTests.
 *
 * @package HubToDo\Traits\Tests
 */
class JsonRenderTest extends PHPUnit_Framework_TestCase
{
    public function testJsonDecodeSuccess()
    {
        $json = '{"b2w": {"main": null, "show": "CARREGADORES", "categories": {"familyId": 4, "categoryId": 18, "subFamilyId": 1, "subCategoryId": 2577}}}';

        $json_render = $this->getMockForTrait(\HubToDo\Traits\JsonRender::class);

        $this->assertInstanceOf(\stdClass::class, $json_render->jsonDecode($json));
    }
}
