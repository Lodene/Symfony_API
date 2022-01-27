<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Anime;

class AnimeFixtures extends Fixture{
    public function load(ObjectManager $manager): void{
        // $product = new Product();
        // $manager->persist($product);
        for($i = 0; $i < 10; $i++){
            $anime = new Anime();
            if ($i == 0){
                $anime->setName("One Piece")
                    ->setDescription("Avant son exécution, le pirate légendaire Gold Roger lance une chasse au trésor sans précédent et stimule ainsi les pirates du monde entier. Luffy, transformé en homme élastique après avoir mangé un fruit du démon, rêve de devenir le roi des pirates et de trouver le mystérieux “One Piece”. L’ère des pirates bat son plein, Luffy au chapeau de paille et son équipage affronteront des ennemis hauts en couleurs et vivront des aventures rocambolesques !")
                    ->setScore(9)
                    ->setVotersNumber(651);
                $manager->persist($anime);
            } elseif ($i == 1) {
                $anime->setName("Naruto")
                    ->setDescription("Naruto est un garçon un peu spécial. Solitaire au caractère fougueux, il n’est pas des plus appréciés dans son village. Malgré cela, il garde au fond de lui une ambition: celle de devenir un « maître Hokage », la plus haute distinction dans l’ordre des ninjas, et ainsi obtenir la reconnaissance de ses pairs mais cela ne sera pas de tout repos… Suivez l’éternel farceur dans sa quête du secret de sa naissance et de la conquête des fruits de son ambition!")
                    ->setScore(9)
                    ->setVotersNumber(598);
                $manager->persist($anime);
            } elseif ($i == 2) {
                $anime->setName("Bleach")
                    ->setDescription("Bleach conte l'histoire d'un lycéen, Ichigo Kurosaki, qui devient un peu malgré lui un Shinigami, c'est-à-dire un « dieu de la mort », dont la fonction consiste à protéger les humains des Hollows, des monstres nés des âmes humaines qui n'ont pas pu trouver le repos.")
                    ->setScore(8)
                    ->setVotersNumber(99);
                $manager->persist($anime);
            } elseif ($i == 3) {
                $anime->setName("Death note")
                    ->setDescription("Light Yagami est un lycéen surdoué qui juge le monde actuel criminel, pourri et corrompu. Sa vie change du tout au tout le jour où il ramasse par hasard un mystérieux cahier intitulé « Death Note ». ... D'abord sceptique, Light décide toutefois de tester le cahier et découvre que son pouvoir est bien réel.")
                    ->setScore(8)
                    ->setVotersNumber(101);
                $manager->persist($anime);
            } elseif ($i == 4) {
                $anime->setName("Kuroko no basket")
                    ->setDescription("Les aventures de Tetsuyza Kuroko, un jeune garçon de 16 ans qui, sous son apparence chétive, cache un redoutable basketteur membre de la 'génération des miracles' du collège Teiko. Tout juste arrivé au lycée de Seirin, il fait la connaissance de Taiga Kagami, jeune recrue fraîchement débarquée des États-unis.")
                    ->setScore(7)
                    ->setVotersNumber(145);
                $manager->persist($anime);
            } elseif ($i == 5) {
                $anime->setName("Haikyuu")
                    ->setDescription("Shōyō Hinata, jeune élève au collège Yukigaoka, trouve un intérêt soudain au volley-ball après avoir vu un match de tournoi national inter-lycée à la télévision. Malgré sa petite taille, il est déterminé à suivre le même chemin que son joueur modèle du championnat national, surnommé le « petit géant ».")
                    ->setScore(8)
                    ->setVotersNumber(165);
                $manager->persist($anime);
            } elseif ($i == 6) {
                $anime->setName("Black clover")
                    ->setDescription("Asta est un jeune garçon déterminé qui vit avec son ami d'enfance, Yuno, dans un orphelinat du royaume de Clover. ... Asta part pour le sauver mais se retrouve en difficulté, heureusement il est sauvé par un mystérieux grimoire avec un trèfle à cinq feuilles et une grande épée rouillée, qui symbolise le démon.")
                    ->setScore(8)
                    ->setVotersNumber(85);
                $manager->persist($anime);
            } elseif ($i == 7) {
                $anime->setName("Attaque des titans")
                    ->setDescription("Le récit raconte le combat mené par l'humanité pour reconquérir son territoire, en éclaircissant les mystères liés à l'apparition des Titans, du monde extérieur et des évènements précédant la construction des murs.")
                    ->setScore(9)
                    ->setVotersNumber(250);
                $manager->persist($anime);
            } elseif ($i == 8) {
                $anime->setName("Fire force")
                    ->setDescription("L'humanité est terrifiée par le phénomène de combustion humaine. Des brigades spéciales Fire Force ont donc été mises en place avec pour mission de trouver la cause de ce mystérieux phénomène ! Le jeune Shinra, nouvelle recrue surnommée le Démon, rêve de devenir un héros.")
                    ->setScore(8)
                    ->setVotersNumber(59);
                $manager->persist($anime);
            } elseif ($i == 9) {
                $anime->setName("Dororo")
                    ->setDescription("Hyakkimaru est infirme : 48 parties de son corps ont été vendues à autant de démons avant sa naissance. Rafistolé par un chirurgien compatissant, adolescent, il se découvre d'étranges pouvoirs psychiques. Accompagné de Dororo, un petit voleur espiègle, il arpente le Japon à la recherche d'un endroit où vivre.")
                    ->setScore(8)
                    ->setVotersNumber(69);
                $manager->persist($anime);
            } 
        }
        $manager->flush();
    }
}
