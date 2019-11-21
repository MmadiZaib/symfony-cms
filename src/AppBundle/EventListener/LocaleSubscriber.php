<?php


namespace AppBundle\EventListener;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class LocaleSubscriber implements EventSubscriberInterface
{
    private $defaultLocale;

    public function __construct($defaultLocale = "en")
    {
        $this->defaultLocale = $defaultLocale;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if (!$request->hasPreviousSession()) {
            return;
        }

        //try to see if the locale has been set as a _locale routing parameter
        if ($locale = $request->attributes->get('_locale')) {
            $request->getSession()->set('_locale', $locale);
        } else {
            $request->setLocale($request->getSession()->get('_locale', $this->defaultLocale));
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => [['onKernelRequest', 20]],
        ];
    }
}