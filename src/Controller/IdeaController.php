<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use Knp\Component\Pager\PaginatorInterface;


class IdeaController extends AbstractController {

    /**
     * @Route("/ideas/add", name="ideas_add")
     * @IsGranted("ROLE_USER")
     */
    public function add(Request $request, PaginatorInterface $paginator) {
        $count = $this->getDoctrine()->getManager()->getRepository('App:Idea')->getIdeasCountForUser($this->getUser());

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

        $pagination = $paginator->paginate(
                $ideas, 
                $request->query->getInt('page', 1),
                10 
        );

        return $this->render('add.html.twig', [
                    'ideas' => $pagination,
                    'totalIdeas' => $count,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/ideas/{id}/delete", name="ideas_delete")
     * @IsGranted("ROLE_USER")
     */
    public function delete(Request $request, $id) {

        $idea = $this->getDoctrine()->getManager()->getRepository('App:Idea')->find($id);

        if (is_null($idea)) {
            return $this->redirectToRoute('ideas_add');
        }

        if ($idea->getUser() == $this->getUser()) {
            $idea->setActive(false);
            $this->getDoctrine()->getManager()->persist($idea);
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->redirectToRoute('ideas_add');
    }

}
