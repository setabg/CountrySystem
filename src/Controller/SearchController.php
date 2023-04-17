<?php

namespace App\Controller;

use App\Entity\Country;
use App\Entity\City;
use App\Repository\CitiesRepository;
use App\Repository\CountryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function searchCountry(CountryRepository $countryRepository, CitiesRepository $citiesRepository, Request $request)
    {
        $countries = $countryRepository->findCountryByKeyword(
            $request->query->get('keyword')
        );

        $cities = $citiesRepository->findCityByKeyword(
            $request->query->get('keyword')
        );

        return $this->render('search/search.html.twig', [
            'countries' => $countries,
            'cities' => $cities
        ]);
    }
}
