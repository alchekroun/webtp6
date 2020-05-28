<?php


namespace App\Controller;

use App\Entity\Espece;
use App\Entity\Type;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ACCS")
 * @IsGranted("ROLE_USER")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/init_db/type", name="accs_init_db_type", methods={"GET"})
     * @return RedirectResponse
     */
    public function initdbtype()
    {
        $typeRepo = $this->getDoctrine()->getRepository(Type::class);
        $typeRepo->initdb();
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/init_db/espece", name="accs_init_db_espece", methods={"GET"})
     * @return RedirectResponse
     */
    public function initdbespece()
    {
        $especeRepo = $this->getDoctrine()->getRepository(Espece::class);
        $especeRepo->initdb();
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/init_db/espece_type", name="accs_init_db_espece_type", methods={"GET"})
     * @return RedirectResponse
     */
    public function initdbespecetype()
    {
        $typeRepo = $this->getDoctrine()->getRepository(Type::class);
        $typeRepo->initdblinkespece();
        return $this->redirectToRoute('home');
    }


}