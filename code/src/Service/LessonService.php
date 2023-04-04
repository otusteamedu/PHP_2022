<?php


namespace App\Service;


use App\Manager\CourseManager;
use App\Manager\LessonManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

class LessonService
{
    private LessonManager $lessonManager;
    private CourseManager $courseManager;
    private AsyncService $asyncService;
    private TranslatorInterface $translator;

    public function __construct(LessonManager $lessonManager,AsyncService $asyncService, CourseManager $courseManager, TranslatorInterface $translator)
    {
        $this->lessonManager = $lessonManager;
        $this->courseManager = $courseManager;
        $this->asyncService = $asyncService;
        $this->translator = $translator;
    }

    public function saveLessonAndSendMail(string $title, int $courseId): ?int
    {
        $lessonId = $this->lessonManager->saveLesson($title, $courseId);
        if ($lessonId !== null) {
            $course = $this->courseManager->getCourse($courseId);
            foreach ($course->getStudents() as $student) {

                $message = json_encode(['email' => $student->getEmail(),
                    'subject' => AsyncService::MAIL_SUBJECT_ADDED_LESSON,
                    'text' => $this->translator->trans('letter.message', ['%name%' => $student->getName()])
                ],
                    JSON_THROW_ON_ERROR);
                $result = $this->asyncService->publishToExchange(AsyncService::SEND_MAIL, $message);
            }
        }
        return $lessonId;
    }
}