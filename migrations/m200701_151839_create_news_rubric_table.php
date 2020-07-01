<?php

use yii\db\Migration;

/**
 * Handles the creation of table `news_rubric`.
 */
class m200701_151839_create_news_rubric_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('news_rubric', [
            'id' => $this->primaryKey(),
            'rubric_id'=> $this->integer(),
            'news_id' => $this->integer(),
        ]);

        // creates index for columns 
        $this->createIndex(
            'news_rubric_UN',
            'news_rubric',
            'rubric_id, news_id',
            true
        );

        $this->createIndex(
            'news_rubric_news_id_IDX',
            'news_rubric',
            'news_id'
        );

        $this->createIndex(
            'news_rubric_rubric_id_IDX',
            'news_rubric',
            'rubric_id'
        );

        // add foreign key for table 
        $this->addForeignKey(
            'news_rubric_news_FK',
            'news_rubric',
            'news_id',
            'news',
            'news_id',
            'CASCADE'
        );
        
        $this->addForeignKey(
            'news_rubric_rubric_FK',
            'news_rubric',
            'rubric_id',
            'rubric',
            'rubric_id',
            'CASCADE'
        );
        
        $this->batchInsert(
             'news_rubric'
            ,['id','rubric_id','news_id']
            ,[   
                 [3,3,2]
                ,[5,4,3]
                ,[1,5,1]
                ,[2,5,2]
                ,[4,7,2]
            ]
        );
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'news_rubric_rubric_FK',
            'news_rubric'
        );

        $this->dropForeignKey(
            'news_rubric_news_FK',
            'news_rubric'
        );

        // drops index for column 
        $this->dropIndex(
            'news_rubric_rubric_id_IDX',
            'news_rubric'
        );
        $this->dropIndex(
            'news_rubric_news_id_IDX',
            'news_rubric'
        );
        $this->dropIndex(
            'news_rubric_UN',
            'news_rubric'
        );
        $this->dropTable('news_rubric');
    }
}
