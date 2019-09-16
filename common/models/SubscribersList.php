<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "subscribers_list".
 *
 * @property string $user
 */
class SubscribersList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subscribers_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user'], 'required'],
            [['user'], 'string', 'max' => 15],
            [['user'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user' => Yii::t('app', 'User'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return SubscribersListQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SubscribersListQuery(get_called_class());
    }
}
