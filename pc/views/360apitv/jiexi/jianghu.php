
<?php
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
define('FCPATH', Yii::$app->BasePath);
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(0);
include FCPATH . "/web/360apitv/jiexi/tj.php";
require_once FCPATH . '/web/360apitv/jiexi/admin/user.php';
require_once FCPATH . '/web/360apitv/jiexi/admin/data.php';
require_once FCPATH . '/web/360apitv/jiexi/func/func.php';
define('REFERER_URL',  $user['fd']); 

$origin = isset($_SERVER['HTTP_ORIGIN']) ?$_SERVER['HTTP_ORIGIN']: $_SERVER['HTTP_REFERER'];
$allow_origin = array('http://www.360apitv.com','http://wap-video-test.aizaihehuan.com','http://360apitv.com');
if (in_array($origin, $allow_origin)) {
    header("Access-Control-Allow-Origin:" . $origin);
}
header("Access-Control-Allow-Origin: http://360apitv.com");
header('Access-Control-Allow-Methods:OPTIONS, GET, POST'); // 允许option，get，post请求
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: x-requested-with,content-type");
header("Access-Control-Allow-Origin: *");
header("Cache-Control: no-cache, no-store, max-age=0, must-revalidate");
header("Connection: keep-alive");
header("Transfer-Encoding: chunked");
header("referer: guazitv.tv");

define('ERROR', '<html><meta name="robots" content="noarchive"><head><title>'.$user['title'].'</title></head><style>h1{color:#C7636C; text-align:center; font-family: Microsoft Jhenghei;}p{font-size: 1.2rem;text-align:center;font-family: Microsoft Jhenghei;}</style><body><table width="100%" height="100%" align="center"><td align="center"><h1>本站已开启API接口防盗</h1><p>'.$user['fdhost'].'</p></table></body></html>');
if(!empty(REFERER_URL))
{
    @$referer = $_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : base64_decode($_POST['referer']);
    $refererhost = parse_url($referer, PHP_URL_HOST);
    if(!in_array(strtolower($refererhost),explode("|", strtolower(REFERER_URL))))
    {
        header('HTTP/1.1 403 Forbidden');
        exit(ERROR);
    }
}   
$uid = $user['uid'];
$token = $user['token'];
$color = $yzm['color'];
$tj=$user['tongji'];
$right_wenzi=$user['wenzi'];
$right_link=$user['link'];
$p2p  = $user['p2p'];
$color= $yzm['color'];
$api2=$user['api'];//
// $url = $_GET["v"];
$url = urldecode($url);
$preg = "/^http(s)?:\\/\\/.+/";
$type = "";
if (preg_match($preg, $url)) {
	if (strstr($url, ".m3u8") == true || strstr($url, ".mp4") == true || strstr($url, ".flv") == true) {
		$type = $url;
		$metareferer = "never";//	$metareferer = "origin";
	}
    
}

if (strstr($url, "qq.com") == true && strstr($url, "shcdn-qq") == false) {
	$fh = get_url("http://guazitv.tv/jx/?url=" . $url);
	$jx = json_decode($fh, true);
	$type = $jx["url"];
	$metareferer = $jx["metareferer"];
	if ($metareferer == "") {
		$metareferer = "never";
	}
}


if (strstr($url, "iqiyi.com") == true) {
	$fh = get_url("http://guazitv.tv/jx/?url=" . $url);
	$jx = json_decode($fh, true);
	$type = $jx["url"];
	$metareferer = $jx["metareferer"];
	if ($metareferer == "") {
		$metareferer = "never";
	}
}

// if (strstr($url, "http") == false) {
// 	$fh = get_url("http://guazitv.tv/app.php?url=" . $url);
// 	$jx = json_decode($fh, true);
// 	$type = $jx["url"];
// 	$metareferer = $jx["metareferer"];
// 	if ($metareferer == "") {
// 		$metareferer = "never";
// 	}
// }

// if (strstr($url, "alizy") == true) {
// 	$fh = get_url("https://jx.cqzyw.net:8655/analysis/index/?uid=130&token=cmryAGHKLOPQUYZ026&url=" . $url);
// 	$jx = json_decode($fh, true);
// 	$type = $jx["url"];
// 	$metareferer = $jx["metareferer"];
// 	if ($metareferer == "") {
// 		$metareferer = "never";
// 	}
// }


if ($type == "") {
    $fh = get_url("http://guazitv.tv/jx/?url=" . $url);
	$jx = json_decode($fh, true);
	$type = $jx["url"];
	$metareferer = $jx["metareferer"];
	if ($metareferer == "") {
		$metareferer = "never";
	}
}

$metareferer = ""

?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta charset="UTF-8">
<!--<meta name="referrer" content="<?php echo $metareferer;?>">-->
<meta name="x5-fullscreen" content="true" /><meta name="x5-page-mode" content="app"  /> <!-- X 全屏处理 -->
<meta name="full-screen" content="yes" /><meta name="browsermode" content="application" />  <!-- UC 全屏应用模式 -->
<meta name="apple-mobile-web-app-capable" content="yes "/> <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" /> <!--  苹果全屏应用模式 -->   
<link rel="stylesheet" href="/360apitv/jiexi/jianghu/assets/css/yzmplayer.css?v=2021">
<style>
    .yzmplayer-setting-speeds:hover .title, .yzmplayer .yzmplayer-controller .yzmplayer-icons.yzmplayer-comment-box .yzm-yzmplayer-send-icon {
    	background-color: <?php echo $color;?> !important;
    }
    .showdan-setting .yzmplayer-toggle input+label, .yzmplayer-volume-bar-inner, .yzmplayer-thumb, .yzmplayer-played, .yzmplayer-comment-setting-box .yzmplayer-setting-danmaku .yzmplayer-danmaku-bar-wrap .yzmplayer-danmaku-bar .yzmplayer-danmaku-bar-inner, .yzmplayer-controller .yzmplayer-icons .yzmplayer-toggle input+label, .yzmplayer-controller .yzmplayer-icons.yzmplayer-comment-box .yzmplayer-comment-setting-box .yzmplayer-comment-setting-type input:checked+span  {
        background: <?php echo $color;?> !important;
    }
    
    #ADmask {
        height: 70% !important;
        display: inline-block;
        width: 100%;
        height: 85%;
        color: #fff;
        overflow: hidden;
        position: absolute;
        z-index: 99;
        top: 0px;
        left: 0px;
        cursor: pointer;;
    }
</style>
<script src="/360apitv/jiexi/jianghu/assets/js/jquery.min.js"></script>
<script src="/360apitv/jiexi/jianghu/js/jhplayer.js"></script>
<script src="/360apitv/jiexi/jianghu/js/setting.js?v=2024"></script>
<?php 
if ($p2p == "1") {
	?>
	<script type="text/javascript" src="/360apitv/jiexi/jianghu/assets/js/hls.p2p.js"></script>
	<?php 
} else {
	?>
	<script type="text/javascript" src="/360apitv/jiexi/jianghu/assets/js/hls.min.js"></script>
	<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/gh/Zrahh/JsDelivr_CDN/assets/js/hls.min.js"></script> -->
<?php 
}
?>

<script src="/360apitv/jiexi/jianghu/assets/js/layer.js"></script>

</head>
<body>
<div id="player"></div>
<div id="ADplayer"></div>
<div id="ADtip" style="width:100%;height:100%;"></div>
<div id="ADmask"></div>

</body></html>
<script type="text/javascript" src="<?php echo $tj;?>"></script>
<script>

    var up = {
        "usernum": "<?php echo $users_online;?>", //在线人数
        "mylink": "", //播放器路径，用于下一集
        "diyid": [0, "游客", 1] //自定义弹幕id
    }
    
    var config = {};
    
    var advert = {};
    advert['ad_type'] = '';
    advert['ad_url'] = '';
    advert['ad_link'] = '';
    var req = new XMLHttpRequest();
    req.open('GET', document.location, false);
    req.send(null);
    var cf_ray = req.getResponseHeader('cf-Ray');//指定cf-Ray的值
    var citycode = '';
    if(cf_ray && cf_ray.length>3){
        citycode = cf_ray.substring(cf_ray.length-3);
    }
    // citycode = 'DRW';
    console.log(citycode);
    var arrIndex = {};
    arrIndex['citycode'] = citycode;
    arrIndex['page'] = 'detail';
    $.get('/video/advert-info', arrIndex, function(res) {
        console.log(res.data.advert.playbefore.advert_id+","+res.data.advert.playbefore.ad_title);
        if(res.errno == 0){
            if(res.data.advert.playbefore.ad_image){
                advert['ad_url'] = res.data.advert.playbefore.ad_image;
                advert['ad_link'] = res.data.advert.playbefore.ad_skip_url;
                if(res.data.advert.playbefore.ad_image.indexOf('.mp4')>=0){
                    advert['ad_type'] = 'mp4';
                }else{
                    advert['ad_type'] = 'img';
                }
            }
        }
        config = {
            "api": "<?php echo FCPATH;?>" + "/web/360apitv/dmku/", //弹幕接口
            "av": "<?php echo $_GET["av"];?>", //B站弹幕id 45520296
        	"id":"<?php echo substr(md5($_GET["v"]), -20);?>",//视频id
        	"sid":"<?php echo $_GET["sid"];?>",//集数id
        	"pic":"",//视频封面
        	"title":"",//视频标题
        	// "next": "",//下一集链接
        	"user": "",//用户名
        	"group": "0",//用户组
        	'startkey': 0,
        	'total': 1,
            'url': ["<?php echo $type;?>",], //视频链接
        	"bbslist": [
    	        {
    	            "link": advert['ad_link'],
    	            "pic": advert['ad_type']=='img' ? advert['ad_url'] : '',
    	            "video": advert['ad_type']=='mp4' ? advert['ad_url'] : '',
    	        },
    	    ],
        }
        YZM.start();
    });
    
    // var _clearTimer = window.setInterval(function(){
        
    //     var _rightWenzi = "<?php echo $right_wenzi;?>";
    //     var _rightLink  = "<?php echo $right_link;?>";
    //     var _menuItemDom= $(".yzmplayer-menu .yzmplayer-menu-item").eq(1);
        
    //     if(_menuItemDom.html().length > 0){
        
    //         window.clearInterval(_clearTimer);
            
    //         _menuItemDom.find("a").attr("href",_rightLink);
    //         _menuItemDom.find("a").html(_rightWenzi);
            
    //     }
        
    // },1000);
    
</script>