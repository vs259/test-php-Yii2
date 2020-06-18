<?php
namespace app\controllers;

use yii\rest\ActiveController;

class NewsController extends ActiveController
{
    public $modelClass = 'app\models\News';
    
    public function actionIndex()
    {
        $modelClass = $this->modelClass;        
        $query = $modelClass::findOne([
        'news_id' => Yii::$app->request->get('news_id'),
    ]);
        return new ActiveDataProvider([
            'query' => $query,
        ]);

    }
    
}

?>