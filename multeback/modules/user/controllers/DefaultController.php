<?php

namespace multeback\modules\user\controllers;

use multebox\Controller;
use multebox\models\search\Paidads as PaidadsSearch;
use Yii;

class DefaultController extends Controller
{
    public function actionIndex()
    {


        return $this->render('index');
    }
}
