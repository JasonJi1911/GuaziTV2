<?php
namespace api\controllers;

use api\dao\CommonDao;
use api\dao\RecommendDao;
use api\dao\VideoDao;
use api\exceptions\ApiException;
use api\helpers\ErrorCode;
use api\helpers\Common;
use api\logic\ChannelLogic;
use api\logic\PayLogic;
use api\logic\VideoLogic;
use api\logic\AdvertLogic;
use api\models\video\Recommend;
use api\models\video\UserWatchLog;
use api\models\advert\AdvertPosition;
use common\helpers\RedisKey;
use common\helpers\RedisStore;
use common\models\video\VideoFeed;
use Yii;
use yii\helpers\ArrayHelper;

class VideoController extends BaseController
{
    /**
     * 频道栏
     * @return mixed
     */
    public function actionChannels()
    {
        // 筛选字段
        $fields = ['channel_id', 'channel_name'];

        $commonDao = new CommonDao();
        $data['list'] = $commonDao->videoChannel($fields);

        $videoLogic = new VideoLogic();
        $data['hot_word'] =  $videoLogic->searchWord();;

        // 添加热门分类
        array_unshift($data['list'], ['channel_id' => 0, 'channel_name' => '首页']);

        return $data;
    }

    /**
     * 首页&频道首页
     * @return array
     * @throws \api\exceptions\InvalidParamException
     */
    public function actionIndex()
    {
     
        $channelId = $this->getParamOrFail('channel_id');
        
        $city = $this->getParam('city');

        $data = [];

        // 获取banner数据
        $bannerFields = ['title','action', 'content', 'image','stitle'];
        $videoDao= new VideoDao();
   
        $banner = $videoDao->banner($channelId, $bannerFields,$city);
        $data['banner'] = $banner;
        // $channelId == 0 时返回首页数据
        
        $channelLogic = new ChannelLogic();
        if ($channelId == 0) {
            $channelData = $channelLogic->channelIndexData($city);
        } else {
            $channelData = $channelLogic->channelLabelData($channelId,$city);
        }

        $data = array_merge($data, $channelData);
        return $data;
    }
    

    /**
     * 首页&频道首页banner图
     * @return array
     * @throws \api\exceptions\InvalidParamException
     */
    public function actionBanner()
    {
      
        $channelId = $this->getParamOrFail('channel_id');
        
        $city = $this->getParam('city');

        $data = [];

        // 获取banner数据
        $bannerFields = ['title','action', 'content', 'image','stitle'];
        $videoDao= new VideoDao();
   
        $banner = $videoDao->banner($channelId, $bannerFields, $city);
        $data['banner'] = $banner;

        return $data;
    }
    
    /**
     * 广告
     * @return array
     * @throws \api\exceptions\InvalidParamException
     */
    public function actionAdvert()
    {
      
        $page = $this->getParam('page');
        $city = $this->getParam('city');
        
        // 获取广告
        $advertLogic = new AdvertLogic();
        //        $advert = $advertLogic->advertByPosition(AdvertPosition::POSITION_VIDEO_INDEX);
        $adposition = Yii::$app->common->product == Common::PRODUCT_PC
            ? AdvertPosition::POSITION_VIDEO_INDEX_PC : AdvertPosition::POSITION_VIDEO_INDEX;
        $flashPos = Yii::$app->common->product == Common::PRODUCT_PC
            ? AdvertPosition::POSITION_FLASH_PC : AdvertPosition::POSITION_FLASH_WAP;
            
        $playbeforePos = Yii::$app->common->product == Common::PRODUCT_PC
            ? AdvertPosition::POSITION_PLAY_BEFORE_PC : AdvertPosition::POSITION_PLAY_BEFORE;
        $videoTopPos = Yii::$app->common->product == Common::PRODUCT_PC
            ? AdvertPosition::POSITION_VIDEO_TOP_PC : AdvertPosition::POSITION_VIDEO_TOP_PC;
        $videoBottomPos = Yii::$app->common->product == Common::PRODUCT_PC
            ? AdvertPosition::POSITION_VIDEO_BOTTOM_PC : AdvertPosition::POSITION_VIDEO_BOTTOM_PC;
            
        $data = [];
        
        if ($page == "home") {
            $advert = $advertLogic->advertByPosition($adposition, $city);
            $data['advert'] = $advert;
            
            $flash = $advertLogic->advertByPosition($flashPos, $city);
            $data['flash'] = $flash;
        } else if($page == "detail"){
            $data['advert'] = [
                'playbefore' => (object)$advertLogic->advertByPosition($playbeforePos, $city),
                'playtop' => (object)$advertLogic->advertByPosition(AdvertPosition::POSITION_PLAY_STOP, $city),
                'playliketop' => (object)$advertLogic->advertByPosition(AdvertPosition::POSITION_LIKE_TOP, $city),
                'playlikebottom' => (object)$advertLogic->advertByPosition(AdvertPosition::POSITION_LIKE_BOTTOM, $city),
                'videotop' => (object)$advertLogic->advertByPosition($videoTopPos, $city),
                'videobottom' => (object)$advertLogic->advertByPosition($videoBottomPos, $city),
            ];
        }
        
        return $data;
    }


    /**
     * 视频筛选
     * @return array
     */
    public function actionFilter()
    {
        $channelId = $this->getParam('channel_id', ''); // 频道
        $sort      = $this->getParam('sort', 'hot'); // 排序
        $tag       = $this->getParam('tag', ''); // 标签
        $area      = $this->getParam('area', ''); // 地区
        $year      = $this->getParam('year', ''); // 年代
        $page      = $this->getParam('page_num', DEFAULT_PAGE_NUM); // 页面 当传入1时，返回检索项
        $pageSize  = $this->getParam('page_size', 10);
        $type      = $this->getParam('type', 0); // 类型 当传入1时，位点击分类进入，服务端要返回所有频道筛选项
        $playLimit = $this->getParam('play_limit', '');

        $area      = !empty($area) ? $area : '';
        $year      = !empty($year) ? $year : '';
        $tag       = !empty($tag) ? $tag : '';
        $playLimit = !empty($playLimit) ? $playLimit : '';
        $channelId = !empty($channelId) ? $channelId : '';

        // 筛选项
        $data = [];
        // 当请求为第一页时，返回筛选页头部信息
        if ($page == 1) {
            $videoLogic = new VideoLogic();
            $data = $videoLogic->filterHeader($channelId, $sort, $tag, $area, $year, $type, $playLimit);
        }
        // 根据条件取视频信息
        $videoDao = new VideoDao();
        $video = $videoDao->filterVideoList($channelId, $sort, $tag, $area, $year, $type, $playLimit, $page, $pageSize);

        $data = array_merge($data, $video);
        return $data;
    }

    /**
     * 离线缓存视频
     */
    public function actionDown()
    {
        $videoId   = $this->getParamOrFail('video_id');  //视频id
        $chapterId = $this->getParamOrFail('chapter_id');  //视频id

        if (!$chapterId) {
            throw new ApiException(ErrorCode::EC_PARAM_INVALID);
        }
        $chapterId = explode(',', $chapterId);
        $videoLogic = new VideoLogic();
        return $videoLogic->down($videoId, $chapterId);
    }

    /**
     * 换一换
     * @return array
     * @throws \api\exceptions\InvalidParamException
     */
    public function actionRefresh()
    {
        $recommendId = $this->getParamOrFail('recommend_id');

        $recommendDao = new RecommendDao();
        $recommendInfo = $recommendDao->getRecommend($recommendId);
        $search = json_decode($recommendInfo['search'], true);

        // 检索
        $where = ['and', ['channel_id' => $recommendInfo['channel_id']]];

        foreach ($search as $item) {
            if ($item['field'] == 'tag') {
                $where[] = ['like', 'category_ids', $item['value']];
            } else {
                $where[] = [$item['field'] => $item['value']];
            }
        }
        
        // 获取缓存的影视
        $videoDao = new VideoDao();
        $fields = ['video_id', 'video_name', 'score', 'tag', 'flag', 'play_times', 'cover', 'horizontal_cover', 'intro'];

        // return $videoDao->refreshVideo($where, $fields, Recommend::$selectLimit[$recommendInfo['style']]);
        return $videoDao->refreshVideo($where, $fields, 9);
    }

    /**
     * 视频详情
     * @return array
     * @throws ApiException
     * @throws \api\exceptions\InvalidParamException
     */
    public function actionInfo()
    {
        $videoId   = $this->getParamOrFail('video_id');
        $chapterId = $this->getParam('chapter_id');
        $sourceId  = $this->getParam('source_id');
        
        $city = $this->getParam('city');
        // 不传入id则设置为空
        $chapterId = $chapterId ? $chapterId : '';

        $videoLogic = new VideoLogic();
        // return $videoLogic->playInfo($videoId, $chapterId, $sourceId);
        return $videoLogic->playInfo($videoId, $chapterId, $sourceId, $city);
    }

    /**
     * 我的观影记录
     */
    public function actionUserWatchLog()
    {
        $uid = Yii::$app->user->id;
        if (empty($uid)) {
            return [];
        }
        /** @var UserWatchLog $logInfo */
        $logInfo = UserWatchLog::find()->where(['uid' => $uid])->orderBy('updated_at desc')->one();
        if (empty($logInfo)) {
            return [];
        }
        $arrLogInfo = $logInfo->toArray();
        // 获取影视信息
        $videoDao = new VideoDao();
        $videoInfo = $videoDao->videoInfo($logInfo['video_id'], ['video_id', 'video_name']);
        if (empty($videoInfo)) {
            return [];
        }
        // 获取影视剧集信息
        $videoChapter = $videoDao->videoChapter($logInfo['video_id'], ['chapter_id','title'], true);
        $chapterInfo  = $videoChapter[$logInfo['chapter_id']];
        if (empty($chapterInfo)) {
            return [];
        }

        // 合并数据
        $data = array_merge($arrLogInfo, $videoInfo, $chapterInfo);

        $data['title'] = $videoInfo['video_name'] . ' ' . $chapterInfo['title'] . ' ' . $logInfo['time'];

        return $data;
    }

    /**
     * 购买选项
     * @return array
     * @throws ApiException
     * @throws \api\exceptions\InvalidParamException
     */
    public function actionBuyOption()
    {
        $videoId = $this->getParamOrFail('video_id');
        $videoLogic = new VideoLogic();
        return $videoLogic->buyOption($videoId);
    }

    /**
     * 确认购买
     * @return bool
     * @throws ApiException
     * @throws \api\exceptions\InvalidParamException
     */
    public function actionBuyConfirm()
    {
        $videoId = $this->getParamOrFail('video_id');
        $uid = Yii::$app->user->id;
        // 上锁
        $lockKey = RedisKey::getApiLockKey('video/buy-confirm', ['uid' => $uid, 'video_id' => $videoId]);
        $redis = new RedisStore();
        if ($redis->checkLock($lockKey)) {
            throw new ApiException(ErrorCode::EC_SYSTEM_OPERATING);
        }

        $videoDao = new VideoDao();
        $videoInfo = $videoDao->videoInfo($videoId);
        if (empty($videoInfo)) {
            $redis->releaseLock($lockKey);
            throw new ApiException(ErrorCode::EC_VIDEO_NOT_EXIST);
        }

        $payLogic = new PayLogic();
        $res = $payLogic->consumeCoupon($uid, $videoInfo['total_price'], $videoId);
        // 释放锁
        $redis->releaseLock($lockKey);

        return $res;
    }

    /**
     * 章节目录
     * @return array
     * @throws ApiException
     * @throws \api\exceptions\InvalidParamException
     */
    public function actionChapter()
    {
        $videoId = $this->getParamOrFail('video_id');
        $videoDao = new VideoDao();

        $videoInfo = $videoDao->videoInfo($videoId);

        // 获取影片剧集信息
        $videos = $videoDao->videoChapter($videoId, []);
        if (!$videos) { // 没有剧集抛出异常
            throw new ApiException(ErrorCode::EC_VIDEO_CHAPTER_NOT_EXIST);
        }
        // 格式化章节信息
        foreach ($videos as $key => &$video) {
            $video['cover']         = $videoInfo['cover'];
            //$video['download_name'] = md5($videoInfo['video_name'] . ' ' . $video['title']) . '.' . substr(strrchr($video['resource_url'][$sourceId], '.'), 1);
            $video['mime_type']     = substr(strrchr(reset($video['resource_url']), '.'), 1);
            $video['last_chapter']  = isset($videos[$key-1]) ? $videos[$key-1]['chapter_id'] : 0;
            $video['next_chapter']  = isset($videos[$key+1]) ? $videos[$key+1]['chapter_id'] : 0;
            unset($video['resource_url']); // 安全考虑，删除剧集播放连接，防止全部播放连接一次性全返回
        }

        return $videos;
    }

    /**
     * vip 列表
     * @return array
     */
    public function actionVip()
    {
        $channelId = $this->getParam('channel_id');
        $channelId = $channelId ? $channelId : '';

        $videoLogic = new VideoLogic();
        return $videoLogic->vipList($channelId);
    }
    
    public function actionFeedBack()
    {
        $video_id = $this->getParam('video_id', "");
        $chapter_id = $this->getParam('chapter_id', "");
        $source_id = $this->getParam('source_id', "");
        $ip = $this->getParam('ip', "");
        $reason = $this->getParam('reason', "");

        $feed_back = new VideoFeed();
        $feed_back->video_id = $video_id;
        $feed_back->chapter_id = $chapter_id;
        $feed_back->source_id = $source_id;
        $feed_back->ip = $ip;
        $feed_back->reason = $reason;

        $info = $feed_back::find()->andWhere(['video_id'=>$video_id, 'chapter_id'=>$chapter_id
            , 'source_id'=>$source_id, 'ip'=>$ip, 'reason'=>$reason])->asArray()->all();

        $result = [];
        if (!$info)
        {
            $feed_back->save();
            $result['status'] = 0;
            $result['message'] = '报错成功';
        }
        else
        {
            $result['status'] = 1;
            $result['message'] = '您已经报错过该视频，请不要重复提交';
        }
        return $result;
    }
    //求片
    public function actionSeek(){
        $videoDao = new VideoDao();
        $data = $videoDao->findAreasAndChannels();
        return $data;
    }
    
    /*
     * 提交求片信息
     * $video_name 片名
     * $channel_id 频道id
     * $area_id 地区id
     * $year 年代
     * $director_name 导演名称
     * $actor_name 主演名称
     */
    public function actionSaveSeek(){
        $video_name    = $this->getParam('video_name',"");
        $channel_id    = $this->getParam('channel_id',0);
        $area_id       = $this->getParam('area_id',0);
        $year          = $this->getParam('year',"");
        $director_name = $this->getParam('director_name',"");
        $actor_name    = $this->getParam('actor_name',"");
        $videoDao = new VideoDao();
        $result = $videoDao->saveSeekInfo($video_name,$channel_id,$area_id,$year,$director_name,$actor_name);
        return $result;
    }
    /*
     * 获取国家信息
     */
    public function actionGetCountry(){
        $country_code = $this->getParam('country_code',"");
        $country_name = $this->getParam('country_name',"");
        $videoDao = new VideoDao();
        $data = $videoDao->findCountryInfo($country_code);
        if(!$data){
            if($country_name){
                $data['country_name'] = $country_name;
                $data['country_code'] = $country_code;
            }else{
                $data['country_name'] = "全球";
                $data['country_code'] = "GL";
            }
            $data['imgname'] = "GLgq.png";
        }
        return $data;
    }
    /*
     * 三字码查city
     */
    public function actionCityInfo(){
        $citycode = $this->getParam('citycode', "");
        $videodao = new VideoDao();
        $city = $videodao->findcity($citycode);
        return $city;
    }
}
