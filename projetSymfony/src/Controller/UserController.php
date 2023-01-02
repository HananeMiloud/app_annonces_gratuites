<?php

namespace App\Controller;

use App\Form\EditProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;



class UserController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    #[Route('/profile', name: 'app_user')]
     public function editProfil(Request $request)
    {   
       
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $form = $this->createForm(EditProfileType::class, $user);
        $form->handleRequest($request);

       
        if($form->isSubmitted() && $form->isValid()){

           $image = $form->get('image')->getData();
           $image_name=$image->getClientOriginalName() ;
           $image->move($this->getParameter("image_directory"), $image_name);
           
           $user->setImage($image_name);
   
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash('message', 'Profil mis à jour');
            return $this->redirectToRoute('app_user');
        }

        return $this->render('user/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/user/password', name: 'app_userPass')]
    public function editPass(Request $request,UserPasswordHasherInterface $userPasswordHasher)
    {
        if($request->isMethod('POST')){
        
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
            // On vérifie si les 2 mots de passe sont identiques
            if($request->request->get('pass') == $request->request->get('pass2')){
                $user->setPassword( $userPasswordHasher->hashPassword($user, $request->request->get('pass')));
                $this->entityManager->flush();
                $this->addFlash('message', 'Mot de passe mis à jour avec succès');

                return $this->redirectToRoute('app_user');
            }else{
                $this->addFlash('error', 'Les deux mots de passe ne sont pas identiques');
            }
        }

        return $this->render('user/editpassword.html.twig');
    }  
  
}
