<?php

namespace App\DataFixtures;

use App\Entity\Adress;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Profile;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use EsperoSoft\Faker\Faker;

class BlogFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = new Faker();
        
        $users = [];
        // for ($i=0; $i < 100; $i++) { 
        //     $user = (new User())->setFullName($faker->full_name())
        //                         ->setEmail($faker->email())
        //                         ->setPassword(sha1("users01"))
        //                         ->setCreatedAt($faker->dateTimeImmutable())
        //     ;
        //     $adress = (new Adress())->setStreet($faker->streetAddress())
        //                             ->setCodePostal($faker->codePostal())
        //                             ->setCity($faker->city())
        //                             ->setCountry($faker->country())
        //                             ->setCreatedAt($faker->dateTimeImmutable())
        //     ;
        //     $profil = (new Profile())->setPicture("https://cdn.pixabay.com/photo/2019/05/04/15/24/woman-4178302_960_720.jpg")
        //                             ->setCoverPicture("https://cdn.pixabay.com/photo/2015/04/23/22/00/tree-736885__480.jpg")
        //                             ->setDescription($faker->description(60))
        //                             ->setCreatedAt($faker->dateTimeImmutable())
        //     ;
            
        //     $user->addAdress($adress);
        //     $user->setProfile($profil);
        //     $users[] = $user;
        //     $manager->persist($adress);
        //     $manager->persist($profil);
        //     $manager->persist($user);
        // }

            // $categories = [];
            $names = [
                "Actualités",
                "Economie",
                "Formation AnubisLa",
                "Sports",
                "Politique",
                "Situation en RDC",
                "Divers",
            ];
            for ($i=0; $i < count($names); $i++) {
                $category = (new Category())->setName($names[$i])
                                            ->setDescription("La description de : ".$names[$i])
                                            ->setImageUrl("https://cdn.pixabay.com/photo/2016/03/31/19/50/checklist-1295319_960_720.png")
                                            ->setCreatedAt($faker->dateTimeImmutable())
                ;
                $categories[] = $category;
                $manager->persist($category);
            }
            // for ($i=0; $i < 300; $i++) {
            //     $article = (new Article())->setTitle($faker->description(30))
            //                                 ->setContent($faker->text(5, 10))
            //                                 ->setImageUrl("https://cdn.pixabay.com/photo/2018/07/01/13/28/announcement-3509489_960_720.jpg")
            //                                 ->setCreatedAt($faker->dateTimeImmutable())
            //                                 ->setAuthor($users[rand(0, count($users)-1)])
            //                                 ->addCategory($categories[rand(0, count($categories)-1)])
            //     ;
            //     $manager->persist($article);
            // }
            $manager->flush();
        
    }
            
}
