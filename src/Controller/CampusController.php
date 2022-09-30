<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Form\CampusType;
use App\Repository\CampusRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin", name="admin_")
 */
class CampusController extends AbstractController
{
    /**
     * @Route("", name="campus")
     */
    public function campus (CampusRepository $campusRepository): Response
    {
        $campus = $campusRepository->findAll();
        return $this ->render('admin/campus.html.twig',[
            "campus"=>$campus
        ]);
    }

    /**
     * @Route("/campusTest", name="em-campustest")
     */
    public function campusTest (EntityManagerInterface $entityManager): Response
    {
        $campus = new Campus();

        $campus->setNom('Bibi');

        $entityManager->persist($campus);
        $entityManager->flush();

        dump($campus);

        return $this ->render('admin/campus.html.twig');
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(
        Request $request,
        EntityManagerInterface $entityManager):Response
    {

        $campus = new Campus();
        $campusForm = $this->createForm(CampusType::class, $campus);
        $campusForm->handleRequest($request);


        if($campusForm-> isSubmitted() && $campusForm-> isValid()){
            $entityManager->persist($campus);
            $entityManager->flush();


            $this->addFlash('success', 'Un Campus a été ajoutée');


            return $this->redirectToRoute('main_home');
        }

        return $this->render('admin/createCampus.html.twig',[
            'CampusForm' => $campusForm->createView()
        ]);

    }
}