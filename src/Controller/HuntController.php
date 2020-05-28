<?php


namespace App\Controller;

use App\Entity\Espece;
use App\Entity\Type;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

        // Request five especes from thoses types

        $especeRepository = $this->getDoctrine()->getRepository(Espece::class);
        $espece_by_type = new \ArrayObject();
        foreach ($type_by_lieu as $key){
            $espece_by_type->append($especeRepository->findRandomByType($key));
        }
        return $this->render('hunt/teritory.html.twig', [
            'especes' => $espece_by_type,
        ]);
    }
}