<?php
/**
 * Created by PhpStorm.
 * User: ordengord
 * Date: 07.03.19
 * Time: 3:02
 */

namespace App\Import;

use App\Database\DatabaseManager;
use App\Json\Interfaces\HasChildren;
use App\Json\JsonComposite;
use App\Json\JsonDocumentObject;

/**
 * Class BrowserImport
 * @package App\Import
 */
class BrowserImport
{
    protected const OFFSET = "&nbsp&nbsp&nbsp";

    /**
     * @param array $notProcessed
     * @param HasChildren $parent
     * @param int $parentId
     * @returns void
     */
    protected static function mysqlReverseParse(array $notProcessed, HasChildren $parent, int $parentId)
    {
        $children = array_filter($notProcessed, function ($value) use ($parentId) {
            return $value['parent_id'] == $parentId;
        });

        $notProcessed = array_diff_uassoc($notProcessed, $children, function ($a, $b) {
            return $a['id'] == $b['id'];
        });

        if (count($children)) {
            array_walk($children, function ($value) use (&$parent, &$notProcessed) {
                $json = new JsonComposite($value['id'], $value['name'], $value['alias'], $parent);
                $parent->addChild($json);
                return self::mysqlReverseParse($notProcessed, $json, $json->getID());
            });
        }
    }

    /**
     * @param DatabaseManager $db
     * @return array
     */
    public static function execute(DatabaseManager $db)
    {
        $sql = "SELECT * FROM " . $db->getConfig()['table'] . " ORDER BY `parent_id`";

        $result = $db->getPDO()->query($sql)->fetchAll();

        $jsonDocument = new JsonDocumentObject;

        self::mysqlReverseParse($result, $jsonDocument, 0);

        $iter = new \RecursiveIteratorIterator($jsonDocument, \RecursiveIteratorIterator::SELF_FIRST);

        $output = [];
        foreach ($iter as $json) {
            $row = str_repeat(self::OFFSET, $json->getNestLevel()) . $json->getName();
            $output[] = $row;
        }

        return $output;
    }
}