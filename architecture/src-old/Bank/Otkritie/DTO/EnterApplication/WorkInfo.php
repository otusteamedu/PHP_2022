<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\DTO\EnterApplication;

class WorkInfo
{
    /** Генеральный директор, Главбух, Заместитель директора */
    public const OCCUPANCY_DIRECTOR_CHIEF_ACCOUNTANT = 1;
    /** Руководитель подразделения/замруководителя подразделения */
    public const OCCUPANCY_HEAD_OF_DEPARTMENT = 2;
    /** Главный специалист компании */
    public const OCCUPANCY_CHIEF_COMPANY_SPECIALIST = 3;
    /** Сотрудник */
    public const OCCUPANCY_EMPLOYEE = 4;
    /** Технический специалист */
    public const OCCUPANCY_TECHNICAL_SPECIALIST = 5;
    /** Индивидуальный предприниматель */
    public const OCCUPANCY_INDIVIDUAL_ENTREPRENEUR = 6;
    /** Военнослужащий по контракту */
    public const OCCUPANCY_CONTRACT_SERVICEMAN = 7;

    /**
     * Является ли работа основной или нет. Основное место работы может быть только одно.
     */
    public BoolStringValue $JobType;

    /**
     * Дата трудоустройства.
     */
    public ?\DateTimeImmutable $BeginDate;

    /**
     * Должность.
     */
    public string $Position;

    /**
     * Стаж на текущем месте работы (мес.).
     */
    public int $Seniority;

    /**
     * Тип занятости.
     */
    public int $Occupancy;

    public function __construct(
        BoolStringValue $JobType,
        string $Position
    ) {
        $this->JobType = $JobType;
        $this->Position = $Position;
    }
}
