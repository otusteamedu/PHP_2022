<?php


namespace Study\Cinema\Service;
use Study\Cinema\Service\ArgumentCreator;

class QueryCreator
{
    private ArgumentCreator $argumentCreator;
    private string $query;
    private array $must = [];
    private array $filter = [];

    const QUERY_SECTION = [
        'must',
        'filter'
    ];
    const TYPE_TEXT = 'text';
    const TYPE_PHRASE = 'phrase';

    public function __construct(ArgumentCreator $argumentCreator)
    {
        $this->argumentCreator = $argumentCreator;
    }

    /**
     * Создает итоговую строку запроса, добавляя все секуции
     * @return string
     */
    private function getQueryString()
    {
        $this->addParamsToSection();
        $this->query ='{
          "query": {
            "bool":
            { ';
        $sectionIndex = 0;
        foreach (self::QUERY_SECTION as $section) {
           if(count($this->$section) == 0){
               continue;
           }
           if($sectionIndex)  $this->query .= ',';
           $section_string =  $this->addSection($section);
           if($section_string) $sectionIndex++;
           $this->query .= $section_string;

        }
        $this->query .= '}}}';
        return $this->query;

    }
    /**
     * Проходит по списку всех аргуметов и добавляет их в соответсвующую секцию поиска
     **/
    public function addParamsToSection()
    {
        foreach($this->argumentCreator->options as $argument => $value)
        {
            $section =  $this->argumentCreator::INDEX_FIELDS[$argument]['section'];
            $param_string = $this->addParam($argument, $this->argumentCreator::INDEX_FIELDS[$argument]['type'], $value);
            array_push($this->$section, $param_string);
        }

    }
    /**
     * Создает строку условия поиска по определенному параметру
    **/
    private function addParam($name, $type, $value)
    {
        $res = '';
        if($type == self::TYPE_TEXT) {
            $res =  '{ "match": {
                        "'.$name.'":
                                 {
                                    "query": "'.$value.'" ,
                                    "fuzziness": "auto"
                                 }
                        }
                }';
        }
        else if($type == self::TYPE_PHRASE) {
            $res =
                '{
                      "match_phrase": {
                        "'.$name.'": "'.$value.'"
                     }
                 }';
        }
        return $res;
    }

    public function addSection($section): ?string
    {
        $elCount = count($this->$section);
        if(!$elCount)
            return null;
        $section_string = ' "'.$section.'": [ ';
        for($i=0; $i < $elCount; $i++ ){
            if($i){
                $section_string .= ",";
            }
            $section_string .=  $this->$section[$i];
        }
        $section_string .= ']';
        return $section_string;
    }

    public function getParam()
    {

        $params = [
            'index' => 'otus-shop',
            'body' => $this->getQueryString()
        ];
        return $params;
    }
/*
    public function addParamToMust($param_string)
    {

        array_push($this->must, $param_string);

    }
    public function addParamToFilter($param_string)
    {
        array_push($this->filter, $param_string);
    }
*/
}