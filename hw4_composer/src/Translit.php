<?php

namespace nujensait\Translit;

/**
 * Class Translit
 * transliterate string to it's english equivalent
 * @author Mikhail <mishaikon@gmail.com>
 * @see usage example here: ./examples/example.php
 */

class Translit
{
    /**
     * Transform text to translit
     * @see #SPUTNIKSITE-2863
     * @param string $text
     * @param string $charset
     * @return string
     */
    public function transliterateText($text, $charset = 'Russian-Latin/BGN')
    {
        switch($charset) {
            case 'big5':
                $transliterator = 'Hex-Any;Simplified-Traditional';
                break;

            case 'serbian-latin':
                /**
                 * @see #SPUTNIKSITE-2115
                 * Транслитератор два символа - ћ, Ћ - каждый превращает в 2 символа вместо ć, Ć
                 * Imagick затем некрасиво накладывает это на изображение, поэтому здесь это исправляем
                 */
                $cyr = ['ћ', 'Ћ', 'я', 'Я'];
                $lat = ['ć','Ć', 'ja', 'JA'];
                $text = str_replace($cyr, $lat, $text);
                $transliterator = 'Serbian-Latin/BGN';
                break;

            case 'uzbek-latin':
                $transliterator = 'uz_Cyrl-uz_Latn';
                break;

            default:
                $locales = $this->getLocales();
                if(in_array($charset, $locales)) {
                    $transliterator = $charset;
                } else {
                    throw new \Exception("Error: locale $charset is not found/supported by transliterator.");
                }
        }

        if($transliterator && $text && function_exists('transliterator_transliterate')) {
            $text = transliterator_transliterate($transliterator, $text);
        } else {
            throw new \Exception("Error: transliterator_transliterate is not allowed; enable it's usage by setting intl library in php.ini: extension=intl");
        }

        return $text;
    }

    /**
     * Allowed locales list
     */
    public function getLocales()
    {
        $list = transliterator_list_ids();

        natcasesort ($list);

        return $list;
    }
}


