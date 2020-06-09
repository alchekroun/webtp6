<?php


namespace App\Controller;

use App\Entity\Pokemon;
use ArrayObject;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/market")
 * @IsGranted("ROLE_USER")
 */
class MarketController extends AbstractController
{
    /**
     * @Route("/", name="market_index", methods={"GET"})
     */
    public function index(): Response
    {
        $pokeRepository = $this->getDoctrine()->getRepository(Pokemon::class);

        // Request pokemon owned buy the user available for sell.

        $poke_by_user = new ArrayObject();
        foreach ($this->getUser()->getPokemons() as $key => $value)
        {
            // TODO REVOIR LA GESTION DU REPOS !!
            if($value->getStatus() == "libre") {
                $poke_by_user->append($value);
            }
        }

        $poke_to_buy = $pokeRepository->findAllPurchasable();

        return $this->render('market/index.html.twig', [
            'poke_user' => $poke_by_user,
            'poke_to_buy' => $poke_to_buy,
        ]);
    }

    /**
     * @Route("/sell", name="marker_sell", methods={"GET"})
     */
    public function sell(): Response
    {
        $pokeRepository = $this->getDoctrine()->getRepository(Pokemon::class);
        $entityManager = $this->getDoctrine()->getManager();
        $pkmToSell = $pokeRepository->find($_GET["pkmToSell"]);
        $pkmToSell->setStatus("avendre");
        $pkmToSell->setPrix($_GET["pkmPrix"]);
        $entityManager->flush();
        return $this->redirectToRoute('market_result', ['message' => "sell"]);
    }

    /**
     * @Route("/buy", name="market_buy", methods={"GET"})
     */
    public function buy(): Response
    {
        $pokeRepository = $this->getDoctrine()->getRepository(Pokemon::class);
        $entityManager = $this->getDoctrine()->getManager();
        $pkmToBuy = $pokeRepository->find($_GET["pkmToBuy"]);
        if($this->getUser()->getArgent() < $pkmToBuy->getPrix()){
            $pkmToBuy->getUser()->removePokemon($pkmToBuy);
            $pkmToBuy->getUser()->setArgent($pkmToBuy->getUser()->getArgent() + $pkmToBuy->getPrix());
            $this->getUser()->setArgent($this->getUser()->getArgent() - $pkmToBuy->getPrix());
            $this->getUser()->addPokemon($pkmToBuy);
            $entityManager->flush();
            return $this->redirectToRoute('market_result', ['message' => "buy"]);
        }
        return $this->redirectToRoute('market_result', ['message' => "nofund"]);
    }

    /**
     * @Route("/out", name="market_out", methods={"GET"})
     */
    public function out(): Response
    {
        $pokeRepository = $this->getDoctrine()->getRepository(Pokemon::class);
        $entityManager = $this->getDoctrine()->getManager();
        $pkmToOut = $pokeRepository->find($_GET["pkmToOut"]);
        $pkmToOut->setStatus("libre");
        $entityManager->flush();
        return $this->redirectToRoute('market_result', ['message' => "out"]);
    }

    /**
     * @Route("/result/{message}", name="market_result", methods={"GET"})
     * @param Request $message
     * @return Response
     */
    public function result(Request $message): Response
    {
        return $this->render('market/result.html.twig', [
            'message' => $message,
        ]);
    }
}