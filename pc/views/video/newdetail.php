<?php
use yii\helpers\Url;
use pc\assets\StyleInAsset;
use common\models\advert\AdvertPosition;

// $this->metaTags['keywords'] = '瓜子,tv,瓜子tv,澳洲瓜子tv,澳洲,新西兰,澳新,电影,电视剧,榜单,综艺,动画,记录片';
$this->registerMetaTag(['name' => 'keywords', 'content' => '瓜子tv,澳洲瓜子tv,新西兰瓜子tv,澳新瓜子tv,瓜子视频,瓜子影视,电影,电视剧,榜单,综艺,动画,记录片']);
// $this->title = '瓜子TV-澳新华人在线视频分享网站';
$this->title = $data['info']['video_name'].'-瓜子TV - 澳新华人在线视频分享平台,海量高清视频在线观看';
StyleInAsset::register($this);

$js = <<<JS
$(function(){
    
    // var videoPath = $('#player1').data('src');
    // var videoImage = '';
    //
    // var dp = new DPlayer({
    //     element: document.getElementById('player1'),
    //     theme: '#FADFA3',
    //     loop: true,
    //     lang: 'zh-cn',
    //     hotkey: true,
    //     preload: 'auto',
    //     volume: 0.7,
    //     autoplay: true,
    //     playbackSpeed:[0.5, 0.75, 1, 1.25, 1.5, 2,2.5,3,5,7.5,10],
    //     video: {
    //         url: videoPath,
    //         pic: videoImage,
    //         type: 'hls'
    //     },
    // });
    
    $('.slider-for').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      fade: true,
      asNavFor: '.slider-nav'
    });
    $('.slider-nav').slick({
      slidesToShow: 5,
      slidesToScroll: 1,
      asNavFor: '.slider-for',
      dots: false,
      arrows:true,
      focusOnSelect: true
    });
    var swiper = new Swiper('.swiper-container', {
         slidesPerView: 5,
         spaceBetween: 15,
         navigation: {
           nextEl: '.swiper-button-next',
           prevEl: '.swiper-button-prev',
         },      
    });	
        
    $('.qy-player-basic-intro').click(function(event) {
			$('.qy-player-intro-pop').slideToggle();
			$(this).toggleClass('selected');
    });
    $('.comment-c-itemwrap').hover(function() {
        $(this).find('.comment-ft-btn__dn').show();
    },function(){
        $(this).find('.comment-ft-btn__dn').hide();
    });
    $('.anchor-list').each(function(index, el) {
        $(this).hover(function() {
            $(this).find('.popBox').show();
        }, function() {
            $(this).find('.popBox').hide();
        });
    });
    $(window).scroll(function(event) {
        var _top = $(window).scrollTop();
        if(_top > 300){
            $('.anchor-list').last().show();
        }else{
            $('.anchor-list').last().hide();
        }
        if(_top > 900){
            $('.qy-comment-page .qycp-form-fixed ').show()
        }else{
            $('.qy-comment-page .qycp-form-fixed ').hide()
        }
    });
    $('.backToTop').click(function() {
        $('html,body').stop(true, false).animate({
            scrollTop: 0
        })
    });
    $('.comment-form').hover(function() {
        $(this).toggleClass('form__focused');
    });
    $('.comment-btn-fixed').click(function(event) {
        $('.qycp-form-fixed').addClass('show');
    });
    
    //点击播放
    //播放源
    $('.video-play-btn-source').click(function() {
        //隐藏封面
        $('.video-play-left-cover').hide();
        if(document.getElementById('picBox'))
            $("#picBox").hide();
        //实例化video对象
        var myVideo = videojs('play-video', {
            bigPlayButton: true,
            textTrackDisplay: false,
            posterImage: false,
            errorDisplay: false,
            playbackRates: [0.5,1,1.5,2]
        });
        myVideo.play();
        //dp.play();
    });
    
    //播放iframe
    $('.video-play-btn-iframe').click(function() {
        //隐藏封面
        $('.video-play-left-cover').hide();
        if(document.getElementById('picBox'))
            $("#picBox").hide();
        //dp.play();
    });
    
    
    //显示播放源
    $(".video-source").hover(function(){
        $('.video-source-list').css('display', 'block');
    },function(){
        $('.video-source-list').css('display', 'none');
    });
        
    //用户点击，切换剧集
    $('.switch-next').click(function() {
        $('.switch-next-li').removeClass('on');
        $(this).addClass('on');
        var videoId = $(this).attr('data-video-id');
        var chapterId = $(this).attr('data-chapter-id');
        var sourceId = $('.sourceTab .hover a').attr('data-source-id');
        var type = $(this).attr('data-type');
        
        window.location.href = '/video/detail?video_id=' + videoId + '&chapter_id=' + chapterId+"&source_id="+sourceId;
        // window.location.href = '/video/detail?video_id=' + videoId + '&chapter_id=' + chapterId;
    });
        
    //切换视频源
    $('.next-source').click(function() {
        var videoId = $(this).attr('data-video-id');
        var chapterId = $(this).attr('data-video-chapter-id');
        var sourceId = $(this).attr('data-source-id');
         window.location.href = "/video/detail?video_id="+videoId+"&chapter_id="+chapterId+"&source_id="+sourceId;
    });
    
    // $("#my-iframe").load(function (){
    //     var interval = setInterval(showalert, 1000); 
    //     function showalert() 
    //     {
    //         var time = $("#my-iframe").contents().find(".yzmplayer-ptime").text();
    //         var dTime = $("#my-iframe").contents().find('.yzmplayer-dtime').text();

    //         if (time == "" || dTime == ""  
    //             || time == undefined || dTime == undefined 
    //             || dTime == "00:00" || dTime == "0:00" || dTime == "0:0")
    //             return ;
            
    //         var videoId = $('.switch-next.selected').attr('data-video-id');
    //         var chapterId = $('#next_chapter').val();
    //         if(chapterId == 0)
    //         {
    //             clearInterval(interval);
    //             return;
    //         }
            
    //         var sourceId = $('.on .next-source').attr('data-source-id');
    //         var intStime = parseInt(time.split(':')[0] * 60) + parseInt(time.split(':')[1]);
    //         var intDtime = parseInt(dTime.split(':')[0] * 60) + parseInt(dTime.split(':')[1]);
    //         if(dTime.split(':').length == 3)
    //         {
    //           intStime = parseInt(time.split(':')[0] * 3600) + parseInt(time.split(':')[1] * 60) + parseInt(time.split(':')[2]); 
    //           intDtime = parseInt(dTime.split(':')[0] * 3600) + parseInt(dTime.split(':')[1] * 60) + parseInt(dTime.split(':')[2]); 
    //         }

    //          if ((intStime+10) >= intDtime)
    //          {
    //              window.location.href = "/video/detail?video_id="+videoId+"&chapter_id="+chapterId+"&source_id="+sourceId;
    //              clearInterval(interval);
    //          }
    //     }
    // });
    
    $('.func-swicthCap').click(function(){
        var videoId = $(this).attr('data-video-id');
        var chapterId = $(this).attr('data-chapter-id');
        // var sourceId = $('.sourceTab .hover a').attr('data-source-id');
        var sourceId = $(this).attr('data-source-id');;
        
        window.location.href = '/video/detail?video_id=' + videoId + '&chapter_id=' + chapterId+"&source_id="+sourceId;
    });
    
});
JS;

$this->registerJs($js);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta content="telephone=no" name="format-detection" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
    <style>
        .video-play-left-cover {
            width: 100%;
            height: 100%;
            /*position: absolute;*/
            top: 0;
            left: 0;
            z-index: 99;
        }

        .video-play-left img {
            width: 100%;
            height: 100%;
        }

        .on .tag-item{
            color: rgb(255, 85, 110);
        }

        .box{
            height: 100%;
        }

        .video-play-btn-iframe {
            width:100%;
            height:100%;
        }

        .qy-mod-link div img
        {
            opacity: 1.0;
        }

        .qy-mod-link:hover div img
        {
            opacity: 0.8;
        }

        .rank-enter-link:hover
        {
            color: #ff4d8d;
        }

        .dn{
            display: block;
        }

        .nn{
            display: none;
        }

        .qy-player-basic-intro.selected .qy-svgicon-intro
        ,.qy-player-basic-intro.selected .basic-txt
        {
            color: rgb(255, 85, 110);
        }
        
        .c-videoplay {
            z-index: 930;
            position: absolute;
            top: 50%;
            left: 50%;
            -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            -o-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }
        
        .c-player-icon {
            width: 4.0rem;
            height: 4.0rem;
            font-size: 1rem;
            background-position: 0 0;
            background-image: url(/images/video/player-bg.png);
            background-size: 8rem 12rem;
            display: inline-block;
            background-repeat: no-repeat;
            cursor: pointer;
        }
        
        .btn-add-play{
            z-index: 1000;
            display: block;
            bottom: 60px;
            right: 10px;
            
            width: 80px;
            line-height: 2.5;
            /* background-color: rgb(51, 51, 51); */
            position: absolute;
            font-size: 12px;
            border-radius: 15px;
            text-align: center;
            color: #fff;
            background: rgb(51, 51, 51);
            opacity: 0.8;
        }
        
        .btn-add-detail{
            z-index: 1000;
            display: block;
            top: 40px;
            right: 10px;
            width: 160px;
            line-height: 2.5;
            position: absolute;
            font-size: 12px;
            border-radius: 15px;
            text-align: center;
            color: #fff;
            background: rgb(51, 51, 51);
            opacity: 0.8;
        }
        
        .ad-arrow {
            display: inline-block;
            width: 6px;
            height: 6px;
            /*background: transparent;*/
            border-top: 1px solid #fff;
            border-right: 1px solid #fff;
            -webkit-transform: rotate(
                45deg
            );
            transform: rotate(
                45deg
            );
            margin: 0 2px;
            vertical-align: 1px;
        }
        
        .add-box a:hover{
            color: #FF556E;
        }
        
        .wechat-block{
            width: 100%;
            height: 100%;
            position: absolute;
            /* top: 0; */
            /* left: 0; */
            z-index: 10000;
        }
        
        .qy-svgicon-rightarrow_cu::before {
            content: "\EAC2"
        }

        .qy-svgicon-rightarrow_xi::before {
            content: "\EAC3"
        }

        .qy-svgicon-leftarrow_cu::before {
            content: "\EAC4"
        }

        .qy-svgicon-leftarrow_xi::before {
            content: "\EAC5"
        }

        .pointer-none{
            cursor: not-allowed;
            opacity: 0.3;
        }
        .pointer-none .func-inner{
            cursor: not-allowed;
            pointer-events: none;
        }
        
        .classBody{
            overflow-y: scroll; !important;
        }
    </style>
</head>
<body style="background-color:#fff;" class="qy-aura3 qy-advunder-show classBody">
<script src="/js/jquery.js"></script>
<script src="/js/VideoSearch.js"></script>
<div class="c"></div>
<div class="qy-play-top">
    <div class="play-top-flash">
        <div class="qy-play-container">
            <!--<a href="https://bit.ly/2ZeD8lq" target="_blank" class="">-->
            <!--    <img src="/images/NewVideo/yeeyi-banner.png" style="width:100%;">-->
            <!--</a>-->
            <?php if(!empty($data['advert'])) :?>
                <?php foreach ($data['advert'] as $key => $advert): ?>
                    <?php if(!empty($advert) && intval($advert['position_id']) == intval(AdvertPosition::POSITION_VIDEO_TOP_PC)) :?>
                    <a href="<?=$advert['ad_skip_url']?>" target="_blank" class="video-top-ad">
                        <img src="<?=$advert['ad_image']?>" style="width:100%;border-radius:5px;">
                    </a>
                    <?php endif;?>
                <?php endforeach;?>
            <?php endif;?>
            <div class="qy-player-wrap">
                <div class="player-mn">
                    <div class="player-mnc">
                        <div class="qy-flash-box">
                            <div class="flash-box">
                                <div class="iqp-player">
                                    <input type="hidden" id="next_chapter" value="<?= $data['info']['next_chapter'] ?>">
                                    <input type="hidden" id="last_chapter" value="<?= $data['info']['last_chapter'] ?>">
                                    <div class="wechat-block" id='wechat-block'>
                                        <img src="" class="video-play-btn-iframe wechat-url" onerror="this.src='/images/video/load.gif'">
                                        <div class="wechat_tip" style="
                                                position: absolute;
                                                left: 62%;
                                                top: 43%;
                                                font-size: 55px;
                                                font-weight: 1000;
                                                color: #FF556E;">

                                        </div>
                                    </div>
                                    <?php if($data['info']['resource_type'] == 1) :?>
                                        <div class="video-play-left-cover">
                                            <img src="<?= $data['info']['horizontal_cover'] ?>" alt=""
                                                 onerror="this.src='/images/video/default-cover-ver.png'"
                                                 id="video-cover" class="video-play-btn-source">
                                        </div>
                                        <video id="play-video" class="video-js vjs-big-play-centered" controls data-setup="{}">
                                            <?php if(substr($data['info']['resource_url'], strrpos($data['info']['resource_url'], ".") + 1) == 'm3u8') : ?>
                                                <source id="source" src="<?= $data['info']['resource_url']?>" type="application/x-mpegURL">
                                            <?php else:?>
                                                <source id="source" src="<?= $data['info']['resource_url']?>" >
                                            <?php endif;?>
                                        </video>
                                    <?php else:?>
                                        <input type="hidden" id="play_resource" value="<?= $data['info']['resource_url']?>" />
                                        <!--<iframe name="my-iframe" id="my-iframe" src=""-->
                                        <!--        allowfullscreen="true" allowtransparency="true"-->
                                        <!--        frameborder="0" scrolling="no" width="100%"-->
                                        <!--        height="100%" scrolling="no"></iframe>-->
                                        <?php foreach ($data['advert'] as $key => $advert) : ?>
                                            <?php if(!empty($advert) && $advert['position_id'] == AdvertPosition::POSITION_PLAY_BEFORE_PC) :?>
                                                <?php if(strpos($advert['ad_image'], '.mp4') !== false) {
                                                    $ad_type = 'mp4';
                                                    $ad_url = $advert['ad_image'];
                                                    $ad_link = $advert['ad_skip_url'];
                                                }else{
                                                    $ad_type = 'img';
                                                    $ad_url = $advert['ad_image'];
                                                    $ad_link = $advert['ad_skip_url'];
                                                }?>
                                            <?php endif;?>
                                        <?php endforeach;?>
                                        <?php echo $this->render('/360apitv/jiexi/jianghu',[
                                            'url'   =>      explode('v=',$data['info']['resource_url'])[1],
                                            // 'url'   =>      $data['info']['resource_url'],
                                            'ad_url' =>    $ad_url,
                                            'ad_link'  =>   $ad_link,
                                            'ad_type'  =>   $ad_type
                                        ]);?>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                        <div class="c"></div>
                        <div class="player-mnb">
                            <div class="player-mnb-left">
                                <div class="qy-flash-func qy-flash-func-v1">
                                    <!--<div class="func-item func-comment">-->
                                    <!--    <div class="func-inner">-->
                                    <!--        <i class="qy-svgicon qy-svgicon-comment-v1"><i class="bubble b1"></i><i class="bubble b2"></i><i class="bubble b3"></i></i>-->
                                    <!--        <span class="func-name">9844</span>-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                    <div class="func-item func-like-v1">
                                        <div class="func-inner">
                                            <span class="like-icon-box"><i title="" class="qy-svgicon qy-svgicon-dianzan"></i><i title="" class="like-heart-steps"></i></span>
                                            <span class="func-name"><?= $data['info']['total_views']?></span>
                                        </div>
                                    </div>
                                    <div class="func-item func-like-v1">
                                        <div class="func-inner">
                                            <span class="like-icon-box">
                                                <i title="" class="qy-svgicon qy-svgicon-report"></i>
                                            </span>
                                            <span class="func-name" id='err_feedback'>片源报错</span>
                                        </div>
                                    </div>
                                    <div class="func-item func-like-v1">
                                        <div class="func-inner">
                                            <span class="func-name" id='seek'>求片</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--<div class="player-mnb-mid">-->
                            <!--    <?php foreach ($data['info']['source'] as $key => $source): ?>-->
                            <!--        <div class="qy-func-collect-v1" style="margin-left: 20px; cursor: pointer">-->
                            <!--            <div class="<?= (empty($source_id) && $key == 0) ? 'on' : ''?> <?= $source['source_id'] == $source_id ? 'on' : ''?> collect">-->
                            <!--                    <span class="tag-item">-->
                            <!--                        <span class="next-source txt"-->
                            <!--                              data-video-id="<?= $data['info']['video_id']?>"-->
                            <!--                              data-video-chapter-id="<?= $data['info']['play_chapter_id']?>"-->
                            <!--                              data-source-id="<?= $source['source_id']?>">-->
                            <!--                            <?= $source['name']?>-->
                            <!--                        </span>-->
                            <!--                    </span>-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--    <?php endforeach;?>-->
                            <!--</div>-->
                            <div class="player-mnb-mid">
                                <!--<?= json_encode($data['info']['test'], JSON_UNESCAPED_UNICODE) ?>-->
                            </div>
                            <div class="player-mnb-right">
                                <div class="qy-flash-func qy-flash-func-v1">
                                    <div class="func-item <?= $data['info']['last_chapter'] == 0 ? 'pointer-none': ''?>">
                                        <div title="上一集" class="func-inner func-swicthCap"
                                             data-video-id="<?= $data['info']['video_id']?>"
                                             data-chapter-id="<?= $data['info']['last_chapter']?>"
                                             data-source-id="<?= $source_id?>">
                                            <span class="qy-svgicon qy-svgicon-leftarrow_cu"></span>
                                            <span class="func-name">上一集</span>
                                        </div>
                                    </div>
                                    <div class="func-item <?= $data['info']['next_chapter'] == 0 ? 'pointer-none': ''?>">
                                        <div title="下一集" class="func-inner func-swicthCap"
                                             data-video-id="<?= $data['info']['video_id']?>"
                                             data-chapter-id="<?= $data['info']['next_chapter']?>"
                                             data-source-id="<?= $source_id?>">
                                            <span class="func-name">下一集</span>
                                            <span class="qy-svgicon qy-svgicon-rightarrow_cu"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="player-sd">
                    <div class="player-sdc">
                        <div class="qy-player-side-loading" style="display: none;">
                            <img src="/images/NewVideo/con-loading-black.gif" alt="正在加载" class="loading-img">
                            <p class="loading-txt">正在加载…</p>
                        </div>
                        <div class="qy-player-side qy-episode-side">
                            <div class="qy-player-side-head">
                                <div class="head-title">
                                    <h2 class="header-txt">
                                        <a href="" class="header-link">
                                            <?= $data['info']['video_name']?>
                                        </a>
                                    </h2>
                                </div>
                            </div>
                            <div class="qy-player-side-body v_scroll_plist_bc qy-advunder-show" style="height: 100%;">
                                <div class="body-inner">
                                    <?php if($data['channel_id'] == '2'){?>
                                        <div class="side-content v_scroll_plist_content" style="transform: translateY(0px);">
                                            <div class="padding-box">
                                                <div class="qy-episode-update">
                                                    <p class="update-tip">
                                                        更新至<?= count($data['info']['videos'])?>集
                                                    </p>
                                                </div>
                                                <div class="qy-episode-tab">
                                                    <ul class="tab-bar TAB_CLICK sourceTab" id=".srctabShow">
                                                        <?php foreach ($data['info']['filter'] as $key => $source): ?>
                                                            <li class="bar-li <?= (empty($source_id) && $key == 0) || ($source['resId'] == $source_id) ? 'hover' : ''?>" id='srcTab-<?=$source['resId']?>'>
                                                                <a href="javascript:void(0);"
                                                                   class="bar-link"
                                                                   data-source-id="<?= $source['resId']?>">
                                                                    <?= $source['resName']."(".count($source['data'])."集)" ?>
                                                                </a>
                                                            </li>
                                                        <?php endforeach;?>
                                                    </ul>
                                                </div>
                                                <div class="c"></div>
                                                <?php foreach ($data['info']['filter'] as $key => $source): ?>
                                                    <div class="srctabShow <?= (empty($source_id) && $key == 0) || ($source['resId'] == $source_id) ? 'dn' : 'nn'?>" id='srctab-<?=$source['resId']?>'>
                                                        <?php
                                                        $page = ceil(count($source['data'])/30);
                                                        $count = count($source['data']);
                                                        $ontab = 1;
                                                        foreach ($source['data'] as $index => $value){
                                                            if ($data['info']['play_chapter_id'] != $value['chapter_id'])
                                                                continue;

                                                            $ontab = ceil(($index+1) / 30);
                                                            break;
                                                        }
                                                        ?>
                                                        <div class="qy-episode-tab">
                                                            <ul class="tab-bar TAB_CLICK" id=".tabShow<?=$key?>">
                                                                <?php for($k=0; $k<$page; $k++){?>
                                                                    <li class="bar-li <?= $k+1 == $ontab? 'hover': ''?>">
                                                                        <a href="javascript:void(0);" class="bar-link">
                                                                            <?= $k*30 + 1?>-<?= ($k == ($page -1))? $count:$k*30 + 30?></a>
                                                                    </li>
                                                                <?php }?>
                                                            </ul>
                                                        </div>
                                                        <div class="c"></div>
                                                        <?php for($i=0; $i<$page; $i++){?>
                                                            <ul class="qy-episode-num tabShow<?=$key?> <?= (($i+1) == $ontab)? 'dn': 'nn'?>">
                                                                <?php foreach ($source['data'] as $index => $value) : ?>
                                                                    <?php if($index>=$i*30 && $index < ($i*30+30)){?>
                                                                        <li class="select-item switch-next-li switch-next <?= $data['info']['play_chapter_id'] == $value['chapter_id'] 
                                                                            && ((empty($source_id) && $key == 0) || ($source['resId'] == $source_id))? 'selected' : ''?>"
                                                                            data-video-id="<?= $value['video_id']?>"
                                                                            data-chapter-id="<?= $value['chapter_id']?>"
                                                                            data-type="<?= $data['info']['catalog_style']?>"
                                                                            id='chap-<?=$source['resId']?>-<?=$value['chapter_id']?>'>
                                                                            <div class="select-link">
                                                                                <?= $value['title']?>
                                                                            </div>
                                                                        </li>
                                                                    <?php }?>
                                                                <?php endforeach;?>
                                                            </ul>
                                                        <?php }?>
                                                    </div>
                                                <?php endforeach;?>
                                                <div class="c"></div>
                                            </div>
                                        </div>
                                    <?php } elseif($data['channel_id'] == '1'){?>
                                        <div class="qy-episode-tab">
                                            <ul class="tab-bar TAB_CLICK sourceTab" id=".tabShow">
                                                <?php foreach ($data['info']['filter'] as $key => $source): ?>
                                                    <li class="bar-li <?= (empty($source_id) && $key == 0) || ($source['resId'] == $source_id) ? 'hover' : ''?>" id='srcTab-<?=$source['resId']?>'>
                                                        <a href="javascript:void(0);"
                                                           class="bar-link"
                                                           data-source-id="<?= $source['resId']?>">
                                                            <?= $source['resName'] ?>
                                                        </a>
                                                    </li>
                                                <?php endforeach;?>
                                            </ul>
                                        </div>
                                        <div class="h20"></div>
                                        <div class="side-content v_scroll_plist_content" style="transform: translateY(0px);">
                                            <?php foreach ($data['info']['filter'] as $key => $source): ?>
                                                <ul class="qy-play-list tabShow
                                                <?= (empty($source_id) && $key == 0) || ($source['resId'] == $source_id) ? 'dn' : 'nn'?>"
                                                    style="margin-bottom: 100px;" id='srctab-<?=$source['resId']?>'>
                                                    <?php foreach ($source['data'] as $value) : ?>
                                                        <li class="play-list-item switch-next-li switch-next <?= $data['info']['play_chapter_id'] == $value['chapter_id'] 
                                                            && ((empty($source_id) && $key == 0) || ($source['resId'] == $source_id))? 'selected' : ''?>"
                                                            data-video-id="<?= $value['video_id']?>"
                                                            data-chapter-id="<?= $value['chapter_id']?>"
                                                            data-type="<?= $data['info']['catalog_style']?>"
                                                            id='chap-<?=$source['resId']?>-<?=$value['chapter_id']?>'>
                                                            <div class="mod-left">
                                                                <div class="mod-img-link">
                                                                    <img src="<?= $value['cover']?>" class="mod-img">
                                                                    <i class="img-border"></i>
                                                                </div>
                                                            </div>
                                                            <div class="mod-right">
                                                                <h3 class="main-title">
                                                                    <span class="title-link"><?= $value['title']?></span>
                                                                </h3>
                                                                <div class="sub-title" style="">
                                                                    <i class="qy-svgicon qy-svgicon-hot"></i>
                                                                    <span class="count"><?= $data['info']['total_views']?></span>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    <?php endforeach;?>
                                                </ul>
                                            <?php endforeach;?>
                                        </div>
                                    <?php } elseif($data['channel_id'] == '3'){?>
                                        <div class="side-content v_scroll_plist_content" style="transform: translateY(0px);">
                                            <div class="qy-episode-update">
                                                <p class="update-tip">
                                                    更新至<?= $data['info']['videos'][count($data['info']['videos'])-1]['title']?>
                                                </p>
                                            </div>
                                            <div class="qy-episode-tab">
                                                <ul class="tab-bar TAB_CLICK sourceTab" id=".tabShow">
                                                    <?php foreach ($data['info']['filter'] as $key => $source): ?>
                                                        <li class="bar-li <?= (empty($source_id) && $key == 0) || ($source['resId'] == $source_id) ? 'hover' : ''?>" id='srcTab-<?=$source['resId']?>'>
                                                            <a href="javascript:void(0);"
                                                               class="bar-link"
                                                               data-source-id="<?= $source['resId']?>">
                                                                <?= $source['resName'] ?>
                                                            </a>
                                                        </li>
                                                    <?php endforeach;?>
                                                </ul>
                                            </div>
                                            <div class="h20"></div>
                                            <div class="qy-player-side-body v_scroll_plist_bc" style="height: 100%;">
                                                <div class="body-inner">
                                                    <div class="side-content v_scroll_plist_content">
                                                        <div class="">
                                                            <div class="qy-player-side-list qy-advunder-show">
                                                                <?php foreach ($data['info']['filter'] as $key => $source): ?>
                                                                    <ul class="qy-play-list tabShow
                                                                    <?= (empty($source_id) && $key == 0) || ($source['resId'] == $source_id) ? 'dn' : 'nn'?>"
                                                                        style="margin-bottom: 100px;" id='srctab-<?=$source['resId']?>'>
                                                                        <?php foreach ($source['data'] as $value) : ?>
                                                                            <li class="play-list-item switch-next-li switch-next <?= $data['info']['play_chapter_id'] == $value['chapter_id'] 
                                                                                && ((empty($source_id) && $key == 0) || ($source['resId'] == $source_id))? 'selected' : ''?>"
                                                                                data-video-id="<?= $value['video_id']?>"
                                                                                data-chapter-id="<?= $value['chapter_id']?>"
                                                                                data-type="<?= $data['info']['catalog_style']?>"
                                                                                id='chap-<?=$source['resId']?>-<?=$value['chapter_id']?>'>
                                                                                <div class="mod-left">
                                                                                    <div class="mod-img-link">
                                                                                        <img src="<?= $value['cover']?>" class="mod-img">
                                                                                        <!--                                                                                        <div class="icon-tr"><img src="images/s-new-12.png"></div>-->
                                                                                        <div class="icon-b">
                                                                                            <i class="playing-icon" style="display: none;"></i>
                                                                                            <span class="qy-mod-label"><?= $value['title']?></span>
                                                                                        </div>
                                                                                        <i class="img-border"></i>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="mod-right">
                                                                                    <h3 class="main-title">
                                                                                        <span href="" class="title-link"><?= $value['title']?></span>
                                                                                    </h3>
                                                                                    <div class="sub-title" style="">
                                                                                        <i class="qy-svgicon qy-svgicon-hot"></i>
                                                                                        <span class="count"><?= $data['info']['total_views']?></span>
                                                                                    </div>
                                                                                </div>
                                                                            </li>
                                                                        <?php endforeach;?>
                                                                    </ul>
                                                                <?php endforeach;?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } elseif($data['channel_id'] >= '4'){?>
                                        <div class="side-content v_scroll_plist_content" style="transform: translateY(0px);">
                                            <div class="qy-episode-update">
                                                <p class="update-tip">
                                                    更新至第<?= count($data['info']['videos'])?>集
                                                </p>
                                            </div>
                                            <div class="qy-episode-tab">
                                                <ul class="tab-bar TAB_CLICK sourceTab" id=".tabShow">
                                                    <?php foreach ($data['info']['filter'] as $key => $source): ?>
                                                        <li class="bar-li <?= (empty($source_id) && $key == 0) || ($source['resId'] == $source_id) ? 'hover' : ''?>" id='srcTab-<?=$source['resId']?>'>
                                                            <a href="javascript:void(0);"
                                                               class="bar-link"
                                                               data-source-id="<?= $source['resId']?>">
                                                                <?= $source['resName'] ?>
                                                            </a>
                                                        </li>
                                                    <?php endforeach;?>
                                                </ul>
                                            </div>
                                            <div class="c"></div>
                                            <?php foreach ($data['info']['filter'] as $key => $source): ?>
                                                <ul class="qy-episode-txt tabShow
                                                <?= (empty($source_id) && $key == 0) || ($source['resId'] == $source_id) ? 'dn' : 'nn'?>"
                                                    style="margin-bottom: 100px;" id='srctab-<?=$source['resId']?>'>
                                                    <?php foreach ($source['data'] as $key1 =>$value) : ?>
                                                        <li class="select-item switch-next-li switch-next <?= $data['info']['play_chapter_id'] == $value['chapter_id'] 
                                                            && ((empty($source_id) && $key == 0) || ($source['resId'] == $source_id))? 'selected' : ''?>"
                                                            data-video-id="<?= $value['video_id']?>"
                                                            data-chapter-id="<?= $value['chapter_id']?>"
                                                            data-type="<?= $data['info']['catalog_style']?>"
                                                            id='chap-<?=$source['resId']?>-<?=$value['chapter_id']?>'>
                                                            <div class="select-inline">
                                                                <div class="select-title">
                                                                    <span class="select-pre"><?= $key1+1?></span>
                                                                    <div href="" class="select-link"><?= $value['title']?></div>
                                                                </div>
                                                            </div>
                                                            <i class="playon-icon"></i>
                                                        </li>
                                                    <?php endforeach;?>
                                                </ul>
                                            <?php endforeach;?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="side-scrollbar">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="qy-player-side-ear"></div>
            </div>
            <div class="qy-player-info-area">
                <div class="qy-player-detail">
                    <div class="qy-player-detail-con">
                        <div class="detail-mn">
                            <div class="detail-mnc">
                                <div class="detail-left">
                                    <div class="qy-player-title ">
                                        <h1 class="player-title">
                                            <em class="title-txt"><?= $data['info']['video_name']?></em>
                                        </h1>
                                    </div>
                                    <div id="titleRow" class="qy-player-intro">
                                        <div class="intro-mn">
                                            <div class="intro-mnc">
                                                <div class="qy-player-basic-intro">
                                                    <div class="basic-item qy-player-brief">
                                                        <i class="qy-svgicon qy-svgicon-intro"></i>
                                                        <span class="basic-txt">简介</span>
                                                        <span class="qy-play-icon arrow966-icon"></span>
                                                    </div>
                                                </div>
                                                <div class="qy-player-tag" style="">
                                                    <?php foreach (explode('|',$data['info']['category']) as $cate) : ?>
                                                        <span href="" class="tag-item"><?= $cate?></span>
                                                    <?php endforeach;?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="c"></div>
                <div class="qy-player-detail-pop">
                    <div class="qy-player-intro-pop">
                        <div class="intro-left">
                            <div class="intro-ip">
                                <div href="" class="intro-img-link">
                                    <img src="<?= $data['info']['cover']?>"alt="" class="intro-img">
                                </div>
                                <div class="title-wrap">
                                    <p class="main">
                                        <spa class="link-txt">
                                            <?= $data['info']['video_name']?>
                                        </spa>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="intro-right">
                            <ul class="intro-detail">
                                <li class="intro-detail-item">
                                    <em class="item-title">导演：</em>
                                    <span class="item-content">
                                            <?php foreach (explode('|',$data['info']['director']) as $dic) : ?>
                                                <span class="name-wrap">
                                                    <span href="" class="name-link"><?= $dic?></span>
                                                </span>
                                            <?php endforeach;?>
                                        </span>
                                </li>
                                <li class="intro-detail-item">
                                    <em class="item-title">演员：</em>
                                    <span class="item-content">
                                            <?php foreach ($data['info']['actors'] as $key => $act) : ?>
                                                <span class="name-wrap">
                                                    <span class="name-link"><?= $act['actor_name']?></span>
                                                </span>
                                            <?php endforeach;?>
                                        </span>
                                </li>
                                <li class="intro-detail-item">
                                    <em class="item-title">本集简介:</em>
                                    <span class="item-content">
                                            <span class="content-paragraph">
                                                <?= $data['info']['intro']?>
                                            </span>
                                        </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="c"></div>
            </div>
            <style>
                iframe{
                    display: inline-block !important;
                }
            </style>
            <?php if(!empty($data['advert'])) :?>
                <?php foreach ($data['advert'] as $key => $advert) : ?>
                    <?php if(!empty($advert) && $advert['position_id'] == AdvertPosition::POSITION_VIDEO_BOTTOM_PC) :?>
                        <a href="<?=$advert['ad_skip_url']?>" target="_blank" class="video-bottom-add">
                            <img src="<?=$advert['ad_image']?>" style="width:100%;">
                        </a>
                    <?php endif;?>
                <?php endforeach;?>
            <?php endif;?>
        </div>
    </div>
</div>
<!--a href="http://guazitv.tv/video/spring-festival" target="_blank" class="">
<img src="http://img.guazitv8.com/audio/advert/22c68f3da80ecfb1836e662bfd1b2e91.jpg" style="width:100%;border-radius:5px;">
</a-->
<div class="c"></div>
<div class="qy-play-container">
    <div class="qy-play-con">
        <div class="play-con-mn">
            <div class="play-con-mnc">
                <div class="qy-mod-wrap qy-aura3">
                    <div class="qy-play-role-tab j_people_wrap">
                        <div class="slider slider-nav role-tab">
                            <?php foreach ($data['info']['actors'] as $key => $act) : ?>
                                <div class="role-item j_people_item j_slide_item">
                                    <div class="role-wrap">
                                        <div class="role-img-wrap">
                                            <img src="<?= $act['avatar'] ?>"
                                                 alt="<?= $act['actor_name'] ?>" class="role-img">
                                        </div>
                                        <div class="role-con ranking-name">
                                            <h3 class="actor-name">
                                                <a href="javasctipt:return false;"
                                                   title="<?= $act['actor_name'] ?>"
                                                   class="role-name-link"><?= $act['actor_name'] ?></a>
                                                <!--                                                    <a href="javasctipt:return false;" class="ranking-num">NO.537</a>-->
                                            </h3>
                                            <!--                                                <p class="role-name">饰 渤王</p>-->
                                        </div>
                                        <i class="line"></i>
                                    </div>
                                </div>
                            <?php endforeach;?>
                        </div>
                        <div class="slider slider-for">
                            <?php foreach ($data['info']['actorvideos'] as $key => $actvideos) : ?>
                                <div class="qy-mod-list-scroll">
                                    <div class="swiper-container">
                                        <div class="swiper-wrapper qy-mod-ul">
                                            <?php foreach ($actvideos as $i => $vi) : ?>
                                                <div class="swiper-slide qy-mod-li qy-mod-li j_slide_item">
                                                    <div class="qy-mod-img horizon">
                                                        <div class="qy-mod-link-wrap">
                                                            <a href="<?= Url::to(['/video/detail', 'video_id' => $vi['video_id']])?>"
                                                               class="qy-mod-link">
                                                                <img class="qy-mod-cover" src="<?= $vi['horizontal_cover']?>">
                                                                <!--                                                                <div class="icon-tr">-->
                                                                <!--                                                                    <img src="images/VIP.png">-->
                                                                <!--                                                                </div>-->
                                                                <div class="icon-br icon-b">
                                                                    <span class="qy-mod-label"><?= $vi['flag']?></span>
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <div class="title-wrap">
                                                            <p class="main">
                                                                <a href="<?= Url::to(['/video/detail', 'video_id' => $vi['video_id']])?>"
                                                                   class="link-txt" title="<?= $vi['video_name']?>"><?= $vi['video_name']?></a></p>
                                                            <div class="sub"><?= $vi['intro']?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach;?>
                                        </div>
                                        <!-- Add Arrows -->
                                        <div class="swiper-button-next"></div>
                                        <div class="swiper-button-prev"></div>
                                    </div>
                                </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>
                <div class="c"></div>

                <div class="qy-mod-title">
                    <h3 class="mod-title">猜你喜欢</h3>
                </div>
                <div class="qy-mod-list qy-mod-list-1">
                    <div class="qy-mod-ul">
                        <?php foreach ($data['guess_like'] as $key => $list) :?>
                            <?php if($key < 8) :?>
                                <div class="qy-mod-li">
                                    <div class="qy-mod-img vertical">
                                        <div class="qy-mod-link-wrap">
                                            <a href="<?= Url::to(['/video/detail', 'video_id' => $list['video_id']])?>"
                                               class="qy-mod-link">
                                                <div style="height:100%;overflow:hidden;">
                                                    <img src="<?= $list['cover']?>" originalsrc="images/p-1.jpg" class="qy-mod-cover">
                                                </div>
                                                <!--                                                    <div class="icon-tr">-->
                                                <!--                                                        <img src="images/self.png">-->
                                                <!--                                                    </div>-->
                                                <span class="date-lab"><?= $list['flag']?></span>
                                            </a>
                                        </div>
                                        <div class="title-wrap">
                                            <p class="main">
                                                <a href="" class="link-txt" ><span ><?= $list['video_name']?></span></a>
                                            </p>
                                            <div class="sub"><?= $list['intro']?></div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif;?>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
        </div>
        <aside class="qy-aura3 play-con-sd">
            <div class="qy-mod-wrap side-wrap ">
                <div class="qy-mod-title">
                    <h3 class="mod-title"><?= $channelName ?> · 风云榜
                        <div class="qy-rank-enter">
                            <a href="<?= Url::to(['hot-play', 'channel_id' => $channel_id])?>" class="rank-enter-link">
                                <span class="more">全部榜单&nbsp;</span>
                                <i class="qy-svgicon qy-svgicon-rightarrow_cu"></i>
                            </a>
                        </div>
                    </h3>
                </div>
                <div>
                    <div class="qy-mod-rank-des-min">
                        <ul class="rank-list">
                            <?php foreach ($hotword['tab'] as $key => $tab): ?>
                                <?php if($tab['title'] == $channelName) :?>
                                    <?php foreach ($tab['list'] as $key => $list): ?>
                                        <li class="rank-item">
                                            <a href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>"
                                               class="rank-item-link">
                                                <div class="mod-left">
                                                    <div class="rank-num-box">
                                                        <span class="qy-rank-no No<?= $key+1?>">NO</span>
                                                        <i class="sprite-rank-min rank-nub rank-nub-<?= $key+1?>"><?= $key+1?></i>
                                                    </div>
                                                </div>
                                                <div class="mod-right">
                                                    <h3 class="main-title">
                                                        <p href="javascript:" class="title-link"><?= $list['video_name']?></p>
                                                    </h3>
                                                    <div class="sub-box">
                                                        <div class="sub-right"><i class="qy-svgicon qy-svgicon-hot hot-red"></i><span class="count">
                                                                <?= $list['play_times']?></span>
                                                        </div>
                                                        <p class="sub-des"><?= $list['summary']?></p>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    <?php endforeach;?>
                                <?php endif;?>
                            <?php endforeach;?>
                        </ul>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>

<div class="c"></div>
<div class="qy-scroll-anchor qy-aura3">
    <ul class="scroll-anchor">
        <li class="anchor-list anchor-integral">
            <div class="qy-scroll-integral popBox dn">
                <span class="tianjia-arrow"></span>
                <img src="/images/NewVideo/client_wechat.jpg" alt="">
            </div>
            <a href="javascript:;" class="anchor-item j-pannel"><i class="qy-svgicon qy-svgicon-anchorIntegral j-pannel"></i><i class="dot j-pannel"></i></a>
        </li>
        <li class="anchor-list anchor-tianjia">
            <!--<div class="qy-scroll-tianjia popBox dn">-->
            <!--    <span class="tianjia-arrow"></span>-->
            <!--    <div class="tianjia-con">-->
            <!--        <p class="tianjia-text">添加-->
            <!--            <span class="tianjia-link">“网页应用”</span>-->
            <!--            <br>硬核内容全网独播~-->
            <!--        </p>-->
            <!--        <a href="javascript:;" class="tianjia-btn">立即添加</a>-->
            <!--    </div>-->
            <!--</div>-->
            <a href="javascript:;" class="anchor-item"><i class="qy-svgicon qy-svgicon-tianjia"></i></a>
        </li>
        <li class="anchor-list">
            <a href="" class="anchor-item"><i class="qy-svgicon qy-svgicon-anchorHelp"></i><span class="anchor-txt">帮助反馈</span></a>
        </li>
        <li class="anchor-list dn">
            <a href="javascript:;"  class="anchor-item backToTop"><i class="qy-svgicon qy-svgicon-anchorTop"></i><span class="anchor-txt">回到顶部</span></a>
        </li>
    </ul>
</div>
<!-- 求片 -->
<style>
.seekbox02 img {
	border: none;
	background: rgba(255, 255, 255, 0);
	box-shadow: none;
}
.seekbox02 a,
.seekbox02 button,
.seekbox02 input {
	-webkit-tap-highlight-color: rgba(0, 0, 0, 0);
	outline: none;
}

.seekbox02 ul {
	list-style: none;
}

.seekbox02 a {
	text-decoration: none;
	color: #000;
	outline: none
}

.seekbox02 input[type=button],
.seekbox02 input[type=submit],
.seekbox02 input[type=file],
.seekbox02 button {
	cursor: pointer;
	-webkit-appearance: none;
}

.seekbox02 input {
	font-family: "微软雅黑";
	appearance: none;
	border: none;
	border-radius: 0;
	background-color: rgba(0, 0, 0, 0);
	-webkit-border-radius: 0;
	-webkit-border: none;
	outline: none;
}

.seekbox02 textarea {
	outline: none;
	resize: none;
	font-family: "微软雅黑";
	appearance: none;
	border: none;
	border-radius: 0;
	-webkit-border-radius: 0;
	-webkit-border: none;
	-webkit-appearance: none;
	text-align: center;
}

.seekbox02 input::placeholder,
.seekbox02 textarea::placeholder {
	color: rgba(255, 255, 255, 0.7);
}

.seekbox02 select {
	width: 100%;
	height: 50px;
	font-size: 16px;
	border: none;
	outline: none;
	appearance: none;
	-moz-appearance: none;
	-webkit-appearance: none;
	-webkit-tap-highlight-color: rgba(0, 0, 0, 0);
	padding-right: 14px;
	background-color: rgba(0, 0, 0, 0);
	background-image: url(../images/video/icon-down.png);
	background-repeat: no-repeat;
	background-size: 10px 10px;
	background-position: right center;
}
.seekbox02 {
	position: absolute;
	top: 50%;
	left: 50%;
	margin-left: -375px;
	margin-top: -290px;
	width: 750px;
	height：580px;
	padding: 20px;
	box-sizing: border-box;
	background-color: #FFFFFF;
	font-family: "微软雅黑";
	z-index: 1001;
}

.seekbox02-text {
	height: 40px;
	line-height: 50px;
	font-size: 16px;
	font-weight: bold;
}

.seekbox-ipt>input {
	width: 100%;
	height: 40px;
	padding: 0px 10px;
	box-sizing: border-box;
	background-color: #F4F4F4;
}
.clrOrangered{
	color: #FF556E;
}
.seekbox-ipt>input::placeholder {
	color: #999999;
}

.seekbox02-text02 {
	position: relative;
	height: 80px;
	line-height: 80px;
	font-size: 14px;
	color: #999999;
	text-align: center;
	z-index: 0;
}

.seekbox02-text02:after {
	content: "";
	border-top: 1px solid hsla(0, 0%, 40%, .2);
	position: absolute;
	top: 50%;
	left: 0;
	width: 42%;
	z-index: -1;
}

.seekbox02-text02:before {
	content: "";
	border-top: 1px solid hsla(0, 0%, 40%, .2);
	position: absolute;
	top: 50%;
	right: 0;
	width: 42%;
	z-index: -1;
}

.seekbox02-ul {
	display: grid;
	grid-template-columns: 210px 210px auto 210px;
	grid-gap: 10px;
	overflow: hidden;
}

.seekbox02-ul>li {
	height: 40px;
	line-height: 40px;
	font-size: 16px;
	text-align: center;
}

.seek-slk {
	box-sizing: border-box;
	padding: 0px 10px;
	height: 40px;
	background-color: #F4F4F4;
	background-position-x: 95%;
}

.seekbox-tta>textarea {
	width: 100%;
	height: 80px;
	line-height: 20px;
	text-align: left;
	padding: 10px;
	box-sizing: border-box;
	background-color: #F4F4F4;
}

.seekbox-tta>textarea::placeholder {
	color: #999999;
}

.seekbox-text03 {
	height: 40px;
	line-height: 40px;
	font-size: 16px;
	text-align: right;
}

.seek-btn {
	padding: 0px 20px;
	height: 40px;
	font-size: 16px;
	color: #FFFFFF;
	background-color: #FF556E;
}

.seek-bottom {
	margin-bottom: 20px;
}
.alt-GB {
	position: absolute;
    top: 0px;
    right: 0px;
	font-size: 30px;
	color: rgba(0, 0, 0, 0);
	background-image: url(../images/video/guanbi.png);
	background-position: center;
	background-repeat: no-repeat;
	background-size: 24px;
	width: 50px;
	height: 50px;
}

.alt {
	display: none;
	position: fixed;
	top: 0;
	left: 0;
	width: 100%;
	min-width: 1336px;
	height: 100%;
	background-color: rgba(0, 0, 0, 0.5);
	overflow: hidden;
	z-index: 1001;
}
.alt05-box {
	position: absolute;
	top: 50%;
	left: 50%;
	margin-left: -200px;
	margin-top: -190px;
	width: 400px;
	background-color: #FFFFFF;
	box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.5);
	overflow: hidden;
}
.alt04-box {
	position: absolute;
	top: 50%;
	left: 50%;
	margin-left: -250px;
	margin-top: -190px;
	padding: 20px;
	width: 500px;
	height: 380px;
	background-color: #FFFFFF;
	box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.5);
	overflow: hidden;
}
#alt04 .alt-GB {
	font-family: "微软雅黑";
	appearance: none;
	border: none;
	border-radius: 0;
	background-color: rgba(0, 0, 0, 0);
	-webkit-border-radius: 0;
	-webkit-border: none;
	outline: none;
}

.alt-title {
	padding: 80px 20px;
	text-align: center;
}

.alt-bth-box {
	text-align: center;
	border-top: solid 1px #DDDDDD;
}

.alt-bth-box>input {
	display: inline-block;
	height: 60px;
	line-height: 60px;
	width: 49%;
	min-width: 120px;
	font-size: 16px;
	border-left: solid 1px #DDDDDD;
	font-weight: bold;
}

.alt-bth-box>input:first-of-type {
	border: none;
}

.alt-bth-box>input:hover {
	color: #FF556E;
}

.alt-bth-off {
	color: #999999;
}

.alt-bth-on {
	color: #FF556E;
}

</style>
<div class="alt" id="seekbox02" style="display:none;">
    <div class="seekbox02" name="zt" >
        <input class="alt-GB" type="button" id="v_close" value="X">
    	<div class="seekbox02-text clrOrangered">
    		填写影片名称(只提供旧片)
    	</div>
    	<div class="seekbox-ipt">
    	    <input type="text" name="zt" id="v_videoname" placeholder="输入片名" value="" />
    	</div>
    	<div class="seekbox02-text02" name="zt">
    	    <span>以下信息选填</span>
    	</div>
    	<ul class="seekbox02-ul seek-bottom">
    		<li>
    			<select class="seek-slk" name="zt" id="v_channelid" style="height: 40px;background-color: #F4F4F4;background-position-x: 95%;">
                    <?php foreach ($seek['channels'] as $channel) :?>
                        <?php if($channel['channel_name'] != '首页') :?>
                            <option value="<?=$channel['channel_id']?>"><?=$channel['channel_name']?></option>
                        <?php endif; ?>
                    <?php endforeach;?>
    			</select>
    		</li>
    		<li>
    			<select class="seek-slk" name="zt" id="v_areaid" style="height: 40px;background-color: #F4F4F4;background-position-x: 95%;">
    				<?php foreach ($seek['areas'] as $area) :?>
                        <option value="<?=$area['area_id']?>"><?=$area['area']?></option>
                    <?php endforeach;?>
    			</select>
    		</li>
    		<li name="zt">
    			年份
    		</li>
    		<li>
    			<div class="seekbox-ipt">
    				<input type="text" name="zt" id="v_year" placeholder="输入片名年份" value="" />
    			</div>
    		</li>
    	</ul>
    	<div class="seekbox02-text" name="zt">
    		导演
    	</div>
    	<div class="seekbox-ipt seek-bottom">
    		<input type="text" name="zt" id="v_director" placeholder="输入导演" value="" />
    	</div>
    	<div class="seekbox02-text" name="zt">
    		演员
    	</div>
    	<div class="seekbox-tta seek-bottom">
    		<textarea placeholder="请输入演员 最多50字" name="zt" id="v_actors"></textarea>
    	</div>
    	<div class="seekbox-text03 seek-bottom" name="zt">
    		<span class="clrOrangered">*</span>完善影片信息能够提高求片的成功率哦！
    		<input class="seek-btn" type="button" name="" id="v_submit" value="提交" style="background-color: #FF556E;" />
    	</div>
    </div>
</div>

<!--提交成功弹出层-->
<div class="alt" id="alt05" style="display:none;">
    <div class="alt05-box" name="zt">
        <!--报错也用这个弹出层-->
        <p class="alt-title" name="zt">求片成功</p>
        <!--多余的可以删除-->
        <div class="alt-bth-box" name="zt">
<!--            <input class="alt-bth-off closealt05" type="button" name="" id="" value="取消" />-->
            <input class="alt-bth-on" type="button" name="" id="closealt05" value="确定" style="background-color: #FFFFFF;" />
        </div>
    </div>
    <!--关闭按钮-->
    <!--<input class="alt-GB" type="button" id="" value="X" />-->
</div>

<!--片源报错alert-->
<div class="alt" id="alt04">
    <div class="alt04-box" name="zt" style="height:300px;">
        <!--关闭按钮-->
        <input class="alt-GB" type="button" id="closealt04" value="X" />
        <div class="hlp-t03" name="zt">
            片源报错<!--<span class="clrOrangered">(您需要先登录才能提交反馈)</span>-->
        </div>
        <div class="seekbox02-text" name="zt">
            报错原因
        </div>
        <div class="seekbox-tta seek-bottom">
            <textarea placeholder="请输入报错原因 最多50字" name="zt" id="v_reason"></textarea>
        </div>

        <div class="seekbox-text03 seek-bottom" name="zt">
            <span id="v_feedresult" style="color:red;"></span>
            <input class="seek-btn" type="button" name="" id="v_feedsubmit" value="提交" />
        </div>
    </div>
</div>
<script src="/js/jquery.js"></script>
<script src="/js/video.js"></script>
<script src="/js/VideoSearch.js"></script>
<script>
    let timer = null;
    let wechattimer = null
	let picUrl = "/video/get-wechat";
	let checkUrl = "/video/check-wechat";
	let clearUrl = "/video/clear-catch";
    $(document).ready(function(){
        $(".wechat-block").remove("");
        if ($("#play_resource").val() != "")
            $("#my-iframe").attr('src', $("#play_resource").val() + "&ad_url=<?php echo $ad_url;?>&ad_link=<?php echo $ad_link;?>&ad_type=<?php echo $ad_type;?>");
        // refreshWechat();
        // alert(document.getElementById('wechat-block').style.display);
        if(document.getElementById('wechat-block') && document.getElementById('wechat-block').style.display!='none')
        {
            setTimeout(function(){
                clearInterval(wechattimer);
                document.getElementById('wechat-block').style.display='none';

                // if(document.getElementById('easiBox') && document.getElementById('easiBox').style.display!='none')
                //     $('#btn-video-play').trigger("click");

                // if(document.getElementById('picBox') && document.getElementById('picBox').style.display!='none')
                //     countPicAds();

                // setTimeout("document.getElementById('easiBox').style.display='none'",15000);
                // setTimeout("document.getElementById('picBox').style.display='none'",15000);
            },30000);
        }
        // else
        // {
        //     setTimeout("document.getElementById('easiBox').style.display='none'",15000);
        //     setTimeout("document.getElementById('picBox').style.display='none'",15000);
        // }
        // $('#btn-video-play').trigger("click");
        // countPicAds();
        // refreshAds();
    });

    function refreshAds()
    {
        var arrIndex = {};

        arrIndex['page'] = "detail";
        var advertKey = 0;
        $.get('/video/advert', arrIndex, function(res) {
            if(!res.data.hasOwnProperty("advert"))
                return false;

            for (var prop in res.data.advert) {
                console.log("obj." + prop + " = " + res.data.advert[prop]);
                var adddata = res.data.advert[prop];
                if (adddata.hasOwnProperty("position_id")) {
                    if (prop == "videotop") {
                        $(".video-top-ad").attr("href", adddata.ad_skip_url);
                        $(".video-top-ad img").attr("src", adddata.ad_image);
                    }
                    else if (prop == "videobottom") {
                        $(".video-bottom-add").attr("href", adddata.ad_skip_url);
                        $(".video-bottom-add img").attr("src", adddata.ad_image );
                    }
                    else if (prop == "playbefore") {
                        $(".add-box .ad_url_link").attr("href", adddata.ad_skip_url);
                        if (adddata.ad_image.indexOf(".mp4") != -1)
                        {
                            $("#picBox").remove();
                            $(".add-box video").html("");
                            $(".add-box video").html("<source src='"+ adddata.ad_image + "' type='video/mp4'></source>");
                            $(".add-box video").load();
                            // $(".add-box video").trigger('play');
                            // countVieoAds();
                            $('#btn-video-play').trigger("click");
                            setTimeout("document.getElementById('easiBox').style.display='none'",15000);
                            $("#my-iframe").attr('src', $("#play_resource").val());
                        }
                        else
                        {
                            $("#easiBox").remove();
                            $(".add-box img").attr("src", adddata.ad_image);
                            setTimeout("document.getElementById('picBox').style.display='none'",15000);
                            countPicAds();
                        }
                    }
                }
            }
        })
    }

    function refreshWechat()
    {
        var arrIndex = {};
        // $(".wechat-block").hide();
        $.get(picUrl, function(response) {
            console.log(response);
            let result = response.data;
            if (result.status_code != "200") {
                $(".wechat-block").remove("");
                //   refreshAds();
                $('#btn-video-play').trigger("click");
                countPicAds();
                return;
            }
            console.log(response);
            $(".wechat-block").show();

            $('.wechat-url').attr('src', result.data.img_url)
            $('.wechat_tip').html("<span>"+ result.data.weChatFlag +"</span>");

            wechattimer = setInterval(function() {
                arrIndex['wechat_flag'] = result.data.weChatFlag;
                $.get(checkUrl, arrIndex ,function(response) {
                    let scene = response.data.scene;
                    console.log(response);
                    console.log(scene);
                    if(scene == "gotted")
                    {
                        $(".wechat-block").remove("");
                        arrIndex['catachkey'] = result.data.weChatFlag;
                        $.get(clearUrl, arrIndex);
                        clearInterval(wechattimer);
                        // refreshAds();
                        $('#btn-video-play').trigger("click");
                        countPicAds();
                    }
                })
            }, 2000)
        })
    }

    $("#btn-video-play").click(function(){
        var currentTime = 0;
        var duration = 0;
        var elevideo = document.getElementById("easi");
        $(this).hide();
        duration = Math.round(elevideo.duration);
        if (isNaN(duration))
            duration = 10;

        document.getElementById('timer1').innerHTML = duration;

        $(".add-box video").trigger('play');
        elevideo.addEventListener('play', function () { //播放开始执行的函数
            duration = Math.round(elevideo.duration);
            if (isNaN(duration))
                duration = 10;

            if (elevideo.currentTime != 0){
                duration = Math.round(elevideo.duration - elevideo.currentTime);
            }

            console.log("开始播放");
            //10s后关闭广告视频
            countDown(duration - 1,function(msg) {
                if(msg == '0'){
                    if(document.getElementById('easiBox'))
                        document.getElementById('easiBox').style.display='none';
                }
                document.getElementById('timer1').innerHTML = msg;
            })
        });

        elevideo.addEventListener('pause', function () { //暂停开始执行的函数
            duration = document.getElementById('timer1').innerHTML;
            clearInterval(timer);
            console.log("暂停播放");
        });

        elevideo.addEventListener('ended', function () { //结束
            document.getElementById('easiBox').style.display='none';
            console.log("播放结束");
            // $("#my-iframe").attr('src', $("#play_resource").val());
        }, false);
    });

    function countPicAds()
    {
        if($('.iqp-player #picBox').length > 0)
        {
            //8s后关闭广告图
            document.getElementById('timer1').innerHTML = 10;
            countDown(9, function(msg) {
                if(msg == 0){
                    //if(document.getElementById('picBox'))
                    document.getElementById('picBox').style.display='none';
                }
                console.log(msg);
                document.getElementById('timer1').innerHTML = msg;
            });
        }
    }

    function countDown(maxtime,fn){
        timer = setInterval(function() {
            if(!!maxtime ){
                seconds = Math.floor(maxtime%60),
                    msg = seconds;
                fn( msg );
                --maxtime;
            } else {
                clearInterval(timer );
                msg="0";
                fn(msg);
            }
        },1000);
    }

    $("#hide-add").click(function(){
        if(document.getElementById('picBox'))
            document.getElementById('picBox').style.display='none';

        if(document.getElementById('easiBox'))
        {
            var elevideo = document.getElementById("easi");
            elevideo.pause()
            document.getElementById('easiBox').style.display='none';
        }

    });
    
    $('.bar-link').click(function(){
        var videoId = "<?= $data['info']['play_video_id']?>";
        var chapterId = "<?= $data['info']['play_chapter_id']?>";
        var sourceId = $(this).attr('data-source-id');

        if(sourceId != undefined && sourceId != null)
        {
            $('#srcTab-'+sourceId).trigger('click');
            if(document.getElementById('chap-'+sourceId +'-'+chapterId))
                $('#chap-'+sourceId +'-'+chapterId).trigger('click');
            else{
                $('#srctab-'+sourceId +' .switch-next-li:first').trigger('click');
            }
        }
        
    });
    
    //片源报错
    $('#err_feedback').click(function(){
        $("#v_reason").val('')
        $("#alt04").show();
    })
    //提交
    $('#v_feedsubmit').click(function(){
        var feedUrl = "/video/feed-back";
        var feedIndex = {};
        feedIndex['video_id'] = "<?= $data['info']['play_video_id']?>";
        feedIndex['chapter_id'] = "<?= $data['info']['play_chapter_id']?>";
        feedIndex['source_id'] = "<?= $source_id?>";
        feedIndex['reason'] = $("#v_reason").val();
        $.get(feedUrl, feedIndex ,function(response) {
            var result = response.data;
            // $("#v_feedresult").text(result.message);
            // alert(result.message);
            $("#alt04").hide();
            $(".alt-title").text(result.message);        
            $("#alt05").show();   
        });
        //console.log(feedIndex);
        // alert("功能维护中，敬请期待")
    })
    //关闭片源拨错
    $('#closealt04').click(function(){
        $("#alt04").hide();
    });
    
    //求片
    $(function(){
        $('#seek').click(function(){
            $("#seekbox02").show();
        })
        //提交求片
        $('#v_submit').click(function(){
            var tab = true;
            var str = '提交成功';
            if($("#v_videoname").val().trim() == ''){
                tab = false;
                str = '请填写影片名';
            }else if(isNaN($("#v_year").val())){
                tab = false;
                str = '请正确输入年代';
            }else if($("#v_director").val().length>32){
                tab = false;
                str = '导演名称长度超出范围';
            }else if($("#v_actors").val().length>50){
                tab = false;
                str = '演员名称长度超出范围';
            }
            if(tab){
                var arrIndex = {};
                arrIndex['video_name'] = $("#v_videoname").val();         
                arrIndex['channel_id'] = $("#v_channelid").val();    
                arrIndex['area_id'] = $("#v_areaid").val();    
                arrIndex['year'] = $("#v_year").val();    
                arrIndex['director_name'] = $("#v_director").val();    
                arrIndex['actor_name'] = $("#v_actors").val();   
                //发送请求，获取数据     
                $.get('/video/save-seek', arrIndex, function(s) {
                    // console.log(arrIndex);
                    if(s>0){
                        //插入成功，所有值置空
                        $("#v_videoname").val(''); 
                        $("#v_channelid").find("option").eq(0).prop("selected",true);
                        $("#v_areaid").find("option").eq(0).prop("selected",true);  
                        $("#v_year").val('');  
                        $("#v_director").val(''); 
                        $("#v_actors").val('');  
                        str = "提交成功";
                        $("#seekbox02").hide();
                        $(".alt-title").text(str);        
                        $("#alt05").show();   
                    }else{
                        str = "提交失败";
                        $("#seekbox02").hide();
                        $(".alt-title").text(str);        
                        $("#alt05").show();   
                    }                
                });
            }else{
                $(".alt-title").text(str);        
                $("#alt05").show();   
            }
        });
        
        //关闭求片
        $('#v_close').click(function(){
            $("#seekbox02").hide();
            $("#v_videoname").val(''); 
            $("#v_channelid").find("option").eq(0).prop("selected",true);
            $("#v_areaid").find("option").eq(0).prop("selected",true);  
            $("#v_year").val('');  
            $("#v_director").val(''); 
            $("#v_actors").val('');  
        });
        
        //关闭求片提示
        $('#closealt05').click(function(){
            $("#alt05").hide();
        });
    });
    
</script>
</body>
</html>
