<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pets}}`.
 */
class m240112_080118_create_pets_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%pets}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'imageFile' => $this->string(),
            'location' => $this->string(),
            'status' => $this->integer(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%pets}}');
    }
}
