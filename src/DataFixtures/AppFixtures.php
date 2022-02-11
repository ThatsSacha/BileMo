<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Client;
use App\Entity\User;
use Cocur\Slugify\Slugify;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('en_EN');
        $slugify = new Slugify();

        $clientsName = ['Orange', 'SFR', 'Bouygues Telecom', 'Free', 'Amazon', 'Cdiscount', 'Fnac', 'Darty'];
        $clients = [];
        foreach ($clientsName as $name) {
            $clientObject = new Client();
            $clientObject->setName($name)
                        ->setSlug($slugify->slugify($name));
            
            $clients[] = $clientObject;
            $manager->persist($clientObject);
        }

        $users = [];
        for ($i = 0; $i < 100; $i++) {
            $user = new User();
            $firstName = $faker->firstName;
            $lastName = $faker->lastName;

            $user->setFirstName($firstName)
                 ->setLastName($lastName)
                 ->setUsername($slugify->slugify($firstName . ' ' . $lastName))
                 ->setEmail($faker->email)
                 ->setPassword(hash('sha256', $faker->password))
                 ->setClient($faker->randomElement($clients));
            
            if ($i === 99) {
                $user->setFirstName('Sacha')
                    ->setUsername('sacha-cohen')
                    ->setLastName('COHEN')
                    ->setEmail('contact@sacha-cohen.fr')
                    ->setPassword('$2y$13$HmVJnid6pyJb1E/acpCIduTIIpWcploaYC42fd.94sjGihnzaYKb6')
                    ->setClient($faker->randomElement($clients));
            }

            $users[] = $user;
            $manager->persist($user);
        }

        $manager->flush();
    }
}
