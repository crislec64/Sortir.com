<?php

namespace App\Controller;

use App\Repository\CampusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CampusController extends AbstractController
{
    /**
     * @Route ("/campus", name="admin_campus")
     */

    public function campus(CampusRepository $campusRepository):Response
    {
        $campus = $campusRepository->findAll();
        return $this ->render('admin/campus.html.twig', [
            "campus"=>$campus
        ]);
    }
}