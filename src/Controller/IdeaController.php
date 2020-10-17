<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class IdeaController extends AbstractController {

    /**
     * @Route("/ideas/add", name="ideas_add")
     * @IsGranted("ROLE_USER")
     */
    public function add(Request $request) {

        // creates a task object and initializes some data for this example
        $idea = new \App\Entity\Idea();

        $form = $this->createForm(\App\Form\IdeaType::class, $idea);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $idea->setUser($this->getUser());
            $entityManager->persist($idea);
            $entityManager->flush();

            return $this->redirectToRoute('ideas_add');
        }

        $ideas = $this->getDoctrine()->getManager()->getRepository('App:Idea')->findBy(array(
            'active' => true,
            'user' => $this->getUser()
        ));

        return $this->render('add.html.twig', [
                    'ideas' => $ideas,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/ideas/{id}/delete", name="ideas_delete")
     */
    public function delete(Request $request, $id) {

        $idea = $this->getDoctrine()->getManager()->getRepository('App:Idea')->find($id);
        $idea->setActive(false);
        $this->getDoctrine()->getManager()->persist($idea);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('ideas_add');
    }

}
