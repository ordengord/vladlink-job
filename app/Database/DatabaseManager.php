<?php
/**
 * Created by PhpStorm.
 * User: ordengord
 * Date: 07.03.19
 * Time: 0:14
 */

namespace App\Database;

use App\Json\JsonDocumentObject;

/**
 * Class DatabaseManager
 * @package App\Database
 */
class DatabaseManager
{
    use NotAwesomeSqlHelper;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * DatabaseManager constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function createDatabase(): void
    {
        $dsn = "mysql:host=" . $this->config['host'] . ";charset=" . $this->config['charset'];
        $pdo = new \PDO($dsn, $this->config['user'], $this->config['password']);
        $pdo->query("CREATE DATABASE IF NOT EXISTS " . self::angleQuotes($this->config['name']));
    }

    public function setUTF8Encode(): void
    {
        $sql = "ALTER DATABASE "
            . self::angleQuotes($this->config['name'])
            . " CHARACTER SET utf8 COLLATE utf8_general_ci";

        $this->pdo->query($sql);
    }

    public function createPDO(): void
    {
        $dsn = "mysql:host="
            . $this->config['host']
            . ";dbname="
            . $this->config['name']
            . ";charset="
            . $this->config['charset'];

        $this->pdo = new \PDO($dsn, $this->config['user'], $this->config['password']);
    }

    public function createCategoriesTable(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS " . self::angleQuotes($this->config['table']) . " (";

        foreach ($this->config['categories'] as $column => $value) {
            $sql .= self::angleQuotes($column) . ' ' . $value . ', ';
        }

        $sql = substr($sql, 0, strlen($sql) - 2);
        $sql .= ")";

        $this->pdo->query($sql);
    }

    public function getPDO(): \PDO
    {
        return $this->pdo;
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * @param JsonDocumentObject $jsonDocument
     */
    public function insertJsonData(JsonDocumentObject $jsonDocument): void
    {
        if ($this->isTableNotEmpty())
            return;

        $iter = new \RecursiveIteratorIterator($jsonDocument, \RecursiveIteratorIterator::SELF_FIRST);

        foreach ($iter as $json) {
            $sql = self::commonInsertSql();

            $sql .= $json->getID() . ', ';
            $sql .= self::singleQuotes($json->getName()) . ', ';
            $sql .= self::singleQuotes($json->getAlias()) . ', ';

            $sql .= ($json->getParent() !== $jsonDocument)
                ? $json->getParent()->getID() . ')'
                : '0)';

            $this->pdo->query($sql);
        }
    }

    protected function isTableNotEmpty(): bool
    {
        $sql = "SELECT * FROM " . self::angleQuotes($this->config['table']) . " LIMIT 1";
        $query = $this->pdo->prepare($sql);

        $query->execute();

        $result = $query->fetch();

        return $result === false ? false : true;
    }
}