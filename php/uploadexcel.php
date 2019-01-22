<?php

function uploadfile($file_id,$uploaddir,$file_name){

  if (!file_exists($uploaddir)){
    mkdir($uploaddir);
  }
  if ($_FILES[$file_id]['error'] === UPLOAD_ERR_OK){

    # 檢查檔案是否已經存在
    if (file_exists($uploaddir. $file_name)){
      echo '檔案已覆蓋。<br/>';
      unlink($uploaddir. $file_name);
    } 
    $file = $_FILES[$file_id]['tmp_name'];
    $dest = $uploaddir . $file_name;
    # 將檔案移至指定位置
    move_uploaded_file($file, $dest);
    
  } else {
   echo '錯誤代碼：' . $_FILES[$file_id]['error'] . '未上傳檔案或字典<br/>';

  }
}
$timenamefolder=date("YmdHis").rand(0,100);

if (!file_exists('./input/')){
    mkdir('./input/');
  }
if (!file_exists('./output/')){
    mkdir('./output/');
  }
uploadfile('excelFile','./input/'.$timenamefolder.'/',$_FILES['excelFile']['name']);
$filename = $_FILES['excelFile']['name'];
header('location:./excel.php?timenamefolder='.$timenamefolder.'&filename='.$filename);

?>