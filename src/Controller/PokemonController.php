<?php

namespace App\Controller;

use App\Entity\Espece;
use App\Entity\Pokemon;
use App\Form\PokemonType;
use App\Repository\PokemonRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
        return $this->render(
            'pokemon/index.html.twig',
            [
                'pokemon' => $this->getUser()->getPokemons(),
            ]
        );
    }

    /**
     * @Route("/{id}", name="pokemon_show", methods={"GET"}, requirements={"id":"\d+"})
     * @param Pokemon $pokemon
     * @return Response
     */
    public function show(Pokemon $pokemon): Response
    {
        return $this->render(
            'pokemon/show.html.twig',
            [
                'pokemon' => $pokemon,
                'espece' => $pokemon->getEspece(),
                'types' => $pokemon->getEspece()->getType(),
            ]
        );
    }

    /**
     * @Route("/{id}", name="pokemon_delete", methods={"DELETE"}, requirements={"id":"\d+"})
     * @param Request $request
     * @param Pokemon $pokemon
     * @return Response
     */
    public function delete(Request $request, Pokemon $pokemon): Response
    {
        if ($this->isCsrfTokenValid('delete' . $pokemon->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($pokemon);
            $entityManager->flush();
        }

        return $this->redirectToRoute('pokemon_index');
    }

    /**
     * @Route("/starter", name="pokemon_starter", methods={"GET", "POST"})
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function starter(Request $request)
    {
        if($this->getUser()->getStatus() != "newbie"){
            return $this->redirectToRoute('home');
        }
        $entityManager = $this->getDoctrine()->getManager();
        $especeRepository = $this->getDoctrine()->getRepository(Espece::class);
        $pkm = new Pokemon();
        $form = $this->createForm(PokemonType::class, $pkm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pkm->setEspece($especeRepository->find($_POST["pkmPicked"]));
            $this->getUser()->setStatus("libre");
            $entityManager->persist($pkm);
            $this->getUser()->addPokemon($pkm);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render(
            'pokegame/starter.html.twig',
            [
                'pkmForm' => $form->createView(),
            ]
        );

    }
}
