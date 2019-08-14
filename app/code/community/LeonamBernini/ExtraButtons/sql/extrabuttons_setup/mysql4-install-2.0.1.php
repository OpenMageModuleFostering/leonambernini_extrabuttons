<?php

$installer = $this;

$installer->startSetup();

$installer->run("

    -- DROP TABLE IF EXISTS {$this->getTable('lb_extrabuttons')};
    CREATE TABLE {$this->getTable('lb_extrabuttons')} (
        `id` int(11) unsigned NOT NULL auto_increment,
        `attribute_key` varchar(50) null,
        `title` varchar(255) NOT NULL default '',
        `filename` varchar(255) NOT NULL default '',
        `status` smallint(6) NOT NULL default '0',
        `stores` VARCHAR( 255 ) NOT NULL DEFAULT '0',
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

$installer->endSetup(); 