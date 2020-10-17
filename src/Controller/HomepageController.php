<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomepageController extends AbstractController {

    /**
     * @Route("/", name="homepage")
     */
    public function homepage() {
        $number = random_int(0, 100);

        return $this->render('homepage.html.twig', [
                    'number' => $number,
        ]);
    }

    /**
     * @Route("/draw", name="draw")
     */
    public function draw() {
        $ideas = $this->getDoctrine()->getManager()->getRepository('App:Idea')->findBy(
                array(
            'active' => true,
            'user' => $this->getUser()
                ), array(
                ), 100
        );

        shuffle($ideas);
        $brainstorm = array_slice($ideas, 0, 3);

        return $this->render('draw.html.twig', [
                    'brainstorm' => $brainstorm,
        ]);
    }

}
