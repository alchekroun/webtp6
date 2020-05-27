<?php


namespace App\Controller;

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

    // TODO FAIRE CETTE ROUTE !!!
    /**
     * @Route("/init_db")
     * @return RedirectResponse
     */
    public function initdb()
    {
        $rawSql = "INSERT INTO `type` (nom, lieu) VALUES ('Acier', 'Montage')";
        return $this->redirectToRoute('home');
    }
}