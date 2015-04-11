<?php

use yii\db\Schema;
use yii\db\Migration;

class m150318_224857_create_examination_table extends Migration
{
    public function up()
    {
        $this->createTable('examanitations', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'test_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'date' => Schema::TYPE_TIMESTAMP . ' NOT NULL'
        ]);
        $this->addForeignKey('FK_examination_test', 'examanitations', 'test_id', 'tests', 'id');
    }

    public function down()
    {
        $this->dropTable('examanitations');
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
