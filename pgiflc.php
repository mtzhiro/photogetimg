flc

<?php
/*
   photogetimg
     pgiflc.php  -  batch photo downloader via flickr (pgiflc)
     Ver.1.0 (UTF-8)
     License: GNU General Public License v2 or later
     License URI: http://www.gnu.org/licenses/gpl-2.0.html
     
     いや、Flickerの場合はAPIで便利なのがあるから・・となった・・
     https://www.flickr.com/services/api/explore/flickr.photosets.getPhotos
     ので・・ここの「Photoset ID」・・例えば「72157700439012015 - YokohamaImmigrationMuseum」などを気軽に扱えるようにしたいな・・
     
 */
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="ja">
<head>
<title>pgiflc - batch photo downloader via flickr (pgiflc.php)</title>
</head>
<body >
<h1>pgiflc</h1>
<div>
FlickrのURLを入れると、そのURLに紐づく画像のURLを表示するPHPスクリプト<br />
/get Flickr images related some URL
<form action="/photogetimage/pgiflc.php" method="get" name="fpgiflc" id="ifpgiflc">
  <input type="text" name="flcurl" value="" size="40" /><input type="submit" name="flcsub" value="get" /><br />
</form>

<?php
  // FlickrのURLをフォームから取得/get Flickr URL from form
  if (isset($_REQUEST['flcurl']) ) {
    $url = $_REQUEST['flcurl'];
  } else {
    // URL指定がない場合仮で/no URL? temporary set this URL
    $url = 'https://www.flickr.com/';
  }
  
  // HTMLソースの取得/get HTML source-text
  $str = file_get_contents($url);
  
  echo "URL= <a href=\"$url\">$url</a> <br />\n";
  //以下、画像を取得/below, get images
  
  //1枚目の画像を取得/get the first image
  $fa = array();
  // Flickr HTMLから1枚目の画像を見つける正規表現/regular expression to find the first image from Flickr HTML
  preg_match("/config_width\":750.*?(https:\/\/.*?\.jpg)/", $str, $fa);
  
  //いちおう画像を表示/display iamge
  echo "f:<img src=\"" . $fa[1] . "\" alt=\"\" width=\"200\" />\n";
  
  //2枚目以降の画像があれば取得（Flickrの仕様としては、画像(動画)は1度に合計10枚まで）/get images after first (maximu 10 images from Flickr's spec.)
  $oa = array();
  // Flickr HTMLから2枚目以降の画像を見つける正規表現/regular expression to find images after the first from Flikr HTML
  preg_match_all("/is_video.*?(https:\/\/.*?\.jpg)/", $str, $oa); 
  
  //いちおう画像を表示/display images
  $uc = count($oa[1]);
  for ($i = 1; $i < $uc; $i++) {
    echo "$i<img src=\"" . $oa[1][$i] . "\" alt=\"\" width=\"200\" />\n";
  }
?>
</div>
</body>
</html>
