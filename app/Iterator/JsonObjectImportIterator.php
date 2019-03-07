<?php
/**
 * Created by PhpStorm.
 * User: ordengord
 * Date: 07.03.19
 * Time: 0:50
 */

namespace App\Iterator;

/**
 * Class JsonObjectImportIterator
 * This iterator is used for Sql table generation and type_a.txt file
 * @package App\Iterator
 */
class JsonObjectImportIterator extends \RecursiveArrayIterator
{
    public function hasChildren(): bool
    {
        return property_exists($this->current(), 'children') ? true : false;
    }

    /**
     * @return JsonObjectImportIterator|\RecursiveArrayIterator
     */
    public function getChildren()
    {
        $current = $this->current()->getChildren();

        return new JsonObjectImportIterator(new \ArrayObject($current));
    }

}