<?php


namespace App\Controller;

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
     * @Route("/", name="train_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('train/index.html.twig');
    }
}