<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Film;
use AppBundle\Entity\Acteur;
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
            ->getArrayResult(); // obtient un tableau assossioctif au lieu d'une Entité

        //var_dump($films);

        $response =  new JsonResponse($films); // cette methode rajoute de façon implicite dans le header le fait que la reponse sera de type Json, et du coup, quand ajax va recuperer la reponse il va la parser automatiquement ..

                            // cette entete rend accesssible cette route de toute les origine 
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;

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
            $actors[] = ['id' => $actor->getId(), 'nom' => $actor->getNom(), 'prenom' => $actor->getPrenom()];
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
            "id" => $film->getId(),
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



    /**
     * @Route("/api/actors", name="api.get.actors")
     */
    public function getActorsAction()
    {


        $actors = $this->getDoctrine()->getRepository(Acteur::class)
            ->createQueryBuilder('a')
            ->select('a')
            ->getQuery()
            ->getArrayResult();// obtient un tableau assossioctif au lieu d'une Entité

       
        return new JsonResponse($actors); // cette methode rajoute de façon implicite dans le header le fait que la reponse sera de type Json, et du coup, quand ajax va recuperer la reponse il va la parser automatiquement ..



    }


    /**
     * @Route("/api/film", name="api.post.film")
     */
    public function postFilmAction(Request $request)
    {
        
        //  Garde
        if (
            empty($request->request->get('title'))
            || empty($request->request->get('description'))
            || empty($request->request->get('date'))
        ) {
            return new JsonResponse(['success' => false]);
        }

        $film = new Film();

        $film->setTitre($request->request->get('title'));
        $film->setDescription($request->request->get('description'));
        $film->setDatesortie(new \DateTime($request->request->get('date')));

        if (empty($request->request->get('actors')) == false) {
            $actors = $request->request->get('actors'); // tableau d'id d'acteur

            foreach ($actors as $id) {
                $actor = $this->getDoctrine()->getRepository(Acteur::class)->find($id);
                $film->addActeur($actor);
            }
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($film);
        $em->flush();

        return new JsonResponse(['success' => true]);// cette methode rajoute de façon implicite dans le header le fait que la reponse sera de type Json, et du coup, quand ajax va recuperer la reponse il va la parser automatiquement ..




    }


    public function updateFilmAction(Request $request, Film $film)
    {
        if (
            empty($request->request->get('title'))
            || empty($request->request->get('description'))
            || empty($request->request->get('date'))
        ) {
            return new JsonResponse(['success' => false]);
        }

        $film->setTitre($request->request->get('title'));
        $film->setDescription($request->request->get('description'));
        $film->setDatesortie(new \DateTime($request->request->get('date')));

        if (empty($request->request->get('actors')) == false) {
            $actors = $request->request->get('actors'); // tableau d'id d'acteur

            $film->emptyActeur();

            $this->setActors($actors, $film);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($film);
        $em->flush();

        return new JsonResponse(['success' => true]);
    }

    private function setActors($actorsId, $film)
    {
        foreach ($actorsId as $id) {
            $actor = $this->getDoctrine()->getRepository(Acteur::class)->find($id);
            $film->addActeur($actor);
        }
    }



}
