<?php

use yii\db\Schema;
use yii\db\Migration;

class m150412_125026_cascade_for_testQuestions_testFK extends Migration
{
    public function up()
    {
        $this->dropForeignKey('FK_tests_questions_to_tests', 'tests_questions');
        $this->addForeignKey('FK_tests_questions_to_tests', 'tests_questions', 'test_id',
            'tests', 'id', 'CASCADE', 'CASCADE');
        $this->dropForeignKey('FK_tests_questions_to_questions', 'tests_questions');
        $this->addForeignKey('FK_tests_questions_to_questions', 'tests_questions', 'question_id',
            'questions', 'id', 'RESTRICT', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('FK_tests_questions_to_tests', 'tests_questions');
        $this->addForeignKey('FK_tests_questions_to_tests', 'tests_questions', 'test_id',
            'tests', 'id');
        $this->dropForeignKey('FK_tests_questions_to_questions', 'tests_questions');
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
