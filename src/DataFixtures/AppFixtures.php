<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Marque;
use App\Entity\Telephone;
use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $faker;
    private $manager;
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->faker = Factory::create('fr_FR');
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        //Creation des Marques et Telephones
        $this->marqueEtTel();

        //Creation des Clients et ses utilisateurs
        $this->clientEtUtilisateurs();

        $manager->flush();
    }

    /**
     * Création des téléphones
     */
    private function marqueEtTel(){

        //Création des marques
        $tabMarque = ["kiano", "tolomora", "plepa"];

        for($i=0;$i<3;$i++){
            $marque = new Marque();
            $marque->setLibelle($tabMarque[$i]);
            $this->addReference("marque".$i,$marque);

            $this->manager->persist($marque);
        }

        //Creation des téléphones
        $tabMultiple = ["2","4","8","16","32"];

        for($i=1;$i<25;$i++){
            $telephone = new Telephone();
            $telephone  ->setNom($this->faker->word.'-'.mt_rand(1,11))
                ->setColoris($this->faker->colorName)
                ->setMarque($this->getReference("marque".mt_rand(0,2)))
                ->setDateSortie($this->faker->dateTimeBetween($startDate = '-2 years', $endDate = 'now'))
                ->setMemoire($tabMultiple[mt_rand(0,4)]);

            //car l'os(OSI) n'existe que pour cette marque
            if($telephone->getMarque()->getLibelle() == "plepa"){
                $telephone->setOs("Osi");
            }else{
                $telephone->setOs("droidan");
            }

            $telephone  ->setPhoto($tabMultiple[mt_rand(0,4)])
                ->setTailleEcran(mt_rand(4,8))
                ->setPrix($this->faker->randomNumber(3));

            $this->manager->persist($telephone);
        }

    }

    /**
     * Création des Clients
     */
    private function clientEtUtilisateurs(){

        //creation des clients
        for($i=1;$i<6;$i++){
            $client = new Client();
            $client ->setNom($this->faker->company)
                ->setAdresse($this->faker->address)
                ->setPassword($this->encoder->encodePassword($client,"password"))
                ->setEmail($this->faker->email);

            $this->addReference("client".$i,$client);

            $this->manager->persist($client);
        }

        //création des utilisateurs lié a un client
        for ($i=1;$i<30;$i++){
            $utilisateur = new Utilisateur();

            $utilisateur ->setNom($this->faker->name)
                ->setClient($this->getReference("client".mt_rand(1,5)))
                ->setPrenom($this->faker->firstName)
                ->setAdresse($this->faker->address)
                ->setTel($this->faker->phoneNumber)
                ->setEmail($this->faker->email);

            $this->manager->persist($utilisateur);
        }

    }
}
