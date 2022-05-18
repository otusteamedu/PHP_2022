<?php

namespace Patterns\Adapter;

class JsonReport
{
    public function buildJson(): string
    {
        return
        '[
              {
                "club_id": 1,
                "institution_id": 192,
                "city_id": 22,
                "address": "Россия, Архангельская область, Архангельск",
                "latitude": 64.539911,
                "longitude": 40.515762,
                "full_name": "Тестовый клуб",
                "short_name": "Тест 1",
                "logo": null,
                "cover": null,
                "management_public": 1,
                "stadiums_public": 1,
                "documents_public": 1,
                "partners_public": 1,
                "created_by": 1,
                "updated_by": 1,
                "created_at": 1638783361,
                "updated_at": 1638783361
              },
              {
                "club_id": 2,
                "institution_id": 301,
                "city_id": 185,
                "address": "Россия, Севастополь, улица Хрусталёва, 157",
                "latitude": 44.556381,
                "longitude": 33.525053,
                "full_name": "Медведи",
                "short_name": "Медведи",
                "logo": "626140ddbd8d0.jpg",
                "cover": null,
                "management_public": 1,
                "stadiums_public": 1,
                "documents_public": 1,
                "partners_public": 1,
                "created_by": 1,
                "updated_by": 1,
                "created_at": 1640774901,
                "updated_at": 1650540919
              },
              {
                "club_id": 3,
                "institution_id": 247,
                "city_id": 1123647,
                "address": "Россия, Амурская область, 10К-049",
                "latitude": 50.086160,
                "longitude": 129.040889,
                "full_name": "Cleo Ware",
                "short_name": "Hadley Luna",
                "logo": null,
                "cover": null,
                "management_public": 1,
                "stadiums_public": 1,
                "documents_public": 1,
                "partners_public": 1,
                "created_by": 1,
                "updated_by": 1,
                "created_at": 1649319765,
                "updated_at": 1650459076
              },
              {
                "club_id": 4,
                "institution_id": 208,
                "city_id": 1,
                "address": "Россия, Москва, Красная площадь, 1",
                "latitude": 55.755658,
                "longitude": 37.617411,
                "full_name": "Тест",
                "short_name": "Тест",
                "logo": null,
                "cover": null,
                "management_public": 1,
                "stadiums_public": 1,
                "documents_public": 1,
                "partners_public": 1,
                "created_by": 1,
                "updated_by": 1,
                "created_at": 1650459973,
                "updated_at": 1650459973
              }
        ]';
    }
}
