<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main_home")
     */
    public function home()
    {
        return $this->render('accueil.html.twig');
    }

    /**
     * @Route("/about", name="main_about")
     */
    public function about()
    {
        return $this->render('about.html.twig');
    }
}