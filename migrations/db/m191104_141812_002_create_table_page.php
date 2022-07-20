<?php

use yii\db\Migration;

class m191104_141812_002_create_table_page extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%page}}', [
            'id' => $this->integer(11)->notNull()->append('AUTO_INCREMENT PRIMARY KEY')->comment('شناسه'),
            'slug' => $this->string(2048)->notNull()->comment('نامک'),
            'title' => $this->string(512)->notNull()->comment('عنوان'),
            'body' => $this->text()->notNull()->comment('متن'),
            'view' => $this->integer(11)->comment('بازدید'),
            'status' => $this->smallInteger(6)->notNull()->comment('وضعیت'),
            'created_at' => $this->integer(11)->comment('ایجاد شده در'),
            'updated_at' => $this->integer(11)->comment('آخرین ویرایش'),
            'template' => $this->string(31),
            'seo_keywords' => $this->string()->comment('کلمات کلیدی'),
            'seo_description' => $this->string()->comment('توضیحات'),
            'seo_schema_type' => $this->string(255)->comment('نوع شی اسکیما'),
            'seo_video_url' => $this->string(255)->comment('لینک ویدئو'),
            'seo_thumbnail_url' => $this->string(255)->comment('لینک تصویر کوچک'),
            'seo_image_url'=> $this->string(255)->comment('لینک تصویر'),
            'meta' => $this->text()->comment('متا'),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%page}}');
    }
}
