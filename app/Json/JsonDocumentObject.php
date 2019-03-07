<?php
/**
 * Created by PhpStorm.
 * User: ordengord
 * Date: 06.03.19
 * Time: 15:30
 */

namespace App\Json;

use App\Iterator\JsonObjectImportIterator;
use App\Json\Interfaces\HasChildren;
use App\Json\Interfaces\HasParent;

/**
 * Class JsonDocumentObject
 * @package App\Json
 */
class JsonDocumentObject implements HasChildren, \IteratorAggregate
{
    /**
     * @var array
     */
    protected $children = [];

    public function getChildren(): array
    {
        return $this->children;
    }

    public function addChild(HasParent $child): void
    {
        $this->children[] = $child;
    }

    public function getIterator(): JsonObjectImportIterator
    {
        return new JsonObjectImportIterator($this->getChildren());
    }

    /*
        public function findJsonByID(int $id)
        {
            $iter = new \RecursiveIteratorIterator($this);
            foreach ($iter as $json) {
                if ($json->getID($id) == $id) {
                    return $json;
                }
            }
        }
    */
}