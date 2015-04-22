<?php

use yii\db\Schema;
use yii\db\Migration;

class m150419_213310_add_status_column_to_examinations extends Migration
{
    //BORRA TODO ANTES ANDA!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!1
    public function up()
    {
        $this->truncateTable('answers');
        $this->truncateTable('tests_questions');        
        $this->truncateTable('tests');
        // $this->dropForeignKey('FK_answers_examinations', 'answers');
        $this->dropForeignKey('FK_answers_testQuestion', 'answers');
        $this->dropForeignKey('FK_answers_option', 'answers');
        $this->addForeignKey('FK_answers_examinations', 'answers', 'examination_id', 'examinations', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_answers_testQuestion', 'answers', 'test_question_id', 'tests_questions', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_answers_option', 'answers', 'option_id', 'options', 'id', 'CASCADE', 'CASCADE');
        $this->addColumn('examinations', 'status', 'BOOLEAN default 1');
    }

    public function down()
    {
        $this->addColumn('examinations', 'status', 'BOOLEAN default 1');
        $this->dropForeignKey('FK_answers_examinations', 'answers');
        $this->dropForeignKey('FK_answers_testQuestion', 'answers');
        $this->dropForeignKey('FK_answers_option', 'answers');
        $this->addForeignKey('FK_answers_examinations', 'answers', 'examination_id', 'examinations', 'id');
        $this->addForeignKey('FK_answers_testQuestion', 'answers', 'test_question_id', 'tests_questions', 'id');
        $this->addForeignKey('FK_answers_option', 'answers', 'option_id', 'options', 'id');
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
