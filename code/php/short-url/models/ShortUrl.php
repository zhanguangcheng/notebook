<?php

namespace app\models;

/**
 * This is the model class for table "short_url".
 *
 * @property string $id
 * @property string $crc32
 * @property string $url
 * @property string $password
 * @property int $view_count
 */
class ShortUrl extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'short_url';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['crc32', 'url'], 'required'],
            [['crc32', 'view_count'], 'integer'],
            [['url'], 'string', 'max' => 500],
            [['password'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'crc32' => 'Crc32',
            'url' => 'Url',
            'password' => 'Password',
            'view_count' => 'View Count',
        ];
    }
}
