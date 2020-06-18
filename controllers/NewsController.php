<?php
namespace app\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\db\ActiveQuery;

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

            $news = (new \yii\db\Query())
                    ->select('news.*')
                    ->from('news_rubric')
                    ->innerJoin('news', 'news.news_id = news_rubric.news_id')
                    ->where(['news_rubric.rubric_id' => $rubric_id])
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