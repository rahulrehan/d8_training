<?php
namespace Drupal\d8custom\EventSubscriber;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernal\Event\FilterResponseEvent;
use Symfony\Component\HttpKernal\KernelEvents;

class D8Events implements EventSubscriberInterface {

  public static function getSubscribedEvents() {
    return [
      KernelEvents::RESPONSE => 'subscribedEventsResponse',
    ];
  }

  public function subscribedEventsResponse(FilterResponseEvent $event) {
    $response = $event->getResponse();
    $response->headers->add(['hello' =>'World']);
  }

}

