<?php

namespace App\Controller;

use App\Entity\Treatment;
use App\Form\TreatmentType;
use App\Repository\InvoiceRepository;
use App\Repository\TreatmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/treatment")
 */
class TreatmentController extends AbstractController
{
    /**
     * @Route("/", name="treatment_index", methods={"GET"})
     */
    public function index(TreatmentRepository $treatmentRepository): Response
    {
        return $this->render('treatment/index.html.twig', [
            'treatments' => $treatmentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="treatment_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $treatment = new Treatment();
        $form = $this->createForm(TreatmentType::class, $treatment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $invoices = $form->get('invoice')->getData();
            $totalCost = 0;
            foreach ($invoices as $invoice) {
                $unitCost = $invoice->getProduct()->getPrice() * $invoice->getQuantity();
                $invoice->setTreatment($treatment);
                $invoice->setUnitCost($unitCost);
                $discountedCost = $unitCost - ($unitCost * $invoice->getDiscount() / 100);
                $totalCost += $discountedCost;
                // $totalCost += $unitCost;
                // dump($invoice->getDiscount()*$unitCost/100);
                $entityManager->persist($invoice);
            }
            $treatment->setTotalCost($totalCost);
            // dump($form->get('invoice')->getData());
            // dump($treatment);
            // exit;
            $entityManager->persist($treatment);
            $entityManager->flush();

            return $this->redirectToRoute('treatment_show', ['id'=>$treatment->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('treatment/new.html.twig', [
            'treatment' => $treatment,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="treatment_show", methods={"GET"})
     */
    public function show(Treatment $treatment, InvoiceRepository $invoiceRepository): Response
    {
        $invoices = $invoiceRepository->findBy(['treatment'=>$treatment]);
        // dump($invoices); exit;
        return $this->render('treatment/show.html.twig', [
            'treatment' => $treatment,
            'invoices' => $invoices
        ]);
    }

    /**
     * @Route("/{id}/edit", name="treatment_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Treatment $treatment, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TreatmentType::class, $treatment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('treatment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('treatment/edit.html.twig', [
            'treatment' => $treatment,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="treatment_delete", methods={"POST"})
     */
    public function delete(Request $request, Treatment $treatment, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$treatment->getId(), $request->request->get('_token'))) {
            $entityManager->remove($treatment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('treatment_index', [], Response::HTTP_SEE_OTHER);
    }
}
