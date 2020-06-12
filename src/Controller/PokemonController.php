<?php

namespace App\Controller;

use App\Entity\Pokemon;
use App\Form\PokemonType;
use App\Repository\PokemonRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/pokemon")
 * @IsGranted("ROLE_USER")
 */
class PokemonController extends AbstractController
{
    /**
     * @Route("/", name="pokemon_index", methods={"GET"})
     * @param PokemonRepository $pokemonRepository
     * @return Response
     */
    public function index(PokemonRepository $pokemonRepository): Response
    {
        return $this->render('pokemon/index.html.twig', [
            'pokemon' => $this->getUser()->getPokemons(),
        ]);
    }

    /**
     * @Route("/{id}", name="pokemon_show", methods={"GET"})
     * @param Pokemon $pokemon
     * @return Response
     */
    public function show(Pokemon $pokemon): Response
    {
        return $this->render('pokemon/show.html.twig', [
            'pokemon' => $pokemon,
            'espece' => $pokemon->getEspece(),
            'types' => $pokemon->getEspece()->getType(),
        ]);
    }

    /**
     * @Route("/{id}", name="pokemon_delete", methods={"DELETE"})
     * @param Request $request
     * @param Pokemon $pokemon
     * @return Response
     */
    public function delete(Request $request, Pokemon $pokemon): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pokemon->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($pokemon);
            $entityManager->flush();
        }

        return $this->redirectToRoute('pokemon_index');
    }
}
