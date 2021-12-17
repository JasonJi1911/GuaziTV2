<?php
namespace pc\controllers;

use common\helpers\Tool;
use Yii;
use yii\web\Cookie;
use api\models\User;
use yii\helpers\Url;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class'  => 'yii\web\ErrorAction',
                'layout' => false,
            ],

            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'maxLength' => 4,
                'minLength' => 4,
            ],
        ];
    }

    /*
     * 增加广告点击量
     */
    public function actionAdvertClick()
    {
        $advertId = Yii::$app->request->get('advert_id');
        Yii::$app->api->get('/advert/click',['advert_id' => $advertId]);
        return Tool::responseJson(0, 'success');
    }

    public function actionClearCookies()
    {
        Yii::$app->response->cookies->remove('gid');
        Yii::$app->response->cookies->remove('lid');
        Yii::$app->response->cookies->remove('user_token');
    }
    
    public function actionShareDown()
    {
        $data = Yii::$app->api->get('/search/app-version');
        return $this->render('sharedown',[
            'data'          => $data,
        ]);
    }
    
    public function actionAllMap()
    {
        $xml =  [
            'class' => 'yii\web\Response',
            'format' => \yii\web\Response::FORMAT_XML, //设置输出的格式为 XML
            'formatters' => [
                \yii\web\Response::FORMAT_XML => [
                    'class' => 'yii\web\XmlResponseFormatter',
                    'rootTag' => 'sitemapindex', //根节点
                    'itemTag' => 'sitemap', //单元
                ],
            ],
            'data' => [ //要输出的数据

            ],
        ];
        $channels = Yii::$app->api->get('/video/channels');
        if (!empty($channels))
        {
            foreach ($channels['list'] as $channel)
            {
                if (empty($channel))
                    continue;

                if ($channel['channel_id'] == 0) {
                    continue;
                }
                $video = [];
                // $video['loc'] = PC_HOST_PATH.Url::to(['site/map', 'channel_id' =>  $channel['channel_id']]);
                $video['loc'] = PC_HOST_PATH.Url::to(['video/channel', 'channel_id' =>  $channel['channel_id']]);
                // $video['channel'] = $channel['channel_name'];
                array_push($xml['data'], $video);
            }
        }

        return \Yii::createObject($xml);
    }
    
    public function actionMap()
    {
        //获取影片系列、剧集、源信息
        $channel_id = Yii::$app->request->get('channel_id', '');
        $keyword = Yii::$app->request->get('keyword', '');
        $sort = Yii::$app->request->get('sort', 'hot');
        $tag = Yii::$app->request->get('tag', '');
        $area = Yii::$app->request->get('area', '');
        $year = Yii::$app->request->get('year', '');
        $play_limit = Yii::$app->request->get('play_limit', '');
        $page_num = Yii::$app->request->get('page_num', 100);
        $page_cycle = Yii::$app->request->get('page_cycle', 1);
        $page_start = (($page_cycle - 1) * $page_num) + 1;
        $page_end = $page_num * $page_cycle;

        //请求频道、搜索信息
        $channels = Yii::$app->api->get('/video/channels');

        $xml =  [
            'class' => 'yii\web\Response',
            'format' => \yii\web\Response::FORMAT_XML, //设置输出的格式为 XML
            'formatters' => [
                \yii\web\Response::FORMAT_XML => [
                    'class' => 'yii\web\XmlResponseFormatter',
                    'rootTag' => 'urlset', //根节点
                    'itemTag' => 'url', //单元
                ],
            ],
            'data' => [ //要输出的数据
            ],
        ];
        
        for ($i = $page_start; $i <= $page_end; $i++)
        {
            //请求影片筛选信息
            $data = Yii::$app->api->get('/video/filter', ['channel_id' => $channel_id, 'tag' => $tag, 'sort' => $sort, 'area' => $area,
                'play_limit' => $play_limit, 'year' => $year, 'page_num' => $i, 'page_size' =>24 ,'type' => 1]);
                
                
            if (!empty($data['list']))
            {
                foreach ($data['list'] as  $list)
                {
                    $video = [];
                    $video['loc'] = PC_HOST_PATH.Url::to(['video/detail', 'video_id' => $list['video_id']]);
                    // $video['score'] = $list['score'];
                    // $video['title'] = '瓜子TV|'.$list['video_name'];
                    // $video['year'] = $list['year'];
                    $video['priority'] = '0.8';
                    $video['lastmod'] = date('Y-m-d');
                    // $video['changefreq'] = 'weekly';
                    array_push($xml['data'], $video);
                }
            }
            unset($data);
        }

        return \Yii::createObject($xml);
    }
}
