<?php

use yii\db\Schema;
use yii\db\Migration;

class m150411_203833_make_testquestions_id_autoincrementable extends Migration
{
    public function up()
    {
        $this->alterColumn('tests_questions', 'id', 'INT(11) auto_increment');
    }

    public function down()
    {
        $this->alterColumn('tests_questions', 'id', 'INT(11)');
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
