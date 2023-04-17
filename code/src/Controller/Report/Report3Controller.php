<?php

declare(strict_types=1);

namespace App\Controller\Report;



use App\Controller\Admin\BaseController;
use App\Entity\Student;
use App\Manager\CourseManager;
use App\Manager\ScoreManager;
use App\Manager\StudentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as writer;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as reader;

use DateTime;

#[Route(path: '/report/report3')]
class Report3Controller extends BaseController
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
    #[Route(path: '', name: 'report.get_form_report3',  methods: ['GET'])]
    public function getReportForm(Request $request)
    {

        $data = [
            'courses' => $this->courseManager->getCourses(1,20),
            //course->getStudents()
             'students' =>  array_map(static fn(Student $student) => $student->toArray(), $this->studentManager->getStudents(1,20)),
        ];

        return $this->render('admin/report/report_lesson_skill_task.twig',$data );
    }

    #[Route(path: '/save', name: 'report.get_report3',  methods: ['POST'])]
    public function getCoursesAction(Request $request)
    {

        $startDate =  $request->request->get("startDate");
        $finishDate = $request->request->get("finishDate");
        $students = $request->request->get("students");
        $courseId = $request->request->get("course");

        //$students = join(",",  $students);

        $startDate =  \DateTime::createFromFormat('m/d/Y', $startDate);
        $finishDate =  \DateTime::createFromFormat('m/d/Y', $finishDate);

       // dd($courseId,$students,$startDate, $finishDate);

        if($courseId && !empty($students)) {
            $result =  $this->scoreManager->getScoreGroupByLessonsAndSkillAndTask($students, (int) $courseId,  $startDate, $finishDate);
        }

        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();


        $activeWorksheet->setCellValue('A1', 'ФИО студента');
        $activeWorksheet->setCellValue('B1', 'Урок');
        $activeWorksheet->setCellValue('C1', 'Задание');
        $activeWorksheet->setCellValue('D1', 'Навык');
        $activeWorksheet->setCellValue('E1', 'Балл');

        $activeWorksheet->getStyle("A1:E1")->getFont()->setBold(true);

        $i = 2;
        foreach ($result as $row){
            $activeWorksheet->setCellValue('A'.$i, $row['fullName']);
            $activeWorksheet->setCellValue('B'.$i, $row['lesson']);
            $activeWorksheet->setCellValue('C'.$i, $row['task']);
            $activeWorksheet->setCellValue('D'.$i, $row['skillTitle']);
            $activeWorksheet->setCellValue('E'.$i, $row['sc']);
            $i++;
        }


        $writer = new writer($spreadsheet);
        $writer->save('reports/report_lesson_skill_task.xlsx');

        $reader = new reader();


        return $this->render('admin/report/ready.twig',['filename' => 'report_lesson_skill_task.xlsx'] );


    }
}