<?php

use yii\db\Migration;

class m170505_133907_init_base extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
/**
*
*   companies
*
*/
        $this->createTable('{{%companies}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'address' => $this->string()->notNull(),
            'img_url' => $this->string(),
            'description' => $this->text(),
            'product_stage' => $this->integer()->notNull(),
            'revenue' => $this->integer()->notNull(),
            'raising' => $this->integer()->notNull(),
            'address_1' => $this->string(),
            'address_2' => $this->string(),
            'tel_1' => $this->string()->notNull(),
            'tel_2' => $this->string(),
            'fax' => $this->string(),
            'website' => $this->string(50),
            'user_id' => $this->integer()->notNull(),
            'status' => $this->boolean()->defaultValue(true),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ], $tableOptions);

        $this->createTable('{{%company_product_stage}}', [
            'id' => $this->primaryKey(),
            'stage' => $this->string()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%company_raising}}', [
            'id' => $this->primaryKey(),
            'raising' => $this->string()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%company_revenue}}', [
            'id' => $this->primaryKey(),
            'revenue' => $this->string()->notNull(),
        ], $tableOptions);

        $this->addForeignKey('{{%product_stage_id}}', '{{%companies}}', 'product_stage', '{{%company_product_stage}}', 'id');
        $this->addForeignKey('{{%revenue_id}}', '{{%companies}}', 'revenue', '{{%company_revenue}}', 'id');
        $this->addForeignKey('{{%raising_id}}', '{{%companies}}', 'raising', '{{%company_raising}}', 'id');
        $this->addForeignKey('{{%company_user_id}}', '{{%companies}}', 'user_id', '{{%user}}', 'id');

/**
*
*   investors
*
*/

        $this->createTable('{{%investors}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'address' => $this->string()->notNull(),
            'net_worth' => $this->string()->notNull(),
            'img_url' => $this->string(),
            'description' => $this->text(),
            'address_1' => $this->string(),
            'address_2' => $this->string(),
            'tel_1' => $this->string(50)->notNull(),
            'tel_2' => $this->string(50),
            'fax' => $this->string(50),
            'user_id' => $this->integer()->notNull(),
            'status' => $this->boolean()->defaultValue(true),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ], $tableOptions);

        $this->addForeignKey('{{%investor_user_id}}', '{{%investors}}', 'user_id', '{{%user}}', 'id');

        $columns = ['id', 'stage'];
        $this->batchInsert('{{%company_product_stage}}', $columns, [
            [1, 'Prototype'],
            [2, 'Beta'],
            [3, 'Complete'],
        ]);

        $columns = ['id', 'revenue'];
        $this->batchInsert('{{%company_revenue}}', $columns, [
            [1, 'Under 500k'],
            [2, 'Over 500k'],
            [3, 'Over 1m'],
            [4, 'Over 2m'],
        ]);

        $columns = ['id', 'raising'];
        $this->batchInsert('{{%company_raising}}', $columns, [
            [1, 'Angel - 100k to 500k'],
            [2, 'Seed - 500k to 1m'],
            [3, 'Series A - Over 1m'],
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%companies}}');
        $this->dropTable('{{%company_product_stage}}');
        $this->dropTable('{{%company_raising}}');
        $this->dropTable('{{%company_revenue}}');
        $this->dropTable('{{%investors}}');
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
