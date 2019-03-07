<?php
/**
 * Created by PhpStorm.
 * User: ordengord
 * Date: 06.03.19
 * Time: 17:54
 */

namespace App\Parser;

use App\Iterator\JsonExportIterator;
use App\Json\JsonDocumentObject;
use App\Json\JsonComposite;
use App\Json\JsonLeaf;

/**
 * Class JsonParser
 * @package App\Parser
 */
class JsonParser
{
    /**
     * @var \ArrayObject
     */
    protected $decoded;

    /**
     * JsonParser constructor.
     * @param $jsonFile
     */
    public function __construct($jsonFile)
    {
        $this->decoded = new \ArrayObject($jsonFile);
    }

    /**
     * @return JsonDocumentObject
     */
    public function parse()
    {
        $iter = new JsonExportIterator($this->decoded);

        $document = new JsonDocumentObject;

        $parents[] = $document;

        $iter = new \RecursiveIteratorIterator($iter, \RecursiveIteratorIterator::SELF_FIRST);

        foreach ($iter as $key => $value) {
            $currentParent = end($parents);
            if (array_key_exists('childrens', $value)) {
                $json = new JsonComposite($value['id'], $value['name'], $value['alias'], $currentParent);
                $parents[] = $json;
            } else {
                $json = new JsonLeaf($value['id'], $value['name'], $value['alias'], $currentParent);

                if ($iter->offsetExists($key + 1) === false) {
                    array_pop($parents);
                }
            }

            $currentParent->addChild($json);
        }

        return $document;
    }
}