<?php

use yii\db\Migration;

class m161220_163812_insert_tbl_blog_type extends Migration
{
    public function up()
    {
        $this->insert('blog_type', ['title' => 'Blog', 'alias' => 'blog', 'show_category' => 1]);
    }

    public function down()
    {
        return true;
    }
}
