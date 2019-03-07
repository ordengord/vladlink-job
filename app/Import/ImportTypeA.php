<?php
/**
 * Created by PhpStorm.
 * User: ordengord
 * Date: 07.03.19
 * Time: 3:52
 */

namespace App\Import;

use App\Json\JsonDocumentObject;

/**
 * Class ImportTypeA
 * @package App\Import
 */
class ImportTypeA
{
    protected const OFFSET = "   ";

    /**
     * @param JsonDocumentObject $jsonDocument
     * @return array
     */
    public static function execute(JsonDocumentObject $jsonDocument)
    {
        $iter = new \RecursiveIteratorIterator($jsonDocument, \RecursiveIteratorIterator::SELF_FIRST);

        $output = [];

        foreach ($iter as $json) {
            $aType = $json->AtypeImport();

            $offset = str_repeat(self::OFFSET, substr_count($aType, '/'));

            $result = $offset . ' ' . $aType;

            $output[] = $result;
        }

        return $output;
    }
}