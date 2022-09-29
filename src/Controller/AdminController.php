<?php

namespace App\Controller;

use App\Repository\CampusRepository;
use App\Repository\VilleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/list", name="admin/list")
     */
    public function list(VilleRepository $villeRepository):Response
    {
        $villes = $villeRepository->findAll();
        return $this ->render('admin/list.html.twig' ,[
            "villes" => $villes
        ]);
    }
    /**
     * @Route ("/campus", name="main_campus")
     */

    public function campus(CampusRepository $campusRepository):Response
    {
        $campus = $campusRepository->findAll();
        return $this ->render('admin/campus.html.twig', [
            "campus"=>$campus
        ]);
    }
}
