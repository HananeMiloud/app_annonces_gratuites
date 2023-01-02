<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Form\CommentaireType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\AnnoncesRepository;
use Knp\Component\Pager\PaginatorInterface;
use App\Form\SearchAnnonceType;



class HomePageController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager ){
        $this->entityManager = $entityManager;
    }


    #[Route('/', name: 'app_home_page')]
    public function index(AnnoncesRepository $annoncesRepository,PaginatorInterface $paginator, Request $request): Response
    {    

        $annonces =  $annoncesRepository->findBy(['active' => true], ['dateCreation' => 'desc']);
       
        $form = $this->createForm(SearchAnnonceType::class);
        
        $search = $form->handleRequest($request); 

        if($form->isSubmitted() && $form->isValid()){
            // On recherche les annonces correspondant aux mots clés
            $annonces = $annoncesRepository->search(
                $search->get('mots')->getData(),
                $search->get('categorie')->getData()
               
            );
        }

        $annonces = $paginator->paginate(
            $annonces, 
            $request->query->getInt('page', 1),
            9

        );

        return $this->render('home_page/index.html.twig', [
            'annonces' => $annonces,
            'form' => $form->createView()
         
           
        ]);
    }




    #[Route('/annoncesDetaul/{id<[0-9]+>}', name: 'app_annonce_detail')]
    public function annonceDetail($id, AnnoncesRepository $annoncesRepository,Request $request): Response
    {   
        $annonces =  $annoncesRepository->findBy(['active' => true], ['dateCreation' => 'desc'],6);
        $annonce=$annoncesRepository->find($id);
        
        $commentaire= new Commentaire;
       

        $form = $this->createForm(CommentaireType::class, $commentaire);
 
        $form->handleRequest($request);
 
        if($this->getUser() && $form->isSubmitted() && $form->isValid()){

          
           
            $commentaire->setCreatedAt(new \DateTime());
            $commentaire->setAnnonce($annonce); 
            $commentaire->setUser($this->getUser());         
            $this->entityManager->persist($commentaire);
            $this->entityManager->flush();
           
            return $this->redirectToRoute('app_annonce_detail', ['id'=>$id]);
             
        } 
        

        return $this->render('home_page/annones_detail.html.twig', [
            'annones_detail'=> $annonce,
            'annonces' => $annonces,
            'form'=>$form->createView(),
            
        ]);
    }

}
