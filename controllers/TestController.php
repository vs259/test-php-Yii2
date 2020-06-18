<?php

namespace app\controllers;

use yii\web\Controller;

class TestController extends Controller
{

    /**
     * Displays test.
     *
     * @return string
     */
    public function actionTest()
    {
        return $this->render('test');
    }

}

?>