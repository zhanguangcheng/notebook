<?php

namespace app\components;

use app\models\ShortUrl;
use Yii;
/**
 * 短网址Helper
 */
class ShortUrlHelper
{
    /**
     * 基础序列
     * @var string
     */
    private static $base = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    /**
     * 62组随机序列，可以使用makeBaseList生成
     * @var array
     */
    private static $baseList = [];
    
    /**
     * 保存网址
     * @param  string $url 原始网址
     * @param  string $password 网址访问密码
     * @return string 生成好的7位短码
     */
    public static function save($url, $password = null)
    {
        $crc32 = sprintf('%u', crc32($url));
        $model = ShortUrl::findOne(['crc32' => $crc32, 'url' => $url]);
        if (!$model) {
            $model = new ShortUrl();
            $model->crc32 = $crc32;
            $model->url = $url;
            $model->password = md5($password);
            $model->save();
        }
        $index = bcmod($crc32, 62);
        return self::$base[$index] . Base62::encode($model->id, self::$baseList[$index]);
    }
    
    /**
     * 使用短码查找网址信息
     * @param  string $code 7位短码
     * @return ShortUrl|null
     */
    public static function find($code)
    {
        $index = substr($code, 0, 1);
        $code = substr($code, 1);
        $id = Base62::decode($code, self::$baseList[strpos(self::$base, $index)]);
        if ($id) {
            return ShortUrl::findOne($id);
        }
    }
    
    /**
     * 执行跳转
     * @param  ShortUrl
     */
    public static function redirect($model)
    {
        $model->view_count++;
        $model->update();
        Yii::$app->response->redirect($model->url, 301);
    }
    
    /**
     * 生成62组随机序列
     * @return array 62组随机序列
     */
    public static function makeBaseList()
    {
        $result = [];
        for ($i=0; $i < 62; $i++) { 
            $result[] = str_shuffle(self::$base);
        }
        return $result;
    }
}
