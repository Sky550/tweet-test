<?php


namespace common\components;


class ErrorHelper
{
    public static function  hashError(){
        return ['error'=>'access denied'];
    }
    public static function  paramError(){
        return ['error'=>'missing parameter'];
    }
    public static function  internalError(){
        return ['error'=>'internal error'];
    }
}