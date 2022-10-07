<?php

return [
    'dialog_menu' => [
        1 => 'Заголовок',
        2 => 'Перечень заголовоков',
        3 => 'Категория',
        4 => 'Перечень категорий',
        5 => 'Цена',
        6 => 'Диапазон цен',
        7 => 'Остаток',
        8 => 'Диапазон остатков',
        9 => 'Магазин',
        10 => 'Перечень магазинов',
        11 => 'Каталожный номер',
    ],

    'dialog_menu_map' => [
        1 => [
            'internal_key' => 'title',
            'transliterate' => 'заголовка',
            // взаимоисключающее поле - если выбрано поле title, то выбирать title_list запрещается
            'mutually_exclusive_field' => 'title_list',
        ],
        2 => [
            'internal_key' => 'title_list',
            'transliterate' => 'списка заголовков',
            'mutually_exclusive_field' => 'title',
        ],
        3 => [
            'internal_key' => 'category',
            'transliterate' => 'категории',
            'mutually_exclusive_field' => 'category_list',
        ],
        4 => [
            'internal_key' => 'category_list',
            'transliterate' => 'списка категорий',
            'mutually_exclusive_field' => 'category',
            'explanation' => 'Вводить список как: категория_1,категория_2',
        ],
        5 => [
            'internal_key' => 'price',
            'transliterate' => 'цены',
            'explanation' => 'десятичный разделитель - точка',
        ],
        6 => [
            'internal_key' => 'price_range',
            'transliterate' => 'Диапазона цен',
            'explanation' => 'Вводить диапазон как два числа через тире (от меньшего к большему): 100-2500',
        ],
        7 => [
            'internal_key' => 'stock',
            'transliterate' => 'остатков',
        ],
        8 => [
            'internal_key' => 'stock_range',
            'transliterate' => 'диапазона остатков',
            'explanation' => 'Вводить диапазон как два числа через тире (от меньщего к большему): 10-35',
        ],
        9 => [
            'internal_key' => 'shop',
            'transliterate' => 'магазина',
            'mutually_exclusive_field' => 'shop_list',
        ],
        10 => [
            'internal_key' => 'shop_list',
            'transliterate' => 'списка магазинов',
            'mutually_exclusive_field' => 'shop',
        ],
        11 => [
            'internal_key' => 'sku',
            'transliterate' => 'каталожного номера',
            'explanation' => 'Вид каталожного номера: 123-456',
        ],
    ],
];
