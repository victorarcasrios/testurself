<?php

use yii\db\Schema;
use yii\db\Migration;

class m150318_214818_create_anwers_table extends Migration
{
    public function up()
    {
        $this->createTable( 'answers', [
            'id' => Schema::TYPE_PK,
            'question_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'text' => Schema::TYPE_STRING . ' NOT NULL',
            'correct' => Schema::TYPE_BOOLEAN . ' NOT NULL'
        ]);
        $this->addForeignKey('FK_answer_question', 'answers', 'question_id',
                                'questions', 'id');
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
