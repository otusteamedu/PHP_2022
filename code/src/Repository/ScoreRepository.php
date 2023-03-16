<?php

namespace App\Repository;

use App\Entity\Score;
use App\Entity\Student;
use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DateTime;


class ScoreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Score::class);
    }

    /**
     * @param int $studentId
     * @param int $lessonId
     * @return array
     */
    public function getScoreByOneLesson(int $studentId, int $lessonId) : array
    {
        $result = [];
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('st.fullName fullName, l.title as lesson, sum(s.score) as sc')
            ->from($this->getClassName(), 's')
            ->join('s.student', 'st')
            ->join('s.task', 't')
            ->join('t.lesson', 'l')
            ->where('s.student = :studentId')
            ->andWhere('l.id = :lessonId')
            ->groupBy('fullName, lesson');

        $qb->setParameter('studentId', $studentId);
        $qb->setParameter('lessonId', $lessonId);
      //  $result  =  $qb->getQuery()->getResult();
        $result =  $qb->getQuery()->enableResultCache(null,"score_{$studentId}_{$lessonId}" )->getResult();

        //dump($qb->getQuery()->getSQL());

        return $result;
    }
    public function getScoreByAllLessons(int $studentId, DateTime $startDate = null, DateTime $finishDate = null) : array
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('st.fullName fullName, l.title as lesson, sum(s.score) as sc')
            ->from($this->getClassName(), 's')
            ->join('s.student', 'st')
            ->join('s.task', 't')
            ->join('t.lesson', 'l')
            ->where('s.student = :studentId');
        if(isset($startDate))
            $qb->andWhere('s.createdAt >= :startDate');
        if(isset($finishDate))
            $qb->andWhere('s.createdAt <= :finishDate');
        $qb->groupBy('fullName, lesson');

        $qb->setParameter('studentId', $studentId);
        if(isset($startDate))
            $qb->setParameter('startDate', $startDate);
        if(isset($finishDate))
            $qb->setParameter('finishDate', $finishDate);
        //print $qb->getQuery()->getSQL();
        $result =  $qb->getQuery()->enableResultCache(3600,"score_{$studentId}" )->getResult();
        return $qb->getQuery()->getResult();
    }
    public function getScoreBySkills(int $studentId, DateTime $startDate = null, DateTime $finishDate = null) : array
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('st.fullName fullName, sk.title as skill, sum(s.score) as sc')
            ->from($this->getClassName(), 's')
            ->join('s.student', 'st')
            ->join('s.task', 't')
            ->join('t.taskSkills', 'ts')
            ->join('ts.skill', 'sk')
            ->where('s.student = :studentId');
        if(isset($startDate))
            $qb->andWhere('s.createdAt >= :startDate');
        if(isset($finishDate))
            $qb->andWhere('s.createdAt <= :finishDate');
        $qb->groupBy('fullName, skill');

        $qb->setParameter('studentId', $studentId);
        if(isset($startDate))
            $qb->setParameter('startDate', $startDate);
        if(isset($finishDate))
            $qb->setParameter('finishDate', $finishDate);

        return  $result =  $qb->getQuery()->enableResultCache(3600,"score_{$studentId}" )->getResult();
    }
    public function getScoreByCourse(int $studentId, DateTime $startDate = null, DateTime $finishDate = null) : array
    {

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('st.fullName fullName, c.title as course, sum(s.score) as sc')
            ->from($this->getClassName(), 's')
            ->join('s.student', 'st')
            ->join('s.task', 't')
            ->join('t.lesson', 'l')
            ->join('l.course', 'c')
            ->where('s.student = :studentId');
        if(isset($startDate))
            $qb->andWhere('s.createdAt >= :startDate');
        if(isset($finishDate))
            $qb->andWhere('s.createdAt <= :finishDate');
        $qb->groupBy('fullName, course');

        $qb->setParameter('studentId', $studentId);
        if(isset($startDate))
            $qb->setParameter('startDate', $startDate);
        if(isset($finishDate))
            $qb->setParameter('finishDate', $finishDate);

        $result =  $qb->getQuery()->enableResultCache(3600,"score_{$studentId}" )->getResult();
    }

    public function getScoreByStudentAndCourse(int $studentId, int $courseId, DateTime $startDate = null, DateTime $finishDate = null) : ?int
    {

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select(' sum(s.score) as score')
            ->from($this->getClassName(), 's')
            ->join('s.student', 'st')
            ->join('s.task', 't')
            ->join('t.lesson', 'l')
            ->join('l.course', 'c')
            ->where('st.id = :studentId and c.id = :courseId');
        if(isset($startDate))
            $qb->andWhere('s.createdAt >= :startDate');
        if(isset($finishDate))
            $qb->andWhere('s.createdAt <= :finishDate');


        $qb->setParameter('studentId', $studentId);
        $qb->setParameter('courseId', $courseId);
        if(isset($startDate))
            $qb->setParameter('startDate', $startDate);
        if(isset($finishDate))
            $qb->setParameter('finishDate', $finishDate);

        $result  =  $qb->getQuery()->getResult();

        return $result[0]['score'];
    }


}
