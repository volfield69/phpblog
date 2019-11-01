<?php

namespace App\Twig;

use App\Repository\CategoryRepository;
use App\Repository\LessonRepository;
use App\Repository\ThemeRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Class TitleExtension.
 */
class TitleExtension extends AbstractExtension
{
    private $categoryRepository;
    private $themeRepository;
    private $lessonRepository;
    private $session;

    /**
     * TitleExtension constructor.
     *
     * @param CategoryRepository $categoryRepository
     * @param ThemeRepository    $themeRepository
     * @param LessonRepository   $lessonRepository
     */
    public function __construct(CategoryRepository $categoryRepository, ThemeRepository $themeRepository, LessonRepository $lessonRepository, SessionInterface $session)
    {
        $this->categoryRepository = $categoryRepository;
        $this->themeRepository = $themeRepository;
        $this->lessonRepository = $lessonRepository;
        $this->session = $session;
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            // new TwigFilter('filter_name', [$this, 'doSomething']),
        ];
    }

    /**
     * @return array
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('category_name', [$this, 'categoryName']),
            new TwigFunction('theme_name', [$this, 'themeName']),
            new TwigFunction('lesson_name', [$this, 'lessonName']),
            new TwigFunction('category_id', [$this, 'categoryId']),
            new TwigFunction('theme_id', [$this, 'themeId']),
        ];
    }

    /**
     * @param $categoryId
     *
     * @return string
     */
    public function categoryName($categoryId): string
    {
        $category = $this->categoryRepository->find($categoryId);

        return $category ? $category->getTitle() : '';
    }

    /**
     * @param $themeId
     *
     * @return string
     */
    public function themeName($themeId): string
    {
        $theme = $this->themeRepository->find($themeId);

        return $theme ? $theme->getTitle() : '';
    }

    /**
     * @param $lessonId
     *
     * @return string
     */
    public function lessonName($lessonId): string
    {
        $lesson = $this->lessonRepository->find($lessonId);

        return $lesson ? $lesson->getTitle() : '';
    }

    /**
     * @return mixed
     */
    public function categoryId()
    {
        return $this->session->get('category_id', '');
    }

    /**
     * @return mixed
     */
    public function themeId()
    {
        return $this->session->get('theme_id', '');
    }
}
