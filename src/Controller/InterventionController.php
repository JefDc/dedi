<?php

namespace App\Controller;

use App\Entity\Intervention;
use App\Entity\Problem;
use App\Form\InterventionType;
use App\Form\InterventionValidationType;
use App\Repository\InterventionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class InterventionController extends AbstractController
{

    /**
     * @Route("/", name="intervention_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $intervention = new Intervention();
        $intervention->setDate(new \DateTime('now'));
        $intervention->setFollow('En cours');
        $form = $this->createForm(InterventionType::class, $intervention);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $form = $this->createForm(InterventionType::class, $intervention);

            return $this->render('intervention/recap.html.twig', [
                'form' => $form->createView(),
            ]);


        }

        return $this->render('intervention/index.html.twig', [
            'intervention' => $intervention,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     * @Route("/save", name="save")
     */
    public function save(Request $request, EntityManagerInterface $em)
    {
        $request = $request->request->all()['intervention'];
        $problem = $em->getRepository(Problem::class)->findOneBy(["id" => $request['problem']]);
        $intervention = new Intervention();
        $intervention->setDate(new \DateTime('now'));
        $intervention->setFollow('En cours');
        $intervention->setName($request['name']);
        $intervention->setOfficeNumber($request['officeNumber']);
        $intervention->setPc($request['pc']);
        $intervention->setDescription($request['description']);
        $intervention->setProblem($problem);

        $em->persist($intervention);
        $em->flush();

        $this->addFlash('success', "Votre demande d'intervention a était envoyé ! ");

        return $this->redirectToRoute('intervention_new');
    }

}
