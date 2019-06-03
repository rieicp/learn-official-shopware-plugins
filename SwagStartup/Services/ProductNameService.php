<?php
namespace SwagStartup\Services;

use Doctrine\DBAL\Connection;

class ProductNameService
{
    /**
     * @var Connection
     */
    protected $conn;

    /**
     * ProductNameService constructor.
     * @param Connection $conn
     */
    public function __construct(Connection $conn)//依赖注入
    {
        $this->conn = $conn;
    }

    public function getProductNames()
    {
        $query = $this->conn->createQueryBuilder();
        $query->select(['name'])
            ->from('s_articles')
            ->getMaxResults(20);

        //return $query->execute()->fetchAll();
        /**
         * 若$query->select()只选了一个列，
         * 则可以用PDO::FETCH_COLUMN模式，将array扁平化
         * 即，本来$productNames的每一个元素，都是一个array，唯一键为'name'，
         * 使用该模式后，每个元素不再是array，而是一个值
         */
        return $query->execute()->fetchAll(\PDO::FETCH_COLUMN);
    }
}