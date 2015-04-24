<?php

use yii\db\Schema;
use yii\db\Migration;

class m150422_201046_user_table_seeder extends Migration
{
    public function up()
    {
        $this->insert('users', ['id' => 1, 'name' => 'admin', 'email' => 'admin@ejemplo.com', 'password' => 'ejemplo']);
    }

    public function down()
    {
        $this->truncateTable('users');
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
