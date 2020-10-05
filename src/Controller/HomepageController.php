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
        for ($i = 0; $i <= 2; $i++) {
            $numbers[] = random_int(0, 100);
        }

        return $this->render('draw.html.twig', [
                    'numbers' => $numbers,
        ]);
    }

}
