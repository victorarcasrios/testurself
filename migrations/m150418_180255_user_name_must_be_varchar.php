<?php

use yii\db\Schema;
use yii\db\Migration;

class m150418_180255_user_name_must_be_varchar extends Migration
{
    public function up()
    {
        $this->alterColumn('users', 'name', 'VARCHAR(15)');
    }

    public function down()
    {
        $this->alterColumn('users', 'name', 'INT(20)');
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
