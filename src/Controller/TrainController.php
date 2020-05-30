<?php


namespace App\Controller;

use App\Entity\Pokemon;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/train")
 * @IsGranted("ROLE_USER")
 */
class TrainController extends AbstractController
{
    /**
     * @Route("/", name="train_index", methods={"GET", "POST"})
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $pokeRepository = $this->getDoctrine()->getRepository(Pokemon::class);
        $entityManager = $this->getDoctrine()->getManager();
        $message_xp = "";

        if($request->getMethod() === 'POST')
        {
            // We get the picked pokemon and apply the train session.

            $pkmPicked = $pokeRepository->find($_GET["pkmPicked"]);
            $pkmPicked->setXp($pkmPicked->getXp() + rand(100,300));
            $pkmPicked->setRepos(\DateTime::createFromFormat('d/m/Y h:i:s', date('d/m/Y h:i:s', time())));
            $entityManager->flush();
            $message_xp = $pkmPicked->getNom() + " a prit 300xp, grâce à l'entrainement !";
        }

        // Request the pokemon owned by the user available for the train session

        $poke_by_user = new \ArrayObject();
        foreach ($this->getUser()->getPokemons() as $key => $value)
        {
            // TODO REVOIR LA GESTION DU REPOS !!
            if(($value["repos"] > date('m/d/Y h:i:s', strtotime("1 hour"))|| $value["repos"] == null ) && $value["status"] == "libre") {
                $poke_by_user->append($value);
            }
        }

        return $this->render('train/index.html.twig', [
            'message_xp' => $message_xp,
            'poke_user' => $poke_by_user,
        ]);
    }
}