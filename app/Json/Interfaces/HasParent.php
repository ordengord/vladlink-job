<?php
/**
 * Created by PhpStorm.
 * User: ordengord
 * Date: 06.03.19
 * Time: 16:20
 */

namespace App\Json\Interfaces;

/**
 * Interface HasParent
 * @package App\Json\Interfaces
 */
interface HasParent
{
    /**
     * @return HasChildren
     */
    public function getParent();

    /**
     * @return array
     */
    public function getAllParents();

    /**
     * @return int
     */
    public function getNestLevel();
}