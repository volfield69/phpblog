<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Theme;
use App\Form\ThemeType;
use App\Repository\ThemeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/theme")
 */
class ThemeController extends AbstractController
{
    /**
     * @Route("/", name="theme_index", methods={"GET"})
     */
    public function index(ThemeRepository $themeRepository): Response
    {
        $categoryId = $this->get('session')->get('category_id', null);

        if ($categoryId) {
            return $this->render('theme/index.html.twig', [
                'themes' => $themeRepository->findBy(['category' => $categoryId]),
                'categoryId' => $categoryId,
            ]);
        }

        return $this->render('theme/index.html.twig', [
            'themes' => $themeRepository->findAll(),
            'categoryId' => $categoryId,
        ]);
    }

    /**
     * @Route("/new", name="theme_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $categoryId = $this->get('session')->get('category_id');
        if (!$categoryId) {
            return $this->redirectToRoute('category_index');
        }

        $theme = new Theme();
        $category = $this->getDoctrine()->getRepository(Category::class)->find($categoryId);
        $theme->setCategory($category);

        $form = $this->createForm(ThemeType::class, $theme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($theme);
            $entityManager->flush();

            return $this->redirectToRoute('theme_index');
        }

        return $this->render('theme/new.html.twig', [
            'theme' => $theme,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="theme_show", methods={"GET"})
     */
    public function show(Theme $theme): Response
    {
        return $this->render('theme/show.html.twig', [
            'theme' => $theme,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="theme_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Theme $theme): Response
    {
        $form = $this->createForm(ThemeType::class, $theme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('theme_index');
        }

        return $this->render('theme/edit.html.twig', [
            'theme' => $theme,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="theme_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Theme $theme): Response
    {
        if ($this->isCsrfTokenValid('delete'.$theme->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($theme);
            $entityManager->flush();
        }

        return $this->redirectToRoute('theme_index');
    }

    /**
     * @Route("/{id}/load", name="theme_load", methods={"GET"})
     */
    public function load(Request $request, Theme $theme): Response
    {
        $this->get('session')->set('theme_id', $theme->getId());

        return $this->redirectToRoute('lesson_index');
    }
}
