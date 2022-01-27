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
use App\Form\ImportCsvForm;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;



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
    public function importAnime(Request $request): Response{
        // instantiation, when using it as a component
        $serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);
        $form = $this->createFormBuilder([])->add('FileCsv', FileType::class, [
            'label' => 'Brochure (CSV file)',
            'mapped' => false,
            'required' => false,
            'constraints' => [
                new File([
                    'maxSize' => '1024k',
                    'mimeTypes' => [
                        'text/csv'
                    ],
                    'mimeTypesMessage' => 'Please upload a valid CSV document',
                ])
            ],
        ])->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $formImport = $form->get('FileCsv')->getData();
            dd($formImport);
        }

        // decoding CSV contents
        $data = $serializer->decode(file_get_contents('data.csv'), 'csv');
        return $this->render('anime/importAnime.html.twig', [
            'form' => $form->createView()
        ]);
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
