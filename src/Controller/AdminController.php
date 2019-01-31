<?php

namespace App\Controller;

use App\Entity\Intervention;
use App\Repository\InterventionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(InterventionRepository $interventionRepository)
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'interventions' => $interventionRepository->findAll()
        ]);
    }

    /**
     * @Route("/admin/{intervention}", name="validate")
     */
    public function validate(Intervention $intervention, EntityManagerInterface $em){

        $intervention->setFollow('Réparé');
        $em->flush();

        return $this->redirectToRoute('admin');
    }
}
