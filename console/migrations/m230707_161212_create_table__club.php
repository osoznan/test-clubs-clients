<?php

use yii\db\Migration;

/**
 * Class m230707_161212_create_table__club
 */
class m230707_161212_create_table__club extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%club}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull()->unique(),
            'address' => $this->string(),

            'created_at' => $this->integer()->notNull(),
            'user_created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'user_updated_at' => $this->integer()->notNull(),
            'deleted_at' => $this->integer(),
            'user_deleted_at' => $this->integer(),
        ]);

        $this->addForeignKey('fk_club__user_created', 'club', 'user_created_at', 'user', 'id');
        $this->addForeignKey('fk_club__user_updated', 'club', 'user_updated_at', 'user', 'id');
        $this->addForeignKey('fk_club__user_deleted', 'club', 'user_deleted_at', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%club}}');

        return true;
    }

}
