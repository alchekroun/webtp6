<?php


namespace App\Controller;

use App\Entity\Espece;
use App\Entity\Pokemon;
use App\Entity\Type;
use App\Form\PokemonType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;

date_default_timezone_set('Europe/Paris');
/**
 * @Route("/hunt")
 * @IsGranted("ROLE_USER")
 */
class HuntController extends AbstractController
{

    /**
     * @Route("/", name="hunt_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('hunt/index.html.twig');
    }

    /**
     * @Route("/teritory/{ter}", name="hunt_teritory", methods={"GET"})
     * @param Request $request
     * @param $ter
     * @return Response
     */
    public function teritory(Request $request, $ter): Response
    {
        // Request for species living in the spot
        // Type first
        $typeRepository = $this->getDoctrine()->getRepository(Type::class);
        $type_by_lieu = $typeRepository->findBy(array($ter => 1));

        // Request especes from thoses types

        $especeRepository = $this->getDoctrine()->getRepository(Espece::class);
        $espece_by_type = new \ArrayObject();
        foreach ($type_by_lieu as $key)
        {
            $espece_by_type->append($especeRepository->findRandomByType($key));
        }

        // Request Pokemon owned by the user

        $poke_by_user = new \ArrayObject();
        foreach ($this->getUser()->getPokemons() as $key => $value)
        {
            // TODO REVOIR LA GESTION DU REPOS !!
            if(($value["repos"] > date('m/d/Y h:i:s', strtotime("1 hour"))|| $value["repos"] == null ) && $value["status"] == "libre") {
                $poke_by_user->append($value);
            }
        }

        // Request the evolution status of pokemon owned by the user

        $evol_by_poke_by_user = new \ArrayObject();
        foreach ($poke_by_user as $key => $value)
        {
            $evol_by_poke_by_user->append($especeRepository->find($value["espece_id"])->getEvolution());
        }

        return $this->render('hunt/teritory.html.twig', [
            'especes' => $espece_by_type,
            'poke_user' => $poke_by_user,
            'poke_evol' => $evol_by_poke_by_user,
        ]);
    }

    /**
     * @Route("/hunted", name="hunt_hunted", methods={"GET", "POST"})
     * @param Request $request
     * @return Response
     */
    public function result(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $pokeRepository = $this->getDoctrine()->getRepository(Pokemon::class);
        $especeRepository = $this->getDoctrine()->getRepository(Espece::class);
        $pkm = new Pokemon();
        $form = $this->createForm(PokemonType::class, $pkm);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
                $pkm->setEspece($especeRepository->find($_GET["cappkm"]));
                $entityManager->persist($pkm);
                $this->getUser()->addPokemon($pkm);
                $entityManager->flush();

                return $this->redirectToRoute('home');
        } else
        {
            // Calcul des probabilités de capture
            $token_chances = rand(1, 100);
            $myPkm = $pokeRepository->find($_GET["mypkm"]);
            $capPkm = $especeRepository->find($_GET["cappkm"]);
            $a = 2;
            $b = 2;
            if ($myPkm->getEspece()->getEvolution() === 'n') {
                $a = 1;
            }
            if ($capPkm->getEvolution() === 'n') {
                $b = 1;
            }
            $prob = 1 / ($b * (1 / ($a * ($myPkm->getXp() / 2))));
            if ($token_chances <= $prob) {
                $myPkm->setXp($myPkm->getXp() + 100);
                $myPkm->setRepos(\DateTime::createFromFormat('d/m/Y h:i:s', date('d/m/Y h:i:s', time())));
                $entityManager->flush();

                return $this->render(
                    'hunt/result.html.twig',
                    [
                        'pkmForm' => $form->createView(),
                        'pkmCap' => $capPkm,
                        'myPkm' => $myPkm->getNom(),
                    ]
                );
            } else {
                $myPkm->setXp($myPkm->getXp() + 50);
                $myPkm->setRepos(\DateTime::createFromFormat('d/m/Y h:i:s', date('d/m/Y h:i:s', time())));
                $entityManager->flush();

                return $this->render(
                    'hunt/fail.html.twig',
                    [
                        'pkm' => $myPkm->getNom(),
                    ]
                );
            }
        }
    }
}