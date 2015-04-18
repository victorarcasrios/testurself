<?php

use yii\db\Schema;
use yii\db\Migration;

class m150319_202329_create_users_authority_relations extends Migration
{
    public function up()
    {
        $this->addColumn('questions', 'user_id', Schema::TYPE_INTEGER.' NOT NULL');
        $this->addForeignKey('FK_questions_users', 'questions', 'user_id', 'users', 'id');
        
        $this->addColumn('tests', 'user_id', Schema::TYPE_INTEGER.' NOT NULL');
        $this->addForeignKey('FK_tests_users', 'tests', 'user_id', 'users', 'id');
        
        $this->addForeignKey('FK_examinations_users', 'examinations', 'user_id', 'users', 'id');
        
        // To know to wich examination belongs each answer
        $this->renameColumn('answers', 'user_id', 'examination_id');
        $this->addForeignKey('FK_answers_examinations', 'answers', 'examination_id',
            'examinations', 'id');
    }

    public function down()
    {
        $this->dropForeignKey('FK_questions_users', 'questions');
        $this->dropColumn('questions', 'user_id');
        
        $this->dropForeignKey('FK_tests_users', 'tests');
        $this->dropColumn('tests', 'user_id');

        $this->dropForeignKey('FK_examinations_users', 'examinations');
        
        $this->dropForeignKey('FK_answers_examinations', 'answers');
        $this->renameColumn('answers', 'examination_id', 'user_id');
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
