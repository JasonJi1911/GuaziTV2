<?php

/* @var $this \yii\web\View */
/* @var $content string */

use pc\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<script>
    if(('standalone' in window.navigator)&&window.navigator.standalone){
        window.desc_status = 'in_desc';
        var noddy,remotes=false;
        document.addEventListener('click',function(event){
            noddy=event.target;
            while(noddy.nodeName!=='A'&& noddy.nodeName!=='HTML')
                noddy=noddy.parentNode;
            if('href' in noddy && noddy.href.indexOf('http')!==-1&&(noddy.href.indexOf(document.location.host)!==-1||remotes)){
                event.preventDefault();
                document.location.href=noddy.href;
            }
        },false);
    };
</script>

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="瓜子TV是澳大利亚、新西兰华人影视视频分享平台，网站包含最新的电视剧、美剧、日韩剧、华语电影、好莱坞电影、以及各种动漫和重大体育赛事直播。在这里，一定有你想看的一切！">
    <link rel="shortcut icon" type="image/x-icon" href="http://img.guazitv.tv/LOGO.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" >
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-6TXJP66KCH"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        
        gtag('config', 'G-6TXJP66KCH');
    </script>

    <?php if ($this->params['isIndex'] == "1") : ?>
        <script type="application/ld+json">{
      "@context":"https://schema.org",
      "@type":"ItemList",
      "itemListElement":[
        {
          "@type": "SiteNavigationElement",
          "position": 1,
          "name": "首页",
          "url":"https://guazitv.tv/"
        },
        {
          "@type": "SiteNavigationElement",
          "position": 2,
          "name": "电影",
          "url":"https://guazitv.tv/video/channel?channel_id=1"
        },
        {
          "@type": "SiteNavigationElement",
          "position": 3,
          "name": "连续剧",
          "url":"https://guazitv.tv/video/channel?channel_id=2"
        },
        {
          "@type": "SiteNavigationElement",
          "position": 4,
          "name": "动漫",
          "url":"https://guazitv.tv/video/channel?channel_id=4"
        },
        {
          "@type": "SiteNavigationElement",
          "position": 5,
          "name": "综艺",
          "url":"https://guazitv.tv/video/channel?channel_id=3"
        },
        {
          "@type": "SiteNavigationElement",
          "position": 6,
          "name": "纪录片",
          "url":"https://guazitv.tv/video/channel?channel_id=32"
        }
      ]
    }
    </script>
    <?php endif; ?>
    <script src="/js/jquery.js"></script>
    <script>
        $(document).ready(function(){
            var mobile_flag = isMobile();

            if(mobile_flag){
                window.location = 'https://m.guazitv.tv/';
            }
        });

        function isMobile() {
            var userAgentInfo = navigator.userAgent;

            var mobileAgents = [ "Android", "iPhone", "SymbianOS", "Windows Phone","iPod"];

            var mobile_flag = false;

            //根据userAgent判断是否是手机
            for (var v = 0; v < mobileAgents.length; v++) {
                if (userAgentInfo.indexOf(mobileAgents[v]) > 0) {
                    mobile_flag = true;
                    break;
                }
            }

            var screen_width = window.screen.width;
            var screen_height = window.screen.height;

            //根据屏幕分辨率判断是否是手机
            if(screen_width < 500 && screen_height < 800){
                mobile_flag = true;
            }

            return mobile_flag;
        }
    </script>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<style>
    a:hover,
    a:focus {
        color: #000;
        text-decoration: none !important;
    }
</style>
<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white classBody">
<?php $this->beginBody() ?>

<?= $content ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
