<?php

namespace app\controllers;

use app\components\ShortUrlHelper;
use Yii;
use yii\web\Controller;

/**
 * 短链接生成demo
 */
class ShortUrlController extends Controller
{
    /**
     * 解析短链接
     */
    public function actionRedirect()
    {
        $code = Yii::$app->request->get('code');
        $model = ShortUrlHelper::find($code);
        if (!$model) {
            die('信息不存在');
        }
        ShortUrlHelper::redirect($model);
    }

    /**
     * 生成短链接，建议使用POST
     */
    public function actionMake()
    {
        $url = Yii::$app->request->get('url');
        $password = Yii::$app->request->get('password');
        $shortUrl = 'http://your-domain/' . ShortUrlHelper::save($url, $password);
        echo $shortUrl;
    }
}
