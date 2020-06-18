<?php


namespace App\Controller;

use App\Entity\Espece;
use App\Entity\Type;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/ACCS")
 * @IsGranted("ROLE_ADMIN")
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
}