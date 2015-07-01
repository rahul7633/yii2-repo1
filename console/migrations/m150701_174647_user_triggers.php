<?php

use yii\db\Schema;
use yii\db\Migration;

class m150701_174647_user_triggers extends Migration
{
    public function up()
    {
$insertNode = <<< SQL
CREATE TRIGGER insert_node AFTER INSERT ON `user`
FOR EACH ROW
  BEGIN
    DECLARE parentId, parentLeft, parentRight, parentLevel INT;
    
    IF (NEW.parent_id IS NOT NULL) THEN
        SELECT id, lft, rgt, lvl INTO @parentId, @parentLeft, @parentRight, @parentLevel 
            FROM `user_node`
            WHERE `id` = NEW.`parent_id`;
             
        UPDATE `user_node` SET `lft` = CASE WHEN `lft` >  @parentRight THEN `lft` + 2 ELSE `lft` END,
            `rgt` = CASE WHEN `rgt` >= @parentRight THEN `rgt` + 2 ELSE `rgt` END
            WHERE `rgt` >= @parentRight;
    ELSE
        SET @parentRight := 1;
        SET @parentLevel := -1;
    END IF;

    INSERT INTO user_node (`id`, `lft`, `rgt`, `lvl`)
        VALUES ( NEW.`id`, @parentRight, @parentRight + 1, @parentLevel + 1);
  END ;
SQL;

$getBranch = <<< SQL
CREATE PROCEDURE `get_branch` (IN parentId INT, IN lth INT)
BEGIN 
    DECLARE myLeft, myRight, myLevel, num INT;
    SELECT `lft`, `rgt`, `lvl` INTO myLeft, myRight, myLevel
        FROM `user_node` WHERE `id` = parentId
        LIMIT 1;
    
    /*SELECT COUNT(`id`) INTO num
        FROM `user_node` WHERE `id` = parentId;
    SELECT CONCAT('num ', num);*/
    
    /*SELECT CONCAT('id ', id, ' lft ', myLeft, ' rgt ', myRight, ' lvl ', myLevel);*/
    
    SELECT `user`.`id`, `user`.`parent_id`, CONCAT(REPEAT( '--', (`lvl` - myLevel) ), `username`) AS `label`, `username`, `lft`, `rgt`, `lvl`
        FROM `user_node`
        INNER JOIN `user` ON `user`.`id` = `user_node`.`id`
        WHERE `lft` >= myLeft
        AND `lft` < myRight
        AND `lvl` <= myLevel + lth
        ORDER BY `lft`;
    END ;
SQL;
        $this->execute('DROP TRIGGER IF EXISTS insert_node');
        $this->execute('DROP PROCEDURE IF EXISTS get_branch');
        $this->execute($insertNode);
        $this->execute($getBranch);
    }

    public function down()
    {
        echo "m150701_174647_user_triggers cannot be reverted.\n";

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
