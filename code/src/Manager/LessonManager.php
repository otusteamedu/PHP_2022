<?php

namespace App\Manager;

use App\Entity\Course;
use App\Entity\Lesson;
use App\Manager\CommonManager;
use App\Repository\LessonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class LessonManager implements CommonManager
{
    private const CACHE_TAG = 'lessons';
    private EntityManagerInterface $entityManager;
    private TagAwareCacheInterface $cache;


    public function __construct(EntityManagerInterface $entityManager,  TagAwareCacheInterface $cache)
    {
        $this->entityManager = $entityManager;
        $this->cache = $cache;
    }

    public function saveLesson(string $title, int $courseId): ?int
    {
        $course = $this->entityManager->getRepository(Course::class)->find($courseId);
        if ($course === null) {
            return false;
        }
        $lesson = new Lesson();
        $lesson->setTitle($title);
        $lesson->setCourse($course);
        $this->entityManager->persist($lesson);
        $this->entityManager->flush();
        $this->cache->invalidateTags([self::CACHE_TAG]);

        return $lesson->getId();
    }

    public function updateLesson(int $lessonId, string $title, int $courseId): bool
    {
        /** @var LessonRepository $lessonRepository */
        $lessonRepository = $this->entityManager->getRepository(Lesson::class);
        /** @var Lesson $lesson */
        $lesson = $lessonRepository->find($lessonId);
        if ($lesson === null) {
            return false;
        }
        $course = $this->entityManager->getRepository(Course::class)->find($courseId);
        if ($course === null) {
            return false;
        }
        $lesson->setTitle($title);
        $lesson->setCourse($course);
        $this->entityManager->flush();
        $this->cache->invalidateTags([self::CACHE_TAG]);

        return true;
    }

    public function deleteLesson(int $lessonId): bool
    {
        /** @var LessonRepository $lessonRepository */
        $lessonRepository = $this->entityManager->getRepository(Lesson::class);
        /** @var Lesson $lesson */
        $lesson = $lessonRepository->find($lessonId);
        if ($lesson === null) {
            return false;
        }
        $this->entityManager->remove($lesson);
        $this->entityManager->flush();
        $this->cache->invalidateTags([self::CACHE_TAG]);

        return true;
    }

    /**
     * @return Lesson[]
     */
    public function getLessons(int $page, int $perPage, int $courseId): array
    {
        /** @var LessonRepository $lessonRepository */
        $lessonRepository = $this->entityManager->getRepository(Lesson::class);

        /** @var ItemInterface $organizationsItem */
        return $this->cache->get(
            "lessons_{$page}_{$perPage}",
            function(ItemInterface $item) use ($lessonRepository, $page, $perPage, $courseId) {
                $lessons = $lessonRepository->getLessonsSortByTitle($page ?? self::PAGINATION_DEFAULT_PAGE, $perPage ?? self::PAGINATION_DEFAULT_PER_PAGE, $courseId);
                $lessonSerialized = array_map(static fn(Lesson $lesson) => $lesson->toArray(), $lessons);
                $item->set($lessonSerialized);
                $item->tag(self::CACHE_TAG);

                return $lessonSerialized;
            }
        );
    }
    /**
     * @return Lesson
     */
    public function getLesson(int $lessonId): Lesson
    {
        /** @var LessonRepository $lessonRepository */
        $lessonRepository = $this->entityManager->getRepository(Lesson::class);

        return $lessonRepository->find($lessonId);
    }

}