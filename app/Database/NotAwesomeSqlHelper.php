<?php
/**
 * Created by PhpStorm.
 * User: ordengord
 * Date: 08.03.19
 * Time: 0:12
 */

namespace App\Database;

/**
 * Trait NotAwesomeSqlHelper
 * @package App\Database
 */
trait NotAwesomeSqlHelper
{
    /**
     * @param string $item
     * @return string
     */
    private static function angleQuotes(string $item)
    {
        return str_replace($item, "`" . $item . "`", $item);
    }

    /**
     * @param string $item
     * @return string
     */
    private static function singleQuotes(string $item)
    {
        return str_replace($item, "'" . $item . "'", $item);
    }

    /**
     * @return string
     */
    private function commonInsertSql()
    {
        $sql = "INSERT INTO " . self::angleQuotes($this->config['table']) . " (";

        $columns = array_keys($this->config['categories']);

        array_walk($columns, function ($column) use (&$sql) {
            $sql .= self::angleQuotes($column) . ', ';
        });

        $sql = substr($sql, 0, strlen($sql) - 2);
        $sql .= ") VALUES (";

        return $sql;
    }
}