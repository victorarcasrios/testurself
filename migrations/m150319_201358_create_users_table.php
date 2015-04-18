<?php

use yii\db\Schema;
use yii\db\Migration;

class m150319_201358_create_users_table extends Migration
{
    public function up()
    {
        $this->createTable('users', [
            'id'    => Schema::TYPE_PK,
            'name'  => Schema::TYPE_INTEGER.'(20) UNIQUE NOT NULL',
            'email' => Schema::TYPE_STRING.' UNIQUE NOT NULL',
            'password' => Schema::TYPE_STRING.'(100) NOT NULL'
        ]);
    }

    public function down()
    {
        $this->dropTable('users');
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
