<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pet_user}}`.
 */
class m240112_080144_create_pet_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%pet_user}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'pet_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            '{{%fk-users-user_id}}',
            '{{%pet_user}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%pet_user}}');
    }
}
