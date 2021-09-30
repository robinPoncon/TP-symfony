<?php

namespace App\Controller;

use App\Entity\Beer;
use App\Entity\Country;
use App\Entity\Category;
use App\Services\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BarController extends AbstractController
{
    // Message est un exemple de service injecté dans notre classe
    /**
     * @Route("/", name="home")
     */
    public function index(Message $message): Response
    {

        $beers = $this->getDoctrine()->getRepository(Beer::class)->findAll();

        return $this->render('bar/index.html.twig', [
            'beers' => $beers,
            'title' => "Page d'accueil"
        ]);
    }

    // L'injection de dépendance SF est capable de récupérer l'id et de le passer à l'entité, et il retournera une instance de Country correspondant à son ID, voir le composant SF installé pour cela sensio/framework-extra-bundle
    /**
     * @Route("/country/{id}", name="show_country_beer")
     */
    public function showBeerByCountry(Country $country): Response
    {
        // dump($country); die;

        return $this->render('country/index.html.twig', [
            'beers' => $country->getBeers() ?? [],
            'title' => $country->getName()
        ]);
    }

    /**
     * @Route("/category/{id}", name="show_beer_category")
     */
    public function category(Category $category){

        return $this->render('category/index.html.twig', [
            'beers' => $category->getBeers() ?? [],
            'title' => $category->getName()
        ]);
    }

    /**
     * @Route("/menu", name="menu")
     */
    public function mainMenu(string $routeName, int $catId = null): Response
    {
        // on fait une instance de Doctrine 
        $categories = $this->getDoctrine()->getRepository(Category::class)->findBy(['term' => 'normal']);

        return $this->render('partials/menu.html.twig', [
            'route_name' => $routeName,
            'category_id' => $catId,
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/statistic", name="statistic")
     */
    public function statistic() {
        return $this->render("statistic/statistic.html.twig", [
            "title" => "Statistic"
        ]);
    }
}