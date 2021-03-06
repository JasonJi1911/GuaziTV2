<?php
use yii\helpers\Url;
use pc\assets\StyleShareDown;

$this->title = '瓜子TV-澳新华人在线视频分享网站';
StyleShareDown::register($this);
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
    <meta name="viewport" content="width=device-width">
    <style>
    a:hover,
    a:focus {
        
    }
</style>
</head>
<body>
<div class="wrapper">
    <div class="head">
        <div class="head-title">
            <a>瓜子TV</a><br>
            <a>追剧神器</a>
        </div>
        <div class="head-input-box">
            <input type="text" placeholder="iphone、Android手机，扫码直接下载！">
            <a href="<?= Url::to(['/video/index'])?>"></a>
        </div>
        <div class="head-button">
            <?php if(!empty($data["iosdata"])) :?>
                <!--<a href="<?=$data["iosdata"]["file_path"]?>" class="button1">iPhone下载</a>-->
                <!--<a href="###" class="button1">无IOS应用</a>-->
            <?php else :?>
                <a href="###" class="button1">无IOS应用</a>
            <?php endif; ?>

            <?php if(!empty($data["androiddata"])) :?>
                <a href="<?=$data["androiddata"]["file_path"]?>" class="button2">Android下载</a>
            <?php else :?>
                <a href="<?=$data["iosdata"]["file_path"]?>" class="button2">无安卓应用</a>
            <?php endif; ?>

            <?php if(!empty($data["tvdata"])) :?>
                <a href="<?=$data["tvdata"]["file_path"]?>" class="button2">电视TV下载</a>
            <?php else :?>
                <a href="<?=$data["iosdata"]["file_path"]?>" class="button2">无电视应用</a>
            <?php endif; ?>
        </div>
        <div class="content-title "><div><img src="/images/ShareDown/7.png" alt="" srcset=""></div> 片源超级全 </div>
        <div class="content1">
            <div class="content-box">
                <p>无论是国内最火的电视剧、综艺   </p>
                <p>还是日剧、韩剧、英剧、美剧、各种电影、</p>
                <p>纪录片、动漫等等</p>
                <p>瓜子TV<a href="<?= Url::to(['/video/index'])?>">（www.guazitv.tv)</a>都应有尽有</p>
            </div>
        </div>
    </div>
    <div class="content-fast bk-1">
        <div class="content2">
            <div class="content-title "><div><img src="/images/ShareDown/7.png" alt="" srcset=""></div> 更新特别快 </div>
            <div class="content-box">
                <p>在瓜子TV<a href="<?= Url::to(['/video/index'])?>">（www.guazitv.tv)</a></p>
                <p>基本上所有热门的综艺和电视剧和国内的</p>
                <p>更新速度都是同步的</p>
            </div>

        </div>
    </div>
    <div class="content-fast bk-2">
        <div class="content2">
            <div class="content-title"><div><img src="/images/ShareDown/7.png" alt="" srcset=""></div> 没有广告 </div>
            <div class="content-box">
                <p>瓜子TV<a href="<?= Url::to(['/video/index'])?>">（www.guazitv.tv)</a></p>
                <p>没有任何广告，想看啥，点进去直接看</p>
                <p>就是这么简单粗暴省时省事</p>
            </div>
        </div>
    </div>
    <div class="content-fast bk-3">
        <div class="content2">
            <div class="content-title"><div><img src="/images/ShareDown/7.png" alt="" srcset=""></div> 各种直播随心看 </div>
            <div class="content-box">
                <p>无论是湖南卫视、江苏卫视、CCTV</p>
                <p>还是各种体育赛事,都可以随时</p>
                <p>在瓜子TV看直播</p>
                <p>让你享受不一样的直播体验</p>
            </div>
        </div>
    </div>
    <div class="foot">
        <p>瓜子TV - 追剧神器</p>
        <div class="foot-input-box">
            <input type="text" placeholder="www.guazitv.tv">
            <a href="<?= Url::to(['/video/index'])?>"></a>
        </div>
        <div class="foot-button">
            <?php if(!empty($data["iosdata"])) :?>
                <!--<a href="<?=$data["iosdata"]["file_path"]?>" class="button1">iPhone下载</a>-->
                <!--<a href="###" class="button1">无IOS应用</a>-->
            <?php else :?>
                <a href="###" class="button1">无IOS应用</a>
            <?php endif; ?>

            <?php if(!empty($data["androiddata"])) :?>
                <a href="<?=$data["androiddata"]["file_path"]?>" class="button2">Android下载</a>
            <?php else :?>
                <a href="<?=$data["iosdata"]["file_path"]?>" class="button2">无安卓应用</a>
            <?php endif; ?>

            <?php if(!empty($data["tvdata"])) :?>
                <a href="<?=$data["tvdata"]["file_path"]?>" class="button2">电视TV下载</a>
            <?php else :?>
                <a href="<?=$data["iosdata"]["file_path"]?>" class="button2">无电视应用</a>
            <?php endif; ?>
            <!--<a href="https://fir.geroinv.com/downapple?randStr=s1v6ma39us" class="button1">iPhone下载</a>-->
            <!--<a href="http://app.guazitv6.com/gztvfire-v1.0.2.apk" class="button2">Android下载</a>-->
            <!--<a href="http://app.guazitv6.com/guazi-tv-1.0.3-release.apk" class="button2">电视TV下载</a>-->
        </div>
    </div>
</div>

</body>
</html>