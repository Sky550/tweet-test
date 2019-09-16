<?php


namespace common\components;

use common\models\SubscribersList;
use Yii;
use yii\authclient\clients\Twitter;
use yii\authclient\OAuthToken;
use yii\web\NotFoundHttpException;


class TwitterHelper
{
    private $token;
    private $twitter;
   public function __construct() {
       // Creating OAuthToken
       // all tokens from param-local.php
       $this->token = new OAuthToken([
           'token' => Yii::$app->params['twitterAccessToken'],
           'tokenSecret' => Yii::$app->params['twitterAccessTokenSecret']
       ]);

// Launch Twitter using $token
// recently created token
       $this->twitter = new Twitter([
           'accessToken' => $this->token,
           'consumerKey' => Yii::$app->params['twitterApiKey'],
           'consumerSecret' => Yii::$app->params['twitterApiSecret']
       ]);

   }
   public function checkUser($username){
       try{
           $this->twitter->api('users/lookup.json?screen_name='.$username, 'GET');
           return true;
       }
       catch (yii\authclient\InvalidResponseException $e){
           return false;
       }

   }
   public function giveFeed(){
       $users = '';
       foreach (SubscribersList::find()->all() as $user){
           $users.=$user['user'].',';
       }

       $resp = $this->twitter->api('users/lookup.json?screen_name='.$users, 'GET');
       $out = [];
       foreach ($resp as $key => $item){
           $out['feed'][$key]['name'] = $item['screen_name'];
           $out['feed'][$key]['tweet'] = $item['status']['text'];
           if($item['status']['entities']['hashtags']){
           foreach ($item['status']['entities']['hashtags'] as $tag){
               $out['feed'][$key]['hashtags'][] = $tag['text'];
           }
           }
       }
       return $out;
   }

}