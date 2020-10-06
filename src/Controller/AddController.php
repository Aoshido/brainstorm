<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AddController extends AbstractController {

    /**
     * @Route("/add", name="add")
     */
    public function add() {

        // creates a task object and initializes some data for this example
        $idea = new \App\Entity\Idea();

        $form = $this->createForm(\App\Form\Type\IdeaType::class, $idea);

        return $this->render('add.html.twig', [
                    'form' => $form->createView(),
        ]);
    }

}
