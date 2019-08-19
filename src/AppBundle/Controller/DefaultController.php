<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Film;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }


    /**
     * @Route("/api/films", name="api.get.films")
     */
    public function getFilmsAction(Request $request)
    {

        // $films = $this->getDoctrine()->getRepository(film::class)->findAll();

        $films = $this->getDoctrine()->getRepository(Film::class)
            ->createQueryBuilder('f')
            ->select('f')
            ->getQuery()
            ->getArrayResult();// obtient un tableau assossioctif au lieu d'une Entité

            //var_dump($films);

        return new JsonResponse($films);// cette methode rajoute de façon implicite dans le header le fait que la reponse sera de type Json, et du coup, quand ajax va recuperer la reponse il va la parser automatiquement ..

        // replace this example code with whatever you need
        return $this->render('default/list_films.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
            'films' => $films
        ]);
    }




}
