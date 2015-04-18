<?php

use yii\db\Schema;
use yii\db\Migration;

class m150318_232816_addSinglePKto_tests_questions_table extends Migration
{
    public function up()
    {
        $this->addColumn('tests_questions', 'id', Schema::TYPE_INTEGER);
        $this->dropForeignKey('FK_tests_questions_to_tests', 'tests_questions');
        $this->dropForeignKey('FK_tests_questions_to_questions', 'tests_questions');
        $this->dropPrimaryKey('PK_tests_questions', 'tests_questions');
        $this->addPrimaryKey('PK_tests_questions', 'tests_questions', 'id');
        $this->addForeignKey('FK_tests_questions_to_tests', 'tests_questions', 'test_id', 
            'tests', 'id');
        $this->addForeignKey('FK_tests_questions_to_questions', 'tests_questions', 'question_id',
            'questions', 'id');
    }

    public function down()
    {
        $this->dropPrimaryKey('PK_tests_questions', 'tests_questions');
        $this->dropColumn('tests_questions', 'id');
        $this->addPrimaryKey('PK_tests_questions', 'tests_questions', ['test_id', 'question_id']);
        $this->addForeignKey('FK_tests_questions_to_tests', 'tests_questions', 'test_id', 
            'tests', 'id');
        $this->addForeignKey('FK_tests_questions_to_questions', 'tests_questions', 'question_id',
            'questions', 'id');
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
