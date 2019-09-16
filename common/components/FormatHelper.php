<?php


namespace common\components;


class FormatHelper
{
    public static function  hashAll($attributes){
        $out='';
        foreach ($attributes as $key => $value){
            if ($key !='secret'){
                $out.=$value;
            }
        }
        $out = sha1($out);
        return $out;
    }
}