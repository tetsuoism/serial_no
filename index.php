<?php
  ini_set('memory_limit', '2048M');
  
  //初期値
  //作成するシリアルコード数
  $serial_number = 100000;
  //シリアルコードを一部固定することができる
  $cp_code1 = "9";
  $cp_code2 = "8";
  //本番反映用ファイル名
  $filename = "honban_db_file.txt";
  //提出用ファイル名
  $split_filename = "split_file_";
  //ファイルの区切り
  $split = 750000;

  //作成シリアルコードを一時的に格納
  $number = array();
  //時間計測
  $time_start = microtime(true);
  
  //乱数生成
  echo "乱数生成開始"."\n";
  $time = microtime(true) - $time_start;
  echo "{$time} s\n";
  
  while (count($number) <= $serial_number) {
    //$serial_number1 = mt_rand(0,99999999);
    //$serial_number2 = mt_rand(0,99999999);
    $serial_number1 = random_int(0,99999999);
    $serial_number2 = random_int(0,99999999);
    
    $serial =  sprintf("%02d",$serial_number1 / 100) . $cp_code1 . sprintf("%06d",$serial_number1 % 100) . '-' . sprintf("%02d",$serial_number2 / 100) . $cp_code2 . sprintf("%06d",$serial_number2 % 100);
    //$serial =  sprintf("%02d",random_int(0,999999)) . $cp_code1 . sprintf("%06d",random_int(0,99)) . '-' . sprintf("%02d",random_int(0,999999)) . $cp_code2 . sprintf("%06d",random_int(0,99)) . "\n";
    $number[$serial] = "";
  }
  echo "乱数生成終了"."\n";
  $time = microtime(true) - $time_start;
  echo "{$time} s\n";
  
  echo "本番ファイル書き出し"."\n";
  $time = microtime(true) - $time_start;
  echo "{$time} s\n";
  
  //本番ファイル書き出し
  file_put_contents($filename, implode("\n",array_keys($number)), FILE_APPEND);
  
  echo "本番ファイル書き出し終了"."\n";
  $time = microtime(true) - $time_start;
  echo "{$time} s\n";
  
  
  echo "分割ファイル書き出し開始"."\n";
  $time = microtime(true) - $time_start;
  echo "{$time} s\n";
  
  //連番
  $n = 0;
  //提出用ファイル書き出し
  foreach (array_chunk($number, $split, true) as $k => $v) {
    echo "分割ファイル書き出し中"."\n";
    $time = microtime(true) - $time_start;
    echo "{$time} s\n";
    $n++;
    $filename = $split_filename . $n . ".txt";
    file_put_contents($filename, implode("\n",array_keys($v))."\n", FILE_APPEND);

    //時間計測
    echo "分割ファイル書き出し完了"."\n";
    $time = microtime(true) - $time_start;
    echo "{$time} s\n";
    
    $k = array();
  }
  //最終時間
  echo "処理完了"."\n";
  $time = microtime(true) - $time_start;
  echo "{$time} s\n";
  
  $number = array();

?>
