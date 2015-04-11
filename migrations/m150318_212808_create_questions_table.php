<?php

use yii\db\Schema;
use yii\db\Migration;

class m150318_212808_create_questions_table extends Migration
{
    public function up()
    {
        $this->createTable('questions', [
            'id' => 'pk',
            'text' => Schema::TYPE_STRING . ' NOT NULL',
        ]);
    }

    public function down()
    {
        $this->dropTable('questions');
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
