<?php

use yii\db\Migration;

class m170522_191437_cooperation extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

/**
*
*   cooperation
*
*/
        $this->createTable('{{%cooperation}}', [
            'id' => $this->primaryKey(),
            'cooperation_table' => $this->integer()->notNull(),
            'cooperation_id' => $this->integer()->notNull(),
            'cooperation_status' => $this->integer()->defaultValue(1),
            'user_id' => $this->integer()->notNull(),
            'status' => $this->boolean()->defaultValue(true),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ], $tableOptions);

        $this->createTable('{{%cooperation_tables}}', [
            'id' => $this->primaryKey(),
            'table' => $this->string()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%cooperation_statuses}}', [
            'id' => $this->primaryKey(),
            'status' => $this->string()->notNull(),
        ], $tableOptions);

        $columns = ['id', 'table'];
        $this->batchInsert('{{%cooperation_tables}}', $columns, [
            [1, 'companies'],
            [2, 'investors'],
        ]);

        $columns = ['id', 'status'];
        $this->batchInsert('{{%cooperation_statuses}}', $columns, [
            [1, 'Under consideration'],
            [2, 'Approved by'],
            [3, 'Rejected'],
        ]);

        $this->addForeignKey('{{%cooperation_table_id}}', '{{%cooperation}}', 'cooperation_table', '{{%cooperation_tables}}', 'id');
        $this->addForeignKey('{{%cooperation_status_id}}', '{{%cooperation}}', 'cooperation_status', '{{%cooperation_statuses}}', 'id');
        $this->addForeignKey('{{%cooperation_user_id}}', '{{%cooperation}}', 'user_id', '{{%user}}', 'id');
    }

    public function down()
    {
        $this->dropTable('{{%cooperation}}');
        $this->dropTable('{{%cooperation_tables}}');
        $this->dropTable('{{%cooperation_statuses}}');
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
