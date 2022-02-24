<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Product;
use App\Entity\ProductImage;
use App\Entity\v1\User;
use App\Entity\v1\Client;
use Cocur\Slugify\Slugify;
use App\ProductModel\ProductModel;
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
                 ->setEmail($faker->email)
                 ->setPassword(hash('sha256', $faker->password))
                 ->setClient($faker->randomElement($clients));
            
            if ($i === 99) {
                $user->setFirstName('Default')
                    ->setLastName('USER')
                    ->setEmail('default@bilemo.io')
                    ->setPassword('$2y$13$oeLo/Uu4wV6fjBdrlJHu5ut8dkruRPijIKZyRwLLu4I4HpxhOQDh.')
                    ->setClient($faker->randomElement($clients));
            }

            $users[] = $user;
            $manager->persist($user);
        }

        $productModel = new ProductModel();
        $products = $productModel->genereate();
        foreach ($products as $product) {
            $productObject = new Product();
            $productObject->setName($product['name'])
                          ->setDescription($product['description'])
                          ->setDateReleased(new \DateTime($product['dateReleased']));
                          
            for($i = 0; $i < count($product['productImage']); $i++) {
                $productImageObject = new ProductImage();
                $productImageObject->setUrl($product['productImage'][$i]['url']);

                $manager->persist($productImageObject);

                $productObject->addProductImage($productImageObject);
            }

            $manager->persist($productObject);
        }

        $manager->flush();
    }
}
