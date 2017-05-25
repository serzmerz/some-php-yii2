<?php

use yii\db\Migration;

class m170522_181420_menu extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

/**
*
*   menu
*
*/
        $this->createTable('{{%menu}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'code' => $this->string(),
            'description' => $this->string(),
            'status' => $this->boolean()->defaultValue(true),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ], $tableOptions);

        $columns = ['id', 'name', 'code', 'description', 'status', 'created_at', 'updated_at'];
        $this->batchInsert('{{%menu}}', $columns, [
            [1, 'Cabinet', 'top-menu', 'Menu cabinet basic', 1, NULL, NULL],
            [2, 'Cabinet', 'content-menu', 'Menu cabinet content', 1, NULL, NULL],
        ]);

/**
*
*   menu_item
*
*/
        $this->createTable('{{%menu_item}}', [
            'id' => $this->primaryKey(),
            'parent' => $this->integer()->defaultValue(0),
            'menu' => $this->integer()->notNull(),
            'title' => $this->string(150)->notNull(),
            'href' => $this->string(150)->notNull(),
            'sort' => $this->integer()->defaultValue(1),
            'status' => $this->boolean()->defaultValue(true),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ], $tableOptions);

        $columns = ['id', 'parent', 'menu', 'title', 'href', 'sort', 'status', 'created_at', 'updated_at'];
        $this->batchInsert('{{%menu_item}}', $columns, [
            [1, 0, 1, 'My Companies', '/cabinet/companies', 1, 1, NULL, NULL],
            [2, 0, 1, 'My Investors', '/cabinet/investors', 2, 1, NULL, NULL],
            [3, 0, 1, 'Cooperation', '/cabinet/cooperation', 3, 1, NULL, NULL],
            [4, 0, 2, 'My Companies', '/cabinet/companies', 1, 1, NULL, NULL],
            [5, 0, 2, 'My Investors', '/cabinet/investors', 2, 1, NULL, NULL],
            [6, 0, 2, 'Cooperation', '/cabinet/cooperation', 3, 1, NULL, NULL],
        ]);

        $this->addForeignKey('{{%menu_id}}', '{{%menu_item}}', 'menu', '{{%menu}}', 'id');

    }

    public function down()
    {
        $this->dropTable('{{%menu}}');
        $this->dropTable('{{%menu_item}}');
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
