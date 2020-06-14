<?php


namespace App\Controller;

use App\Entity\Pokemon;
use ArrayObject;
use DateTime;
use DateTimeZone;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/train")
 * @IsGranted("ROLE_USER")
 */
class TrainController extends AbstractController
{

    /**
     * @Route("/", name="train_index", methods={"GET"})
     * @return Response
     */
    public function index(): Response
    {
        $message_xp = "";
        // Request the pokemon owned by the user available for the train session

        $poke_by_user = new ArrayObject();
        foreach ($this->getUser()->getPokemons() as $key => $value) {
            if ($value->getStatus() == "libre") {
                if ($value->getRepos() == NULL) {
                    $poke_by_user->append($value);
                } else {
                    $dnow = DateTime::createFromFormat(
                        'd/m/Y H:i:s',
                        date('d/m/Y H:i:s', time()),
                        new DateTimeZone("Europe/Paris")
                    );
                    $diff = $value->getRepos()->diff($dnow);
                    $hours = $diff->h + ($diff->days * 24) + ($diff->m * 720);
                    if ($hours > 1) {
                        $poke_by_user->append($value);
                    }
                }
            }
        }

        return $this->render(
            'train/index.html.twig',
            [
                'message_xp' => $message_xp,
                'poke_by_user' => $poke_by_user,
            ]
        );
    }

    /**
     * @Route("/my/{idPkm}", name="train_pick", methods={"GET"})
     * @param $idPkm
     * @return Response
     */
    public function pick($idPkm)
    {
        $pokeRepository = $this->getDoctrine()->getRepository(Pokemon::class);
        $entityManager = $this->getDoctrine()->getManager();
        // We get the picked pokemon and apply the train session.
        $randToken = rand(10, 30);
        $pkmPicked = $pokeRepository->find($idPkm);
        $pkmPicked->setXp($pkmPicked->getXp() + $randToken);
        $pokeRepository->verifyAndLevelUp($pkmPicked);
        $pkmPicked->setRepos(
            DateTime::createFromFormat('d/m/Y H:i:s', date('d/m/Y H:i:s', time()), new DateTimeZone("Europe/Paris"))
        );
        $this->debug_to_console($pkmPicked->getRepos()->format('d/m/Y H:i:s'));
        $entityManager->flush();

        return $this->render(
            'train/trainmessage.html.twig',
            [
                'pokemon' => $pkmPicked,
                'xpearned' => $randToken,
            ]
        );
    }

    function debug_to_console($data)
    {
        $output = $data;
        if (is_array($output)) {
            $output = implode(',', $output);
        }

        echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    }
}