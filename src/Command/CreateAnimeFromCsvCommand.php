<?php

namespace App\Command;

use App\Repository\AnimeRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CreateAnimeFromCsvCommand extends Command
{
    private EntityManagerInterface $entityManager;
    private string $dataDirectory;
    private AnimeRepository $animeRepository;
    protected static $defaultName = 'app:create-animes-from-file';
    private SymfonyStyle $io;
    protected static $defaultDescription = 'Add a short description for your command';

    public function __construct(EntityManagerInterface $entityManager, string $dataDirectory, AnimeRepository $animeRepository){
        parent::__construct();
        $this->dataDirectory = $dataDirectory;
        $this->entityManager = $entityManager;
        $this->animeRepository = $animeRepository;
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void{
        $this->io = new SymfonyStyle($input, $output);
    }

    protected function configure(): void{
        $this->setDescription("Importer des donées en provennance d\'un fichier CSV")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int{
        $this->createAnime();
        return Command::SUCCESS;
    }

    private function getDataFromFile(): array{
        $file = $this->dataDirectory . 'ImportAnime.csv';
        $fileExtinsion = pathinfo($file, PATHINFO_EXTENSION);
        $normalizers = [new ObjectNormalizer()];
        $encoders = [new CsvEncoder()];
        $serializers = new Serializer($normalizers, $encoders);
        /** @var string $fileString */
        $fileString = file_get_contents($file);
        $data = $serializers->decode($fileString, $fileExtinsion);

    }

    private function createAnime():void {
        $this->getDataFromFile();
    }
}
