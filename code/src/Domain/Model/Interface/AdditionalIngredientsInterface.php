<?php

namespace Otus\App\Domain\Model\Interface;

interface AdditionalIngredientsInterface
{
    //Для паттерна ДЕКОРАТОР
    public CONST ADD_CHEESE = 1;
    public CONST ADD_CARROT = 2;
    public CONST ADD_PEPPER = 3;
    public CONST ADD_BACON = 4;
    public CONST ADD_SAUCE = 5;
}