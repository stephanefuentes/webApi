<?php


// src/EventListener/ExceptionListener.php
namespace AppBundle\EventListener;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

use Symfony\Component\HttpKernel\KernelEvents;// on peut utlisier les constantes dévéenement
;


class ApiExceptionSubscriber implements EventSubscriberInterface
{

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $response = new JsonResponse(
            'Not Found',
            404
        );
        $event->setResponse($response);
    }


                        // chaque type dévenement renvoie un objet évenement particulier, ici FilterResponseEvent
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $response = $event->getResponse();
        $response->headers->set('Access-Control-Allow-Origin', '*');
        // par exemple aussi , $response->headers->set('Access-Control-Allow-Origin', 'localhost, site.fr');


        // a ajouter pour que les requetes qui ne sont pas POST ou GET fonctionnent
        $response->headers->set('Access-Control-Allow-Methods', 'GET,POST,DELETE,PUT');
        $response->headers->set('Access-Control-Allow-Headers', 'X-Header-One,X-Header-Two');

        //$response->setStatusCode('200');
    }
    
    
    // fonction qu'on doit obligatoirement impléménté
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',// objet évenement retourné de type FilterResponseEvent
            KernelEvents::RESPONSE => 'onKernelResponse' // objet évenement retourné de type (GetResponseForExceptionEvent
        ];
    }
}
