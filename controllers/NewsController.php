<?php
namespace app\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\db\ActiveQuery;
use \yii\db\Query;

use app\models\News;

class NewsController extends ActiveController
{
    public $modelClass = 'app\models\News';
    
    /* Declare actions supported by APIs (Added in api/modules/v1/components/controller.php too) */
    public function actions(){
        $actions = parent::actions();
        unset($actions['create']);
        unset($actions['update']);
        unset($actions['delete']);
        unset($actions['view']);
        unset($actions['index']);
        return $actions;
    }

    /* Declare methods supported by APIs */
    protected function verbs(){
        return [
            'index'=>['GET'],
        ];
    }
    
    public function actionIndex()
    {
        $rubric_id = Yii::$app->request->get('rubric_id');
        if(isset($rubric_id)){

            $news = (new Query())
                    ->select('news.*')
                    ->from('news_rubric')
                    ->innerJoin('news', 'news.news_id = news_rubric.news_id')
                    ->where(['news_rubric.rubric_id' => $rubric_id])
                    ->all();
            return $news;
        }
        
        $parent_id = Yii::$app->request->get('parent_id');
        if(isset($parent_id)){
            $news = Yii::$app->db->createCommand(
                    "
                    select distinct n.* 
                    from news_rubric as nr 
                            inner join news as n
                                    on n.news_id = nr.news_id
                    where nr.rubric_id in (
                    select  r.rubric_id
                    from rubric as r
                    where r.rubric_id = :id
                    union 
                    select  rubric_id
                    from    (select * from rubric
                    order by parent_id, rubric_id) as rubric_sorted,
                    (select @pv := :id) initialisation
                    where   find_in_set(parent_id, @pv)
                    and     length(@pv := concat(@pv, ',', rubric_id)))                    
                    "
                    , ['id' => $parent_id])
                    ->queryAll();
            return $news;
        }
        
        
        $id = Yii::$app->request->get('id');
        if(isset($id)){
            $news = (new Query())
                    ->select('rubric.*')
                    ->from('news')
                    ->rightJoin('news_rubric', 'news.news_id = news_rubric.news_id')
                    ->innerJoin('rubric', 'rubric.rubric_id = news_rubric.rubric_id')
                    ->where(['news.news_id' => $id])
                    ->all();
            return $news;
        }
        
        $news_id = Yii::$app->request->get('news_id');
        if(isset($news_id))
            return News::findOne($news_id);  
        else
            return News::find()->all();        
        }
    
}

?>