<?php

namespace App\Controller;

use App\Entity\MeteoData;
use App\Form\MeteoDataType;
use App\Repository\MeteoDataRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/meteo/data')]
class MeteoDataController extends AbstractController
{
    #[IsGranted("ROLE_METEODATA_INDEX")]
    #[Route('/', name: 'app_meteo_data_index', methods: ['GET'])]
    public function index(MeteoDataRepository $meteoDataRepository): Response
    {
        return $this->render('meteo_data/index.html.twig', [
            'meteo_datas' => $meteoDataRepository->findAll(),
        ]);
    }

    #[IsGranted("ROLE_METEODATA_CREATE")]
    #[Route('/new', name: 'app_meteo_data_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $meteoDatum = new MeteoData();
        $form = $this->createForm(MeteoDataType::class, $meteoDatum, [
            'validation_groups' => ['new']
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($meteoDatum);
            $entityManager->flush();

            return $this->redirectToRoute('app_meteo_data_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('meteo_data/new.html.twig', [
            'meteo_datum' => $meteoDatum,
            'form' => $form,
        ]);
    }

    #[IsGranted("ROLE_METEODATA_SHOW")]
    #[Route('/{id}', name: 'app_meteo_data_show', methods: ['GET'])]
    public function show(MeteoData $meteoDatum): Response
    {
        return $this->render('meteo_data/show.html.twig', [
            'meteo_datum' => $meteoDatum,
        ]);
    }

    #[IsGranted("ROLE_METEODATA_EDIT")]
    #[Route('/{id}/edit', name: 'app_meteo_data_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MeteoData $meteoDatum, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MeteoDataType::class, $meteoDatum, [
            'validation_groups' => ['edit']
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_meteo_data_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('meteo_data/edit.html.twig', [
            'meteo_datum' => $meteoDatum,
            'form' => $form,
        ]);
    }

    #[IsGranted("ROLE_METEODATA_DELETE")]
    #[Route('/{id}', name: 'app_meteo_data_delete', methods: ['POST'])]
    public function delete(Request $request, MeteoData $meteoDatum, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$meteoDatum->getId(), $request->request->get('_token'))) {
            $entityManager->remove($meteoDatum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_meteo_data_index', [], Response::HTTP_SEE_OTHER);
    }
}
