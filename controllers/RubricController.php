<?php
namespace app\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\db\ActiveQuery;
use \yii\db\Query;

use app\models\Rubric;

class RubricController extends ActiveController
{
    public $modelClass = 'app\models\Rubric';
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
            $rubrics = Yii::$app->db->createCommand(
                    "select  r.rubric_id, r.rubric_title, r.parent_id
                      from rubric as r
                        where r.rubric_id = :id
                    union 
                    select  rubric_id, rubric_title, parent_id
                        from    (select * from rubric
                            order by parent_id, rubric_id) as rubric_sorted,
                        (select @pv := :id) initialisation
                        where   find_in_set(parent_id, @pv)
                            and     length(@pv := concat(@pv, ',', rubric_id)) "
                    , ['id' => $rubric_id])
                    ->queryAll();
        }        
        else{
//            return Rubric::find()->all();        
            $rubrics = (new \yii\db\Query())
                    ->select('rubric.*')
                    ->from('rubric')
                    ->where(['>','rubric.rubric_id', 1])
                    ->all();
        }
        return $rubrics;
    }
}

?>