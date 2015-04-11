<?php

use yii\db\Schema;
use yii\db\Migration;

class m150318_231919_rename_answers_table extends Migration
{
    public function up()
    {
        $this->renameTable('answers', 'options');
    }

    public function down()
    {
        $this->renameTable('options', 'answers');
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
