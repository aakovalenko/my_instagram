<?php
/**
 * Created by PhpStorm.
 * User: andrii
 * Date: 04.04.18
 * Time: 15:54
 */

namespace frontend\modules\user\controllers;


//use Faker\Factory;
use frontend\models\User;
use frontend\modules\user\models\forms\PictureForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;
use yii\web\Response;
use yii\web\UploadedFile;

class ProfileController extends Controller
{
    public function actionView($nickname)
    {
        $currentUser = Yii::$app->user->identity;

        $modelPicture = new PictureForm();

        return $this->render('view',[
            'user' => $this->findUser($nickname),
            'currentUser' => $currentUser,
            'modelPicture' => $modelPicture,
        ]);
    }

    /*
     * Handle profile image upload via ajax request
     */
    public function actionUploadPicture()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = new PictureForm();
        $model->picture = UploadedFile::getInstance($model,'picture');

        if ($model->validate()) {

            $user = Yii::$app->user->identity;
            $user->picture = Yii::$app->storage->saveUploadedFile($model->picture); // 15/21/4523524twtsgf5rwet.jpg


            if ($user->save(false, ['picture'])) {
                return [
                    'success' => true,
                    'pictureUri' => Yii::$app->storage->getFile($user->picture),
                ];
            }
        }

        return ['success' => false, 'errors' => $model->getErrors()];
    }

    /*
     * @param string $nickname
     * @return User
     * throws NotFoundHttpException
     */

    private function findUser($nickname)
    {
        if ($user = User::find()->where(['nickname'=>$nickname])->orWhere(['id' => $nickname])->one()){
            return $user;
        }
        throw new NotFoundHttpException();
    }

    public function actionSubscribe($id)
    {
        if (Yii::$app->user->isGuest)
        {
            return $this->redirect(['/user/default/login']);
        }

        /*
         * @var currentUser User
         */
        $currentUser = Yii::$app->user->identity;
      //  print_r($currentUser['id']);
//echo '<hr>';
        $user = $this->findUserById($id);
       // print_r($user['id']);die();

       $currentUser->followUser($user);


       return $this->redirect(['/user/profile/view', 'nickname' => $user->getNickname()]);
    }

/*
 * @param integer $nickname
 * @return User
 * @throws NotFoundHttpException
 */
    public function findUserById($id)
    {
        if ($user = User::findOne($id)){
            return $user;
        }
        throw new NotFoundHttpException();
    }


    public function actionUnsubscribe($id)
    {
        if (Yii::$app->user->isGuest)
        {
            return $this->redirect(['/user/default/login']);
        }

        /*
          * @var currentUser User
          */
        $currentUser = Yii::$app->user->identity;

        $user = $this->findUserById($id);

        $currentUser->unfollowUser($user);

        return $this->redirect(['/user/profile/view', 'nickname' => $user->getNickname()]);
    }


}