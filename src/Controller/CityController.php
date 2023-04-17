<?php

namespace App\Controller;

use App\Entity\Cities;
use App\Entity\Country;
use App\Form\CityType;
use App\Form\CountryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CityController extends AbstractController
{
    /**
     * @param Request $request
     * Method ({"GET", "POST"})
     */
    public function addCity(Request $request, Country $country)
    {
        $cities= new Cities();
        $cities->setCountry($country);

        $form = $this->createForm(CityType::class, $cities);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em=$this->getDoctrine()->getManager();
            $cities->setCityname($form['cityname']->getData());
            $em->persist($cities);
            $em->flush();

            return $this->redirect($this->generateUrl('show_city', ['id' => $country->getId()]));
        }
        return $this->render('city/create.html.twig', [
            'form'=>$form->createView(),
            'cities' => $country->getCities(),
            'country' => $country
        ]);
    }

    /**
     * @Route({
     *      "en": "/show/{id}",
     *     "bg": "bg/show/{id}"
     * }, name="show_city")
     */
    public function showCity(string $id)
    {
        $repository = $this->getDoctrine()->getRepository(Country::class);
        $country = $repository->find($id);

        return $this->render('country/show.html.twig', [
            'title' => 'Cities per country',
            'cities' => $country->getCities(),
            'country' => $country

        ]);
    }

    /**
     * Method ({"GET", "POST"})
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function updateCity(Request $request, $id)
    {
        $city = $this->getDoctrine()->getRepository(Cities::class)->find($id);

        $form = $this->createForm(CityType::class, $city);
        $form->handleRequest($request);;

        if ($form->isSubmitted() && $form->isValid()) {
            $em=$this->getDoctrine()->getManager();
            $city->setCityname($form['cityname']->getData());
            $em->persist($city);
            $em->flush();

            return $this->redirect($this->generateUrl('country'));
        }
        return $this->render('city/update.html.twig', [
            'form'=>$form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param Cities $city
     * @return Response
     */
    public function delete(Request $request, Cities $city): Response
    {
        if ($request->getMethod() === Request::METHOD_POST) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($city);
            $em->flush();

            $this->addFlash('success', 'The city was removed');

            return $this->redirect($this->generateUrl('country'));
        }

        return $this->render('city/delete.html.twig', [
            'city' => $city
        ]);
    }
}
