<?php

namespace App\Controller;

use App\Entity\Country;
use App\Form\CountryType;
use App\Repository\CitiesRepository;
use App\Repository\CountryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CountryController extends AbstractController
{
    /**
     * @param CountryRepository $countryRepository
     * @return Response
     */
    public function index(CountryRepository $countryRepository): Response
    {
        $countries = $countryRepository->findAll();


        return $this->render('country/index.html.twig', [
            'countries' => $countries
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        // create a new country
        $country = new Country();

        $form = $this->createForm(CountryType::class, $country);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //entity manager
            $em = $this->getDoctrine()->getManager();
            /** @var UploadedFile $file */

            $file = ($request->files->get('country')['attachment']);

            if ($file) {
                $filename = md5(uniqid()) . '.' . $file->guessClientExtension();

                $file->move(
                    $this->getParameter('uploads_dir'),
                    $filename
                );

                $country->setImage($filename);
                $em->persist($country);
                $em->flush();
            }
            return $this->redirect($this->generateUrl('country'));
        }

        return $this->render('country/create.html.twig', [
            'form' => $form->createView()
        ]);
    }


    public function update(Request $request, $id)
    {

        $country = $this->getDoctrine()->getRepository(Country::class)->find($id);

        $form = $this->createForm(CountryType::class, $country);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //entity manager
            $em = $this->getDoctrine()->getManager();
            /** @var UploadedFile $file */

            $file = ($request->files->get('country')['attachment']);

            if ($file) {
                $filename = md5(uniqid()) . '.' . $file->guessClientExtension();

                $file->move(
                    $this->getParameter('uploads_dir'),
                    $filename
                );

                $country->setImage($filename);
                $em->persist($country);
                $em->flush();
            }
            return $this->redirect($this->generateUrl('country'));
        }

        return $this->render('country/update.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param Country $country
     * @return Response
     */

    public function show(Country $country, string $id): Response
    {
        $repository = $this->getDoctrine()->getRepository(Country::class);
        $country = $repository->find($id);

        //return $this->json('hello');
        return $this->render('country/show.html.twig', [
            'city' => $country->getCities(),
            'country' => $country
        ]);

    }

    /**
     * @param CitiesRepository $citiesRepository
     * @return Response
     */
        public function showAll(CitiesRepository $citiesRepository): Response
        {
            $cities = $citiesRepository->findAll();


            return $this->render('country/show_all.html.twig', [
                'cities' => $cities
            ]);
        }

    /**
     * @param Country $country
     */

    public function delete(Request $request, Country $country): Response
    {
        if ($request->getMethod() === Request::METHOD_POST) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($country);
            $em->flush();

            $this->addFlash('success', 'The country was removed');

            return $this->redirect($this->generateUrl('country'));
        }

        return $this->render('country/delete.html.twig', [
            'country' => $country
        ]);
    }

}
