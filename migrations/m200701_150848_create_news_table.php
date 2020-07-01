<?php

use yii\db\Migration;

/**
 * Handles the creation of table `news`.
 */
class m200701_150848_create_news_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('news', [
            'news_id' => $this->primaryKey(),
            'news_title'=> $this->string(100)->notNull()->defaultValue('Введите заголовок новости'),
            'news_text' => $this->text(),
        ]);
        $this->batchInsert(
             'news'
            ,['news_id','news_title','news_text']
            ,[   
                 [1,'В Москве предложили сдвинуть начало рабочего дня','Текст новости о начале рабочего дня ....']
                ,[2,'Новость из рубрики Салюты','Сегодня салютов не ожидается ....']
                ,[3,'Новости спорта','Сегодня состоится чемпионат по прыжкам в ширину ....']
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('news');
    }
}
