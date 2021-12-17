<?php
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
define('FCPATH', str_replace("\\", "/", str_replace(SELF, '', __FILE__)));
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(0);

require_once  './request.php';

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

$url = $_GET["v"];
$preg = "/^http(s)?:\\/\\/.+/";
$type = "";

if (preg_match($preg, $url)) {
	if (strstr($url, ".m3u8") == true || strstr($url, ".mp4") == true || strstr($url, ".flv") == true) {
		$type = $url;
		$metareferer = "origin";
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
	$fh = get_url("https://cache2.jhdyw.vip:8090/jhqiyi.php?url=" . $url);
	$jx = json_decode($fh, true);
	$type = $jx["url"];
	$metareferer = $jx["metareferer"];
	if ($metareferer == "") {
		$metareferer = "never";
	}
}

if (strstr($url, "http") == false) {
	$fh = get_url("http://guazitv.tv/app.php?url=" . $url);
	$jx = json_decode($fh, true);
	$type = $jx["url"];
	$metareferer = $jx["metareferer"];
	if ($metareferer == "") {
		$metareferer = "never";
	}
}

if (strstr($url, "alizy") == true) {
	$fh = get_url("https://jx.cqzyw.net:8655/analysis/index/?uid=130&token=cmryAGHKLOPQUYZ026&url=" . $url);
	$jx = json_decode($fh, true);
	$type = $jx["url"];
	$metareferer = $jx["metareferer"];
	if ($metareferer == "") {
		$metareferer = "never";
	}
}


if ($type == "") {
    $fh = get_url("http://guazitv.tv/jx/?url=" . $url);
	$jx = json_decode($fh, true);
	$type = $jx["url"];
	$metareferer = $jx["metareferer"];
	if ($metareferer == "") {
		$metareferer = "never";
	}
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <!--<meta name=viewport content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no,minimal-ui">-->
    <title>播放器</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="referrer" content="<?php echo $metareferer;?>">
    <meta name="x5-fullscreen" content="true" />
    <meta name="x5-page-mode" content="app"  /> <!-- X 全屏处理 -->
    <meta name="full-screen" content="yes" />
    <meta name="browsermode" content="application" />  <!-- UC 全屏应用模式 -->
    <meta name="apple-mobile-web-app-capable" content="yes "/> 
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" /> <!--  苹果全屏应用模式 --> 
    <style type="text/css">
      html, body {width:100%;height:100%;margin:auto;overflow: hidden;}
      body {display:flex;}
      #mse {flex:auto;padding: 0px !important;height:100% !important;}
      .xgplayer-enter-logo{
          display: none !important;
      }
    </style>
    <script type="text/javascript">
      window.addEventListener('resize',function(){document.getElementById('mse').style.height=window.innerHeight+'px';});
    </script>
  </head>
  <body>
    <div id="mse" style="padding: 0px"></div>

    <script src="js/jquery.js" charset="utf-8"></script>
    <script src="js/xgplayer.js" charset="utf-8"></script>
    <script src="js/xgplayer-hls.js" charset="utf-8"></script>
    <!--<script src="//cdn.jsdelivr.net/npm/xgplayer@1.1.4/browser/index.js" charset="utf-8"></script>-->
    <!--<script src="//cdn.jsdelivr.net/npm/xgplayer-hls.js/browser/index.js" charset="utf-8"></script>-->
    <script type="text/javascript">
      let player=new HlsJsPlayer({
        id: 'mse',
        autoplay: true,
        volume: 0.3,
        url:"<?php echo $type?>",
        playsinline: true,
        height: window.innerHeight,
        width: window.innerWidth,
        whitelist: [''],
		playbackRate: [0.5,1,1.2],
	    fluid: true,
		rotate: {
				"clockwise": false,
				"innerRotate": false
		},
		poster: "load.gif"
      });
    //   player.emit('resourceReady', [{ name: '超清', url: '//sf1-cdn-tos.huoshanstatic.com/obj/media-fe/xgplayer_doc_video/mp4/xgplayer-demo-720p.mp4' }, { name: '高清', url: '//sf1-cdn-tos.huoshanstatic.com/obj/media-fe/xgplayer_doc_video/mp4/xgplayer-demo-480p.mp4' }, { name: '标清', url: '//sf1-cdn-tos.huoshanstatic.com/obj/media-fe/xgplayer_doc_video/mp4/xgplayer-demo-360p.mp4' }]);
        $("#mse").click(function(){
            player.play();
        });
        $("#mse").trigger('click');

    </script>
  </body>
</html>
