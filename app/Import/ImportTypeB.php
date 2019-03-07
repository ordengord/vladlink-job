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
 * Class ImportTypeB
 * @package App\Import
 */
class ImportTypeB
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
            $offset = str_repeat(self::OFFSET, $json->getNestLevel());
            $output[] = $offset . $json->getName();
        }

        return $output;
    }
}