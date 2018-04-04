<?php
/**
 * Created by PhpStorm.
 * User: andrii
 * Date: 04.04.18
 * Time: 15:54
 */

namespace frontend\modules\user\controllers;


use frontend\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ProfileController extends Controller
{
    public function actionView($id)
    {
        return $this->render('view',[
            'user' => $this->findUser($id),
        ]);
    }

    private function findUser($id)
    {
        if ($user = User::find()->where(['id'=>$id])->one()){
            return $user;
        }
        throw new NotFoundHttpException();
    }
}