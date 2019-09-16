<?php
namespace api\controllers;

use common\components\ErrorHelper;
use common\components\FormatHelper;
use common\components\TwitterHelper;
use common\models\SubscribersList;
use phpDocumentor\Reflection\Types\This;
use common\models\SubscribersListQuery;
use yii\db\StaleObjectException;
use yii\rest\ActiveController;

class SiteController extends ActiveController
{
    public $modelClass = 'common\models\SubscribersList';
    private $error = '';
    private $data = '';
    const ID_LENGHT = 32;



    public function beforeAction($action)
    {
        $this->data = \Yii::$app->request->get();
        if (strlen($this->data['id'])!=self::ID_LENGHT){
            $this->error = ErrorHelper::paramError();
            \Yii::$app->response->content = $this->errorShow();
            \Yii::$app->response->statusCode = 403;
            return false;
        }
        $secret = FormatHelper::hashAll($this->data);
        if ($secret != $this->data['secret']){
            $this->error = ErrorHelper::hashError();
           \Yii::$app->response->content = $this->errorShow();
           \Yii::$app->response->statusCode = 403;
            return false;
        }
        return parent::beforeAction($action);
    }


    public function actionAdd(){
        if (strlen($this->data['user'])===0 || strlen($this->data['user'])>15){
            $this->error = ErrorHelper::paramError();
            return $this->errorShow();
        }
        $api = new TwitterHelper();
        if(!$api->checkUser($this->data['user'])){
            $this->error = ErrorHelper::paramError();
            return $this->errorShow();
        }
        $user = new SubscribersList();
        $user->user = $this->data['user'];
        $user->save();
        return null;
    }
    public function actionFeed(){
      $api = new TwitterHelper();
        $out = $api->giveFeed();

        return $this->asJson($out);
    }
    public function actionRemove(){
        if (strlen($this->data['user'])===0 || strlen($this->data['user'])>15){
            $this->error = ErrorHelper::paramError();
            return $this->errorShow();
        }

            $user = SubscribersList::findOne(['user'=>$this->data['user']]);
        try {
            $user->delete();
        } catch (\Exception $e) {
            $this->error = ErrorHelper::internalError();
            return $this->errorShow();
        } catch (\Throwable $e) {
            $this->error = ErrorHelper::internalError();
            return $this->errorShow();
        }

        return null;
    }
    private function errorShow(){
        return $this->asJson($this->error);
    }

}
