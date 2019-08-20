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


    /**
     * @Route("/api/film/{id}", name="api.get.film")
     */
    public function getFilmAction(Film $film)
    {

        $actors = [];

        foreach ($film->getActeur() as $actor) {
            $actors[] = ['nom' => $actor->getNom(), 'prenom' => $actor->getPrenom()];
        }


        // $film = $this->getDoctrine()->getRepository(Film::class)
        //     ->createQueryBuilder('film')
        //     ->select('film', 'acteur')
        //     ->join('film.acteur', 'acteur')
        //     ->where('film.id = :id')
        //     ->setParameter('id', $film->getId())
        //     ->getQuery()
        //     ->getArrayResult();

        // var_dump($film);

        $film = [
            "titre" => $film->getTitre(),
            "description" => $film->getDescription(),
            "datesortie" => $film->getDatesortie()->format('d/m/Y'),
            "acteurs" => $actors,
            "réalisateur" => $film->getRealisateur(),
            "genre" => $film->getGenre()
        ];

        return new JsonResponse($film); // cette methode rajoute de façon implicite dans le header le fait que la reponse sera de type Json, et du coup, quand ajax va recuperer la reponse il va la parser automatiquement ..

     
        
    }


    
    public function deleteFilmAction(Film $film)
    {


          try
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($film);
            $em->flush();
             
            return new JsonResponse([ 'success' => true ]);
        }
        catch( Exception $e )
        {
            return new JsonResponse([ 'success' => false ]);
        }



    }


}
