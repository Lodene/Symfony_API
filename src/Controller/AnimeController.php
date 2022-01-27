<?php

namespace App\Controller;

use App\Service\CallApiService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Anime;
use App\Repository\AnimeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\AnimeType;
use Symfony\Flex\Path;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class AnimeController extends AbstractController{
    #[Route('/', name: 'home')]
    public function index(): Response{
        return $this->render('anime/index.html.twig');
    }

    #[Route('/listAnime', name: 'listAnime')]
    public function animeList(AnimeRepository $repo): Response{
        $animes = $repo->listAnimeOrder();
        return $this->render('anime/listAnime.html.twig',[
            'animes' => $animes 
        ]);
    }

    #[Route('/about', name: 'about')]
    public function about(): Response{
        return $this->render('anime/about.html.twig');
    }

    #[Route('/importAnime', name: 'importAnime')]
    public function importAnime(SerializerInterface $serializer): Response{

        return $this->render('anime/importAnime.html.twig');
    }

    #[Route('/statistiquesAnime', name: 'stats')]
    public function statistiquesAnime(): Response{
        
        return $this->render('anime/statistiquesAnime.html.twig');
    }

    #[Route('/anime/{id}', name: 'anime')]
    public function anime(Anime $anime): Response{
        return $this->render('anime/anime.html.twig', [
            'anime'=>$anime
        ]);
    }

    #[Route('/addAnime', name: 'addAnime')]
    public function addAnime(AnimeRepository $animeRepository, Request $request, EntityManagerInterface $entityManager, CallApiService $callApiService): Response{
        $anime = new Anime();
        $form = $this->createForm(AnimeType::class, $anime);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $apiResponse = $callApiService->getMovie($anime->getName());
            $data = $form->getData();
            if ($apiResponse[0]['name'] == $data->getName()){
                if ($animeRepository->findOneBySomeField($apiResponse[0]['name']) == null){
                    $anime->setVotersNumber(1);
                    $descriptionArray = $callApiService->findDescription($apiResponse[0]['url']);
                    $anime->setDescription($descriptionArray['description']);
                    $entityManager->persist($anime);
                    $entityManager->flush();   
                    return $this->redirectToRoute('anime', ['id'=>$anime->getId()]);
                } else {
                    echo "le film existe déjà dans la bdd";
                }
            } else {
                echo "Le film n'a pas été trouvé, vous pensez peut etre à : " . $apiResponse[0]['name'];
            }           
        }  
        return $this->render('anime/addAnime.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
