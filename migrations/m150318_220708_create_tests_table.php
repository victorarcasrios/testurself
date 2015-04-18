<?php

use yii\db\Schema;
use yii\db\Migration;

class m150318_220708_create_tests_table extends Migration
{
    public function up()
    {
        $this->createTable('tests', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING.'(30) NOT NULL'
        ]);
    }

    public function down()
    {
        $this->dropTable('tests');
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
