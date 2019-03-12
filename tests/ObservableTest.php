<?php

namespace Starlit\Observable\Tests;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Starlit\Observable\Observable;

class ObservableTest extends TestCase
{
    /**
     * @var MockObject
     */
    private $observer;

    /**
     * @var Observable
     */
    private $observable;

    public function setUp()
    {
        $this->observer = $this->createMock(\SplObserver::class);
        $this->observable = $this->getMockForAbstractClass(Observable::class);
    }

    public function testAttach()
    {
        $this->observable->attach($this->observer);

        $this->observer
            ->expects($this->once())
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
