<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\User;
use App\Form\EditProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends AbstractController
{
    /**
     *
     * @Route("/user", name="index")
     */
    public function index()
    {
        return $this->render('main/profile.html.twig');
    }
    /**
     *
     * @Route("/profil", name="vision")
     */
    public function vision()
    {
        return $this->render('main/vision.html.twig');
    }


    /**
     *
     * @Route("/profile/editProfile", name="editProfile")
     */
    public function editProfile(Request $request, EntityManagerInterface $entityManager)
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfileType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($user);
            $entityManager->flush();


            $this->addFlash('message', 'le profile à bien été modifié');
            return $this->redirectToRoute('index');
        }

        return $this->render('main/editprofile.html.twig', [
            'form' => $form->createView(),
        ]);
    }


        /**
         *
         * @Route("/profile/pass/modifier", name="pass_modifier")
         */
        public function editPass(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        if($request-> isMethod('POST')){
            $user = $this ->getUser();

            if($request -> request->get('pass') == $request->request->get('pass2')){

                $user->setPassword($passwordHasher->hashPassword(
                         $user,$request->request->get('pass')));
                $entityManager->flush();
                $this->addFlash('message','Mot de passe mis à jour avec succès');
            }else{
                $this->addFlash('error','Les deux mots de passe ne sont pas identiques');
            }

        }
        return $this->render ('main/editpass.html.twig');
    }



    /**
     * @Route("/profile/delete/{id}", name="deleteParticipant")
     */
    public function delete (User $user, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($user);
        $entityManager->flush();


        return $this->redirectToRoute('main_home');
    }



}


/*
    /**
     * Charger photo
     * @Route("/modification", name="")
     */
   /* public function upload(Request $request): Response
    {

    }

*/

    /**
     * Modification du profil
     * @Route("/modification/mot-de-passe", name="user_edit_password")
     */
   /* public function editPassword(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder): Response
    {

        $user = $this->getUser();

        $form = $this->createForm(EditPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $hash = $passwordEncoder->encodePassword($user, $form->get('new_password')->getData());
            $user->setPassword($hash);

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Mot de passe modifié !');

            $entityManager->refresh($user);

            return $this->redirectToRoute("user_edit_password", ["id" => $user->getId()]);
        }

        return $this->render('main/profile.html.twig', [
            'form' => $form->createView(),
        ]);
    }*/

