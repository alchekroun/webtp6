<?php


namespace App\Controller;

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
        return $this->render('market/index.html.twig');
    }
}