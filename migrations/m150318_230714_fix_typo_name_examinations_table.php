<?php

use yii\db\Schema;
use yii\db\Migration;

class m150318_230714_fix_typo_name_examinations_table extends Migration
{
    public function up()
    {
        $this->renameTable('examanitations', 'examinations');
    }

    public function down()
    {
        $this->renameTable('examinations', 'examanitations');
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
