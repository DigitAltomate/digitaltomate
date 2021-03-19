<?php

namespace AmeliaBooking\Infrastructure\WP\InstallActions\DB\Bookable;

use AmeliaBooking\Domain\Common\Exceptions\InvalidArgumentException;
use AmeliaBooking\Infrastructure\WP\InstallActions\DB\AbstractDatabaseTable;

/**
 * Class PackagesCustomersTable
 *
 * @package AmeliaBooking\Infrastructure\WP\InstallActions\DB\Bookable
 */
class PackagesCustomersTable extends AbstractDatabaseTable
{

    const TABLE = 'packages_to_customers';

    /**
     * @return string
     * @throws InvalidArgumentException
     */
    public static function buildTable()
    {
        $table = self::getTableName();

        return "CREATE TABLE {$table}  (
                  `id` INT(11) NOT NULL AUTO_INCREMENT,
                  `packageId` INT(11) NOT NULL,
                  `customerId` INT(11) NOT NULL,
                  `price` DOUBLE NOT NULL,
                  `start` DATETIME NULL,
                  `end` DATETIME NULL,
                  `purchased` DATETIME NOT NULL,
                  PRIMARY KEY (`id`)
                ) DEFAULT CHARSET=utf8 COLLATE utf8_general_ci";
    }
}
