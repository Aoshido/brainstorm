<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AddController extends AbstractController {

    /**
     * @Route("/add", name="add")
     */
    public function add(Request $request) {

        // creates a task object and initializes some data for this example
        $idea = new \App\Entity\Idea();

        $form = $this->createForm(\App\Form\IdeaType::class, $idea);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($idea);
            $entityManager->flush();

            return $this->redirectToRoute('add');
        }

        $ideas = $this->getDoctrine()->getManager()->getRepository('App:Idea')->findBy(array(
            'active' => true
        ));

        return $this->render('add.html.twig', [
                    'ideas' => $ideas,
                    'form' => $form->createView(),
        ]);
    }

}
