<?php declare(strict_types=1);
/**
 * Observable.
 *
 * @copyright Copyright (c) 2016 Starweb AB
 * @license   BSD 3-Clause
 */

namespace Starlit\Observable;

use \SplSubject;
use \SplObserver;

/**
 * @author Andreas Nilsson <http://github.com/jandreasn>
 */
abstract class Observable implements SplSubject
{
    /**
     * @var SplObserver[]
     */
    private $observers = [];

    /**
     * Attach an observer to the set of observers for this object.
     *
     * @param SplObserver $observer
     */
    public function attach(SplObserver $observer): void
    {
        $objectId = spl_object_hash($observer);
        $this->observers[$objectId] = $observer;
    }

    /**
     * Detach an observer from the set of observers for this object.
     *
     * @param SplObserver $observer
     */
    public function detach(SplObserver $observer): void
    {
        $objectId = spl_object_hash($observer);
        unset($this->observers[$objectId]);
    }

    /**
     * Notify all of this object's observers.
     */
    public function notify(): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

    /**
     * Detaches all observers.
     */
    public function detachAll(): void
    {
        $this->observers = [];
    }

    /**
     * Magic method called before object unserialization to return the names of all properties to be serialized.
     *
     * @return array
     */
    public function __sleep(): array
    {
        // We don't want observers to be serialized, since the reference to current objects are broken
        $allObjectProperties = array_keys(get_object_vars($this));
        $exclude = ['observers'];
        $objectPropertiesToSerialize = array_diff($allObjectProperties, $exclude);

        return $objectPropertiesToSerialize;
    }
}
