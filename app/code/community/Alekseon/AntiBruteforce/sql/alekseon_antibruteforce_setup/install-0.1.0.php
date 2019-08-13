<?php
/**
 * @author    Lukasz Linczewski
 * @email     contact@alekseon.com
 * @company   Alekseon
 * @website   www.alekseon.com
 */
$installer = $this;

$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('alekseon_antibruteforce/attemp'))
    ->addColumn('attemp_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Id')
    ->addColumn('ip', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
        'nullable'  => false,
    ), 'Ip')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        'nullable'  => false,
    ), 'Created at');
$installer->getConnection()->createTable($table);

$table2 = $installer->getConnection()
    ->newTable($installer->getTable('alekseon_antibruteforce/blocked'))
    ->addColumn('blocked_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Id')
    ->addColumn('ip', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
        'nullable'  => false,
    ), 'Ip');
$installer->getConnection()->createTable($table2);

$installer->endSetup();