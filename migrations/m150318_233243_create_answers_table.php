<?php

use yii\db\Schema;
use yii\db\Migration;

class m150318_233243_create_answers_table extends Migration
{
    public function up()
    {
        $this->createTable('answers', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER,
            'test_question_id' => Schema::TYPE_INTEGER,
            'option_id' => Schema::TYPE_INTEGER
        ]);
        $this->addForeignKey('FK_answer_testQuestion', 'answers', 'test_question_id',
            'tests_questions', 'id');
        $this->addForeignKey('FK_answer_option', 'answers', 'option_id', 'options', 'id');
    }

    public function down()
    {
        $this->dropTable('answers');
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
