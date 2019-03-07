<?php
/**
 * Created by PhpStorm.
 * User: ordengord
 * Date: 05.03.19
 * Time: 21:54
 */

namespace App\Json;

use App\Json\Interfaces\HasChildren;
use App\Json\Interfaces\HasParent;

/**
 * Class JsonLeaf
 * @package App\Json
 */
class JsonLeaf implements HasParent
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $alias;

    /**
     * @var HasChildren
     */
    protected $parent;

    /**
     * JsonLeaf constructor.
     * @param $id
     * @param $name
     * @param $alias
     * @param $parent
     */
    public function __construct(int $id, string $name, string $alias, HasChildren $parent)
    {
        $this->id = $id;
        $this->name = $name;
        $this->alias = $alias;
        $this->parent = $parent;
    }

    public function getNestLevel(): int
    {
        return count($this->getAllParents());
    }

    public function getParent(): HasChildren
    {
        return $this->parent;
    }

    public function getID(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAlias(): string
    {
        return $this->alias;
    }

    public function getAllParents(): array
    {
        $parents = [];
        $json = $this;
        while (!$json->getParent() instanceof JsonDocumentObject) {
            $json = $json->getParent();
            array_unshift($parents, $json->getAlias());
        }

        return $parents;
    }

    public function setParent($parent): void
    {
        $this->parent = $parent;
    }

    public function AtypeImport(): string
    {
        $name = $this->name . ' ';

        $link = '/' . implode('/', $this->getAllParents());

        $link .= count($this->getAllParents()) == 0
            ? $this->alias
            : '/' . $this->alias;

        return $name . $link;
    }


}