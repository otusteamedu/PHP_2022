<?php

declare(strict_types=1);

namespace App\Controller\Report;


use App\Controller\Admin\BaseController;
use App\Entity\Student;
use App\Manager\CourseManager;
use App\Manager\ScoreManager;
use App\Manager\StudentManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as writer;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as reader;

use DateTime;

#[Route(path: '/report/report1')]
class ReportAction extends BaseController
{
    /**
     * @Route("/report.xlsx")
     */
    public function __construct(

        private ScoreManager  $scoreManager,
        private StudentManager $studentManager,
        private CourseManager $courseManager,
    )
    {

    }
    #[Route(path: '', name: 'report.get_form_report1',  methods: ['GET'])]
    public function getReportForm(Request $request)
    {

        $data = [
            'courses' => $this->courseManager->getCourses(1,20),
            //course->getStudents()
             'students' =>  array_map(static fn(Student $student) => $student->toArray(), $this->studentManager->getStudents(1,20)),
        ];

        return $this->render('admin/report/report_one_student.twig',$data );
    }

    #[Route(path: '/save', name: 'report.get_report1',  methods: ['POST'])]
    public function getCoursesAction(Request $request)
    {

        $startDate =  $request->request->get("startDate");
        $finishDate = $request->request->get("finishDate");
        $students = $request->request->get("students");
        $courseId = $request->request->get("course");

        $startDate =  \DateTime::createFromFormat('m/d/Y', $startDate);
        $finishDate =  \DateTime::createFromFormat('m/d/Y', $finishDate);

        if($courseId && !empty($students)) {
            $result =  $this->scoreManager->getScoreGroupByLessons($students, (int) $courseId,  $startDate, $finishDate);
        }

        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();

        $activeWorksheet->setCellValue('A1', 'ФИО студента');
        $activeWorksheet->setCellValue('B1', 'Урок');
        $activeWorksheet->setCellValue('C1', 'Балл');
        $activeWorksheet->setCellValue('D1', 'Максимальный балл');

        $activeWorksheet->getStyle("A1:D1")->getFont()->setBold(true);

        $i = 2;
        foreach ($result as $row) {
            $activeWorksheet->setCellValue('A'.$i, $row['fullName']);
            $activeWorksheet->setCellValue('B'.$i, $row['lesson']);
            $activeWorksheet->setCellValue('C'.$i, $row['sc']);
            $activeWorksheet->setCellValue('D'.$i, $row['maxScore']);
            $i++;
        }

        $writer = new writer($spreadsheet);
        $writer->save('reports/report_lesson.xlsx');

        return $this->render('admin/report/ready.twig',['filename' => 'report_lesson.xlsx'] );


    }
}