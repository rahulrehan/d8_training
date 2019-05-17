<?php
namespace Drupal\d8custom\EventSubscriber;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Drupal\d8custom\Event\D8NodeInsertEvent;

class D8Events implements EventSubscriberInterface {

  public static function getSubscribedEvents() {
    return [
      KernelEvents::RESPONSE => 'subscribedEventsResponse',
      D8NodeInsertEvent::NODE_INSERT => 'onNodeInsert',
    ];
  }

  public function subscribedEventsResponse(FilterResponseEvent $event) {
    $response = $event->getResponse();
    $response->headers->add(['hello' =>'World']);
  }

  public function onNodeInsert(D8NodeInsertEvent $event) {
    $node = $event->getNode();
    drupal_set_message($node->getTitle());
  }

}

