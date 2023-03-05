<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\DTO\EnterApplication;

class PartyInfo
{
    /** ЗАО/АО */
    public const ORG_TYPE_ZAO_AO = '100000000';
    /** ОАО/ПАО */
    public const ORG_TYPE_OAO_PAO = '100000001';
    /** ООО */
    public const ORG_TYPE_OOO = '100000002';
    /** Индивидуальный предприниматель */
    public const ORG_TYPE_IP = '100000003';
    /** Государственное предприятие */
    public const ORG_TYPE_GP = '100000004';
    /** Иная форма */
    public const ORG_TYPE_IF = '100000005';

    /** Иное */
    public const INDUSTRY_OTHER = 7;
    /** Риэлторская деятельность */
    public const INDUSTRY_REALTOR_ACTIVITY = 19;
    /** Строительство/Производство строительных материалов */
    public const INDUSTRY_BUILDING_MATERIALS = 22;
    /** Сфера услуг */
    public const INDUSTRY_SERVICE_SECTOR = 23;
    /** Розничная торговля */
    public const INDUSTRY_RETAIL_TRADE = 25;
    /** Добывающая промышленность/Топливно-энергетический комплекс/Металлургия и металлообработка */
    public const INDUSTRY_EXTRACTIVE_INDUSTRY_AND_ENERGY_AND_METALLURGY = 34;
    /** Машиностроение */
    public const INDUSTRY_MECHANICAL_ENGINEERING = 35;
    /** Легкая промышленность */
    public const INDUSTRY_LIGHT_INDUSTRY = 36;
    /** Пищевая промышленность */
    public const INDUSTRY_FOOD_INDUSTRY = 37;
    /** Производство товаров народного потребления */
    public const INDUSTRY_PRODUCTION_OF_CONSUMER_GOODS = 38;
    /** Химическая промышленность */
    public const INDUSTRY_CHEMICAL_INDUSTRY = 39;
    /** Фармацевтическая промышленность */
    public const INDUSTRY_PHARMACEUTICAL_INDUSTRY = 40;
    /** Информационные технологии/Телекоммуникации/Связь */
    public const INDUSTRY_INFORMATION_TECHNOLOGY = 41;
    /** Сельское и лесное хозяйство */
    public const INDUSTRY_AGRICULTURE_AND_FORESTRY = 42;
    /** Транспорт/Логистика/Складское хранение */
    public const INDUSTRY_LOGISTICS = 43;
    /** Оптовая торговля */
    public const INDUSTRY_WHOLESALE_TRADE = 44;
    /** Финансы/Банковское дело/Страхование/Консалтинг/Лизинг/Аудит */
    public const INDUSTRY_FINANCE = 45;
    /** Реклама/Маркетинг/PR */
    public const INDUSTRY_MARKETING = 46;
    /** СМИ/Издательская деятельность */
    public const INDUSTRY_MEDIA = 47;
    /** Здравоохранение/социальное обеспечение */
    public const INDUSTRY_HEALTH_AND_SOCIAL_SECURITY = 48;
    /** Образование/Наука/Культура/Спорт */
    public const INDUSTRY_EDUCATION_AND_CULTURE_AND_SPORT = 49;
    /** ЖКХ/Коммунальные и дорожные службы */
    public const INDUSTRY_MUNICIPAL_AND_ROAD_SERVICES = 50;
    /** Государственная служба */
    public const INDUSTRY_PUBLIC_SERVICE = 51;
    /** Вооруженные силы/Правоохранительные органы/Силовые структуры */
    public const INDUSTRY_POWER_STRUCTURES = 52;
    /** Частные охранные предприятия/Детективные агентства */
    public const INDUSTRY_PRIVATE_SECURITY_AND_DETECTIVE_COMPANIES = 53;
    /** Туристический/Гостиничный/Ресторанный бизнес */
    public const INDUSTRY_TOURIST_AND_RESTAURANT_BUSINESS = 54;
    /** Юридические услуги */
    public const INDUSTRY_LEGAL_SERVICES = 55;
    /** Игорный бизнес/Шоу-бизнес */
    public const INDUSTRY_GAMBLING_AND_SHOW_BUSINESS = 56;

    /** До 50 */
    public const NUMBER_OF_EMPLOYEE_LESS_THAN_50 = 100000000;
    /** От 51 до 100 */
    public const NUMBER_OF_EMPLOYEE_FROM_51_TILL_100 = 100000001;
    /** От 101 до 250 */
    public const NUMBER_OF_EMPLOYEE_FROM_101_TILL_250 = 100000002;
    /** От 251 и более */
    public const NUMBER_OF_EMPLOYEE_MORE_THAN_251 = 100000003;
    /** Нет данных */
    public const NUMBER_OF_EMPLOYEE_NO_INFO = 100000004;

    /**
     * ИНН.
     */
    public string $INN;

    /**
     * Список адресов компании.
     */
    public AddressList $AddressList;

    /**
     * Список контактов компании.
     */
    public ?ContactList $ContactList;

    /**
     * Наименования организации.
     */
    public NameList $NameList;

    /**
     * Организационно-правовая форма.
     */
    public ?string $OrgType;

    /**
     * Сфера деятельности организации.
     */
    public int $Industry;

    public ?int $NumberOfEmployee;

    public function __construct(
        NameList $NameList,
        string $INN,
        AddressList $AddressList,
        int $Industry,
        int $NumberOfEmployee
    ) {
        $this->INN = $INN;
        $this->AddressList = $AddressList;
        $this->NameList = $NameList;
        $this->Industry = $Industry;
        $this->NumberOfEmployee = $NumberOfEmployee;
    }
}
