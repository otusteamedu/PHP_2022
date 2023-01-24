<?php

namespace Otus\Mvc\Application\Models\Entity;

use Otus\Mvc\Application\Models\Entity\ActiveRecordEntity;

class Races extends ActiveRecordEntity
{
    protected static $table = 'races';

    public static function allRaces(): array
    {
        $array_races = [];
        $k = 0;
        foreach (Races::findAll() as $races) {
            $array_races[$k] = [
                "race_id" => $races['race_id'],
                "race_name" => $races['race_name'],
                "race_place" => $races['race_place'],
                "race_description" => $races['race_description']
            ];
            $k++;
        }
        return $array_races;
    }

    public static function getRaceID($race_id): array
    {
        $races = Races::get('race_id', "$race_id");
        return $races;
    }

    public static function saveRace($race_name)
    {
        $new_race = new Races();
        $new_race->race_name = $race_name;
        $save_result = $new_race->save();
        return $save_result;
    }
}