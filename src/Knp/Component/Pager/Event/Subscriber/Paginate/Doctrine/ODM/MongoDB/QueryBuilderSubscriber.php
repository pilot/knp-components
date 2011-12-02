<?php

namespace Knp\Component\Pager\Event\Subscriber\Paginate\Doctrine\ODM\MongoDB;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Knp\Component\Pager\Event\CountEvent;
use Knp\Component\Pager\Event\ItemsEvent;
use Doctrine\ODM\MongoDB\Query\Builder;

class QueryBuilderSubscriber implements EventSubscriberInterface
{
    /**
     * @param CountEvent $event
     */
    public function count(CountEvent $event)
    {
        $this->handle($event);
    }

    public function items(ItemsEvent $event)
    {
        $this->handle($event);
    }

    public static function getSubscribedEvents()
    {
        return array(
            'items' => array('items', 10/*make sure to transform before any further modifications*/),
            'count' => array('count', 10)
        );
    }

    private function handle($event)
    {
        $qb = $event->getTarget();
        if ($qb instanceof Builder) {
            // change target into query
            $event->setTarget($qb->getQuery());
        }
    }
}