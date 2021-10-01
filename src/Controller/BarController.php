<?php

namespace App\Controller;

use App\Entity\Beer;
use App\Entity\User;
use App\Entity\Country;
use App\Entity\Category;
use App\Entity\Statistic;
use App\Services\Message;
use App\Form\ScoreFormType;
use App\Repository\StatisticRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
     * @Route("/beer/{id}", name="show_beer")
     */
    public function showBeer(Beer $beer, EntityManagerInterface $manager, Request $request) {
        $statistic = new Statistic();
        $catNormal = $beer->getCategories()[0]->getId();
        $client = $this->getUser()->getClient();
        $form = $this->createForm(ScoreFormType::class, $statistic);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $statistic = $form->getData();
            $statistic->setBeerId($beer);
            $statistic->setCategoryId($catNormal);
            $statistic->setClientId($client);
            $manager->persist($statistic);
            $manager->flush();

            $this->addFlash("success", "Le score a bien été ajouté !");
            return $this->redirectToRoute("show_beer", ["id" => $beer->getId()]);
        }

        return $this->render("beer/showBeer.html.twig", [
            "beer" => $beer,
            "title" => "Détail bière " . $beer->getName(),
            "form" => $form->createView()
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
    public function statistic(StatisticRepository $statisticRepo) {
        $idClient = $this->getUser()->getClient()->getId();
        $statistics = $statisticRepo->findBy(["client_id" => $idClient]);
        return $this->render("statistic/statistic.html.twig", [
            "title" => "Statistiques",
            "statistics" => $statistics
        ]);
    }
}