<?php

use yii\db\Migration;

/**
 * Class m230707_162501_create_table__client
 */
class m230707_162501_create_table__client extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%client}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull()->unique(),
            'sex' => "ENUM('М', 'Ж')",
            'birth_date' => $this->date(),
            'clubs' => $this->string()->notNull(),

            'created_at' => $this->integer()->notNull(),
            'user_created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'user_updated_at' => $this->integer()->notNull(),
            'deleted_at' => $this->integer(),
            'user_deleted_at' => $this->integer(),
        ]);

        $this->addForeignKey('fk_client__user_created', 'client', 'user_created_at', 'user', 'id');
        $this->addForeignKey('fk_client__user_updated', 'client', 'user_updated_at', 'user', 'id');
        $this->addForeignKey('fk_client__user_deleted', 'client', 'user_deleted_at', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%client}}');

        return true;
    }
}
