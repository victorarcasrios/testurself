<?php

use yii\db\Schema;
use yii\db\Migration;

class m150318_225618_create_tests_questions_table extends Migration
{
    public function up()
    {
        $this->createTable('tests_questions', [
            'test_id' => Schema::TYPE_INTEGER,
            'question_id' => Schema::TYPE_INTEGER
        ]);
        $this->addPrimaryKey('PK_tests_questions', 'tests_questions', ['test_id', 'question_id']);
        $this->addForeignKey('FK_tests_questions_to_tests', 'tests_questions', 'test_id', 
            'tests', 'id');
        $this->addForeignKey('FK_tests_questions_to_questions', 'tests_questions', 'question_id',
            'questions', 'id');
    }

    public function down()
    {
        $this->dropTable('tests_questions');
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
