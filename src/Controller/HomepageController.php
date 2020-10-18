<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class HomepageController extends AbstractController {

    /**
     * @Route("/", name="homepage")
     */
    public function homepage() {
        $flavors = [
            "I reeled from the blow, and then suddenly, I knew exactly what to do. Within moments, victory was mine.",
            "I see more than others do because I know where to look.",
            "The mizzium-sphere array drove her mind deep into the thought field, where only the rarest motes of genius may be plucked.",
            "I have a plan. Actually, I have three.",
            "In all my years of research, I have yet to accurately quantify that baffling mental process known as ‘inspiration.'",
        ];
        shuffle($flavors);

        return $this->render('homepage.html.twig',[
            'flavor' => $flavors[0]
        ]);
    }

    /**
     * @Route("/credits", name="credits")
     */
    public function credits() {
        return $this->render('credits.html.twig');
    }

    /**
     * @Route("/draw", name="draw")
     * @IsGranted("ROLE_USER")
     */
    public function draw() {
        $count = $this->getDoctrine()->getManager()->getRepository('App:Idea')->getIdeasCountForUser($this->getUser());

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
                    'totalIdeas' => $count,
                    'brainstorm' => $brainstorm,
        ]);
    }

}
