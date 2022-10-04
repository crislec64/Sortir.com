<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditPasswordType;
use App\Form\ProfileType;
use App\Form\ProfileUploadType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 *
 * Affichage et modification des infos des users
 *
 * @Route("/profil")
 */
class UserController extends AbstractController
{
    /**
     * profil
     * @Route("/{id}", name="user_profile", requirements={"id": "\d+"})
     */
    public function profile(User $user): Response
    {
        if (!$user->getIsActive()){
            throw $this->createNotFoundException("User not found");
        }
        if ($user->getIsDeleted()){
            throw $this->createNotFoundException("User deleted");
        }

        return $this->render('main/profile.html.twig', [
            'user' => $user
        ]);
    }


    /**
     * Modifier
     *
     * @Route("/modification", name="user_edit")
     */
    public function edit(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()){
                $em->persist($user);
                $em->flush();

                $this->addFlash('success', 'Profile Modified');
                return $this->redirectToRoute("user_upload");
            }
            else {
                $em->refresh($user);
            }
        }

        return $this->render('user/edit.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }




    /**
     * Modification du profil
     * @Route("/modification/mot-de-passe", name="user_edit_password")
     */
    public function editPassword(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder): Response
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

            return $this->redirectToRoute("user_profile", ["id" => $user->getId()]);
        }

        return $this->render('user/edit_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }



}