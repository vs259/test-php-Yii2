<?php

use yii\db\Migration;

/**
 * Handles the creation of table `rubric`.
 */
class m200701_120016_create_rubric_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('rubric', [
            'rubric_id' => $this->primaryKey(),
            'rubric_title'=> $this->string(100)->notNull()->defaultValue('Введите название'),
            'parent_id' => $this->integer()->defaultValue(NULL),
        ]);
        $this->batchInsert(
             'rubric'
            ,['rubric_id','rubric_title','parent_id']
            ,[   [1,'Рубрика не задана',NULL]
                ,[2,'Общество',NULL]
                ,[3,'День города',NULL]
                ,[4,'Спорт',NULL]
                ,[5,'городская жизнь',2]
                ,[6,'выборы',2]
                ,[7,'салюты',3]
                ,[8,'детская площадка',3]
                ,[9,'0-3 года',8]
                ,[10,'3-7 лет',8]
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('rubric');
    }

}
