<?php

namespace App\DataFixtures;

use App\Entity\Article;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i = 1; $i <= 3; $i++) {
            $date = new DateTime();
            $date->format('Y-m-d H:i:s');
            $product = new Article();
            $product->setTitle('article '.$i);
            $product->setContent('A new article');
            $product->setImage("https://sigmacorporation.pro/uploads/img/129.jpeg");
            $product->setCreatedAt($date);
            $manager->persist($product);
        }
        $manager->flush();
    }
}
