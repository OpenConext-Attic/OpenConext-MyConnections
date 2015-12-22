<?php
/**
 * @file
 * Project: orcid
 * File: LocaleListener.php
 */

namespace AppBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LocaleListener implements EventSubscriberInterface
{
    private $defaultLocale;

    public function __construct($defaultLocale = 'en')
    {
        $this->defaultLocale = $defaultLocale;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $locale = $request->get('_lng', null);

        if (null !== $locale) {
            $request->getSession()
                ->set(
                    '_locale',
                    $locale
                );
            $request->setLocale($locale);
        } else {
            $request->setLocale(
                $request->getSession()
                    ->get('_locale')
            );
        }


    }

    public static function getSubscribedEvents()
    {
        return array(
            // must be registered before the default Locale listener
            KernelEvents::REQUEST => array(array('onKernelRequest', 17)),
        );
    }
}
