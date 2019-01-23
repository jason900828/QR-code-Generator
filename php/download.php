<?php

header("Content-Type:text/html; charset=utf-8");
set_time_limit(0);

$name='images/';
$folder='./'.$name.'/'.$_GET['timenamefolder'];
$zip_file_name='image.zip';

$download_file=True;
class FixZipArchive extends ZipArchive{
    
    public function addDir($location,$name){
    	$this -> addEmptyDir($name);//在壓縮檔中添加一個空目錄，以$name命名
    	$this -> addDirDo($location,$name);
    }
    private function addDirDo($location,$name){
        $name .= '/';
        $location .= '/';
        //讀所有在資料夾的檔案
        $dir = opendir($location);
        while($file = readdir($dir)){
            if($file == '.'|| $file == '..')continue;
            //在這裡，如果讀出來的是DIR則用addDir，反之則用addFile
            $do = (filetype( $location.$file) == 'dir')? 'addDir':'addFile';
            $this -> $do($location.$file,$name.$file);
        } 

    }
}

$za = new FixZipArchive;//創建物件來執行
$res = $za -> open($zip_file_name,ZipArchive::CREATE);
if($res===True){
	$za -> addDir($folder,basename($folder));
	$za -> close();
}
else{echo "Could not create a zip archive";}

if ($download_file) {
	ob_get_clean();
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private", false);
    header("Content-Type: application/zip");
    header("Content-Disposition: attachment; filename=" . basename($zip_file_name) . ";" );
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: " . filesize($zip_file_name));
    readfile($zip_file_name);
}
if(file_exists($zip_file_name)){
	unlink($zip_file_name);
}
else{
	return;
}

?>
