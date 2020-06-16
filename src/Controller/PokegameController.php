<?php

namespace App\Controller;

use ArrayObject;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PokegameController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @IsGranted("ROLE_USER")
     */
    public function index()
    {
        if($this->getUser()->getStatus() == "newbie"){
            return $this->redirectToRoute('pokemon_starter');
        }
        $pokemons = $this->getUser()->getPokemons();
        $nbPkm = sizeof($pokemons);
        $nb_by_evol = 0;
        $nb_by_base = 0;
        $nb_by_type = new ArrayObject();
        foreach ($pokemons as $key => $value) {
            $espece = $value->getEspece();
            $types = $espece->getType();
            if ($espece->getEvolution() === 'n') {
                $nb_by_base++;
            } else {
                $nb_by_evol++;
            }
            foreach ($types as $key1 => $value1) {
                if (!isset($nb_by_type[$value1->getNom()])) {
                    $nb_by_type[$value1->getNom()] = 1;
                } else {
                    $nb_by_type[$value1->getNom()]++;
                }
            }
        }

        return $this->render(
            'pokegame/index.html.twig',
            [
                'nbPkm' => $nbPkm,
                'nb_by_evol' => $nb_by_evol,
                'nb_by_base' => $nb_by_base,
                'nb_by_type' => $nb_by_type,
            ]
        );
    }
}
