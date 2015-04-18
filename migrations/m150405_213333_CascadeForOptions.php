<?php

use yii\db\Schema;
use yii\db\Migration;

class m150405_213333_CascadeForOptions extends Migration
{
    public function up()
    {
        $this->dropForeignKey('FK_answer_question', 'options');
        $this->addForeignKey('FK_options_question', 'options', 'question_id',
            'questions', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('FK_options_question', 'options');
        $this->addForeignKey('FK_answer_question', 'options', 'question_id',
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
