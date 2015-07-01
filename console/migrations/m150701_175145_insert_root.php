<?php

use yii\db\Schema;
use yii\db\Migration;

class m150701_175145_insert_root extends Migration
{
    public function up()
    {
        $this->execute('INSERT INTO `user` (username, password_hash, auth_key, created_at, updated_at) 
            VALUES ("root", "$2y$13$18J.gQQRUqRnmrAXg8JhZO3NGBo8yIIw.VziXD1T.I.MGdurMv.jy", "eBEYymgKQ4fJPZ_xNNWXmY7bSHL_woLt", "2015-06-27 09:12:25", "2015-06-27 09:12:25")');
    }

    public function down()
    {
        echo "m150701_175145_insert_root cannot be reverted.\n";

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
