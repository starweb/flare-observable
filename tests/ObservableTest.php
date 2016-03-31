<?php

class ObservableTest extends \PHPUnit_Framework_TestCase
{
    private $observer;
    private $observable;

    public function setUp()
    {
        $this->observer = $this->getMock('\SplObserver');
        $this->observable = $this->getMockForAbstractClass('\Starlit\Observable\Observable');
    }

    public function testAttach()
    {
        $this->observable->attach($this->observer);

        $this->observer->expects($this->once())
            ->method('update');

        $this->observable->notify();
    }

    public function testDetach()
    {
        $this->observable->attach($this->observer);
        $this->observable->detach($this->observer);

        $this->observer->expects($this->never())
            ->method('update');

        $this->observable->notify();
    }

    public function testDetachAll()
    {
        $this->observable->attach($this->observer);
        $this->observable->detachAll();

        $this->observer->expects($this->never())
            ->method('update');

        $this->observable->notify();
    }

    public function test__sleep()
    {
        $this->assertEquals([], $this->observable->__sleep());
    }
}
