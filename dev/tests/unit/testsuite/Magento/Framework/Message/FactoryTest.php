<?php
/**
 * @copyright Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 */

namespace Magento\Framework\Message;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Magento\Framework\Message\Factory
     */
    protected $factory;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $objectManagerMock;

    protected function setUp()
    {
        $this->objectManagerMock = $this->getMock('Magento\Framework\ObjectManagerInterface');
        $this->factory = new \Magento\Framework\Message\Factory(
            $this->objectManagerMock
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Wrong message type
     */
    public function testCreateWithWrongTypeException()
    {
        $this->objectManagerMock->expects($this->never())->method('create');
        $this->factory->create('type', 'text');
    }

    public function testCreateWithWrongInterfaceImplementation()
    {
        $this->setExpectedException(
            '\InvalidArgumentException',
            'Magento\Framework\Message\Error doesn\'t implement \Magento\Framework\Message\MessageInterface'
        );
        $messageMock = new \stdClass();
        $type = 'error';
        $className = 'Magento\\Framework\\Message\\' . ucfirst($type);
        $this->objectManagerMock
            ->expects($this->once())
            ->method('create')
            ->with($className, ['text' => 'text'])
            ->will($this->returnValue($messageMock));
        $this->factory->create($type, 'text');
    }

    public function testSuccessfulCreateMessage()
    {
        $messageMock = $this->getMock('Magento\Framework\Message\Success', [], [], '', false);
        $type = 'success';
        $className = 'Magento\\Framework\\Message\\' . ucfirst($type);
        $this->objectManagerMock
            ->expects($this->once())
            ->method('create')
            ->with($className, ['text' => 'text'])
            ->will($this->returnValue($messageMock));
        $this->assertEquals($messageMock, $this->factory->create($type, 'text'));
    }
}
