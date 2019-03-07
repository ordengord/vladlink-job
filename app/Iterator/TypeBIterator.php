<?php
/**
 * Created by PhpStorm.
 * User: ordengord
 * Date: 07.03.19
 * Time: 14:21
 */

namespace App\Iterator;

/**
 * Class TypeBIterator
 * @package App\Iterator
 */
class TypeBIterator
{
    public function hasChildren(): bool
    {
        $current = $this->current();
        $level = $current->getNestLevel();
        return property_exists($current, 'children') && $level == 0 ? true : false;
    }

    /**
     * @return JsonObjectImportIterator
     */
    public function getChildren()
    {
        $current = $this->current()->getChildren();

        return new JsonObjectImportIterator(new \ArrayObject($current));
    }
}