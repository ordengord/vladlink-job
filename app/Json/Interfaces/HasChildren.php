<?php
/**
 * Created by PhpStorm.
 * User: ordengord
 * Date: 05.03.19
 * Time: 21:46
 */

namespace App\Json\Interfaces;

/**
 * Interface HasChildren
 * @package App\Json\Interfaces
 */
interface HasChildren
{
    /**
     * @return array
     */
    public function getChildren();

    /**
     * @param HasParent $child
     * @return void
     */
    public function addChild(HasParent $child);
}