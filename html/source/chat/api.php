<?php

// header
$corsurl = 'http://'.$_SERVER['HTTP_HOST'].':8088';
header('Access-Control-Allow-Origin: '.$corsurl);



if ($_GET['mode'] == "write")
{
  // -------------------------------
  // ファイルの先頭に文字列を追加する

  function f_add_first_row($str, $file_name) {

  // 事前にファイルの内容を取得
  $contents = file_get_contents($file_name);

  // 文字列を先頭に追加
  $contents = $str . "\n" . $contents;

  // 上書き 書き込み 
  $re = file_put_contents($file_name, $contents);

  }
  // 使用例
  $str = urldecode($_GET['logtext']);
  $file_name = $_GET['logname'].'.txt';
  f_add_first_row($str, $file_name);

  print '[PHP] Wrote log: '.urldecode($_GET['logtext']);
}
if ($_GET['mode'] == "read")
{
  function file_get($path, $offset = -1, $maxLength = -1)
 {
    if (!$fp = fopen($path, 'rb')) { return false; }

    flock($fp, LOCK_SH);
    $data = stream_get_contents($fp, $maxLength, $offset);
    flock($fp, LOCK_UN);
    fclose($fp);

    return $data;
 }
  echo file_get($_GET['logname'].'.txt');
}
?>
