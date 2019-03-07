<?php
/**
 * Created by PhpStorm.
 * User: ordengord
 * Date: 05.03.19
 * Time: 21:06
 */

namespace App\Json;

use App\Json\Interfaces\HasChildren;
use App\Json\Interfaces\HasParent;

/**
 * Class JsonComposite
 * @package App\Json
 */
class JsonComposite extends JsonLeaf implements HasChildren
{
    /**
     * @var array
     */
    protected $children = [];

    public function addChild(HasParent $child): void
    {
        $this->children[] = $child;
    }

    public function addChildren(array $children): void
    {
        $this->children = $children;
    }

    public function getParent(): HasChildren
    {
        return $this->parent;
    }

    public function getChildren(): array
    {
        return $this->children;
    }
}