<?php

use yii\db\Schema;
use yii\db\Migration;

class m150701_173212_user extends Migration
{
    public function up()
    {
        $this->execute('CREATE TABLE `user` (
         `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
         `parent_id` int(10) unsigned DEFAULT NULL,
         `username` varchar(255) NOT NULL,
         `password_hash` varchar(255) NOT NULL,
         `password_reset_token` varchar(255) NOT NULL DEFAULT "",
         `auth_key` varchar(32) NOT NULL DEFAULT "",
         `email` varchar(255) DEFAULT NULL,
         `status` tinyint(4) NOT NULL DEFAULT "1",
         `role` tinyint(4) NOT NULL DEFAULT "1",
         `created_at` datetime NOT NULL,
         `updated_at` datetime NOT NULL,
         PRIMARY KEY (`id`),
         UNIQUE KEY `username` (`username`),
         UNIQUE KEY `email` (`email`),
         KEY `status` (`status`),
         KEY `role` (`role`),
         KEY `parent_id` (`parent_id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8');
        
        $this->execute('CREATE TABLE `user_node` (
         `id` int(10) unsigned NOT NULL,
         `lft` bigint(20) unsigned NOT NULL,
         `rgt` bigint(20) unsigned NOT NULL,
         `lvl` int(10) unsigned NOT NULL,
         PRIMARY KEY (`id`),
         KEY `lft` (`lft`),
         KEY `rgt` (`rgt`),
         KEY `lvl` (`lvl`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8');
    }

    public function down()
    {
        echo "m150701_173212_user cannot be reverted.\n";

        return false;
    }
    
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}
