<?php

namespace App\Controller;

use App\Entity\ScheduledMaintenanceJob;
use App\Form\ScheduledMaintenanceJobType;
use App\Repository\ScheduledMaintenanceJobRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/maintenance-job')]
class ScheduledMaintenanceJobController extends AbstractController
{
    #[Route('/schedule', name: 'app_scheduled_maintenance_job_index', methods: ['GET'])]
    public function index(ScheduledMaintenanceJobRepository $scheduledMaintenanceJobRepository): Response
    {
        return $this->render('scheduled_maintenance_job/index.html.twig', [
            'scheduled_maintenance_jobs' => $scheduledMaintenanceJobRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_scheduled_maintenance_job_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $scheduledMaintenanceJob = new ScheduledMaintenanceJob();
        $form = $this->createForm(ScheduledMaintenanceJobType::class, $scheduledMaintenanceJob, ['action' => $this->generateUrl('app_scheduled_maintenance_job_new')]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($scheduledMaintenanceJob);
            $entityManager->flush();

            return $this->redirectToRoute('app_scheduled_maintenance_job_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('scheduled_maintenance_job/new.html.twig', [
            'scheduled_maintenance_job' => $scheduledMaintenanceJob,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_scheduled_maintenance_job_show', methods: ['GET'])]
    public function show(ScheduledMaintenanceJob $scheduledMaintenanceJob): Response
    {
        return $this->render('scheduled_maintenance_job/show.html.twig', [
            'scheduled_maintenance_job' => $scheduledMaintenanceJob,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_scheduled_maintenance_job_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ScheduledMaintenanceJob $scheduledMaintenanceJob, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ScheduledMaintenanceJobType::class, $scheduledMaintenanceJob);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_scheduled_maintenance_job_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('scheduled_maintenance_job/edit.html.twig', [
            'scheduled_maintenance_job' => $scheduledMaintenanceJob,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_scheduled_maintenance_job_delete', methods: ['POST'])]
    public function delete(Request $request, ScheduledMaintenanceJob $scheduledMaintenanceJob, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$scheduledMaintenanceJob->getId(), $request->request->get('_token'))) {
            $entityManager->remove($scheduledMaintenanceJob);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_scheduled_maintenance_job_index', [], Response::HTTP_SEE_OTHER);
    }
}
