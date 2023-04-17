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

        //$students = join(",",  $students);

        $startDate =  \DateTime::createFromFormat('m/d/Y', $startDate);
        $finishDate =  \DateTime::createFromFormat('m/d/Y', $finishDate);

       // dd($courseId,$students,$startDate, $finishDate);

        if($courseId && !empty($students)) {
            $result =  $this->scoreManager->getScoreGroupByLessons($students, (int) $courseId,  $startDate, $finishDate);
        }






       // dd($result);

        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();

        $i = 1;
        foreach ($result as $row){
            $activeWorksheet->setCellValue('A'.$i, $row['fullName']);
            $activeWorksheet->setCellValue('B'.$i, $row['lesson']);
            $activeWorksheet->setCellValue('C'.$i, $row['sc']);
            $i++;
        }


        $writer = new writer($spreadsheet);
        $writer->save('reports/hello world.xlsx');


        $reader = new reader();



        return $this->render('admin/report/ready.twig',['filename' => 'hello world.xlsx'] );


    }
}