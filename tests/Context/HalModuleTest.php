<?php
/**
 * This file is part of the BEAR.Package package.
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace BEAR\Package\Context;

use BEAR\Package\Provide\Representation\HalRenderer;
use BEAR\Resource\Module\ResourceModule;
use BEAR\Resource\RenderInterface;
use BEAR\Sunday\Module\Annotation\DoctrineAnnotationModule;
use BEAR\Sunday\Provide\Router\RouterModule;
use Ray\Di\Injector;

class HalModuleTest extends \PHPUnit_Framework_TestCase
{
    public function testModule()
    {
        $renderer = (new Injector(new HalModule(new RouterModule(new DoctrineAnnotationModule(new ResourceModule('FakeVendor\HelloWorld'))))))->getInstance(RenderInterface::class);
        $this->assertInstanceOf(HalRenderer::class, $renderer);
    }
}
