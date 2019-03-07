<?php
/**
 * Created by PhpStorm.
 * User: ordengord
 * Date: 06.03.19
 * Time: 17:53
 */

namespace App\Iterator;

/**
 * Class JsonExportIterator
 * @package App\Iterator
 */
class JsonExportIterator extends \RecursiveArrayIterator implements \RecursiveIterator
{
    public function hasChildren(): bool
    {
        return array_key_exists('childrens', $this->current()) ? true : false;
    }

    /**
     * @return JsonExportIterator|\RecursiveIterator
     */
    public function getChildren()
    {
        $current = $this->current()['childrens'];

        return new JsonExportIterator(new \ArrayObject($current));
    }
}