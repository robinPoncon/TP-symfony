<?php

namespace App\Controller;

use DateTime;
use App\Entity\Beer;
use App\Repository\BeerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BarController extends AbstractController
{
    /**
     * @Route("/", name="bar")
     */
    public function index(BeerRepository $beerRepository): Response
    {
        $beers = $beerRepository->findAll();
        return $this->render('bar/index.html.twig', [
            "beers" => $beers
        ]);
    }

    /**
     * @Route("/newbeer", name="create_beer")
     */
    public function createBeer(EntityManagerInterface $manager) {
        $beer = new Beer();
        $beer->setName("Super beer");
        $beer->setPublishedAt(new DateTime());
        $beer->setDescription("Ergonomic and stylish!");

        $manager->persist($beer);
        $manager->flush();

        return new Response("Saved new beer with id " . $beer->getId());
    }

    /**
     * @Route("/countrybeer/{id}", name="country_beer")
     */
    public function showBeer() {
        return $this->render("");
    }
}
