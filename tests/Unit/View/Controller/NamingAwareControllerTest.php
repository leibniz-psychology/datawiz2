<?php


namespace App\Tests\Unit\View\Controller;


use App\View\Controller\NamingAwareController;
use PHPUnit\Framework\TestCase;

class NamingAwareControllerTest extends TestCase
{
    protected $stub;

    public function setUp()
    {
        $this->stub = $this->getMockForAbstractClass(NamingAwareController::class);
    }

    public function testCanResolveNamespace(){
        $this->assertInstanceOf(NamingAwareController::class, $this->stub);
    }

    public function testCanResolveTemplatePath(){
        /**
         * TODO: move into another testcase
         * If a method is private or protected
         * you can't mock them, so this tests should move to a child class,
         * because getTemplatePathFromControllerName is intended to be private
         */

        $subdir = 'Pages';
        $mimeType = '.html.twig';
        $suffixCutted = 'Controller';

        $path = $this->stub
            ->getTemplatePathFromControllerName($subdir, $mimeType, $suffixCutted);

        // should return a string with valid input
        $this->assertIsString($path);
        // suffix of a template at the end
        $this->assertStringEndsWith('.html.twig', $path);
        // starts with the $subdir
        $this->assertStringStartsWith('Pages/', $path);
        // controller name is in template string
        $this->assertStringContainsString('namingaware', $path);
    }
}