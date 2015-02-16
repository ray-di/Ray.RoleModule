<?php

namespace Ray\AuthorizationModule;

class AuthorizationModuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AuthorizationModule
     */
    protected $skeleton;

    protected function setUp()
    {
        parent::setUp();
        $this->skeleton = new AuthorizationModule;
    }

    public function testNew()
    {
        $actual = $this->skeleton;
        $this->assertInstanceOf('\Ray\AuthorizationModule\AuthorizationModule', $actual);
    }

    public function testException()
    {
        $this->setExpectedException('\Ray\AuthorizationModule\Exception\LogicException');
        throw new Exception\LogicException;
    }
}
