 <?php


$dir=dirname('__FILE__'); //找到當前腳本所在路徑
require_once($dir."/phpExcel/PHPExcel.php"); //引入文檔
$filename = $_GET['filename'];
$timenamefolder = $_GET['timenamefolder'];
$reader = PHPExcel_IOFactory::load('input/'.$timenamefolder.'/'.$filename);

$sheet=$reader->getActiveSheet();
$url_array = array();
$first_title = $sheet->getCell('A1');
foreach ($sheet->getRowIterator() as $row) {
	$cellIterator = $row->getCellIterator(); 
	$cellIterator->setIterateOnlyExistingCells(false);
	// This loops all cells,
	// even if it is not set.
	// By default, only cells 
	// that are set will be
    // iterated. 

	foreach ($cellIterator as $cell) { 
		$url = $cell->getValue(); 
	}
	if($first_title!=$url){
		array_push($url_array,$url);
	}
	
}
include_once($dir."/qr_img2.php");
for($i=0;$i<count($url_array);$i++) {
    callQRcode($url_array[$i],'M','4',$i,0,$timenamefolder);
}



$objPHPExcel = new PHPExcel();  //實例化PHPExcel類，等同於在桌面上創建一個ecxel表格
$objPHPExcel->getActiveSheet()->getDefaultColumnDimension() ->setWidth(30);

$objSheet = $objPHPExcel->getActiveSheet();//獲取當前活動sheet的操作對象
$objSheet->setTitle('url_qrcode'); //給當前的活動sheet設置名稱
//填充數據
$objSheet->setCellValue("A1",'網址')->setCellValue("B1",'QR code'); //給當前活動sheet填充數據
for($i=0;$i<count($url_array);$i++) {
	$cell_number = $i+2;
    $objSheet->setCellValue("A".$cell_number,$url_array[$i]); 
    $img=new PHPExcel_Worksheet_Drawing();
	$img->setPath('./images/'.$timenamefolder.'/qrcode'.$i.'.png');//写入图片路径
	$img->setHeight(150);//写入图片高度
	$img->setWidth(150);//写入图片宽度
	$img->setOffsetX(1);//写入图片在指定格中的X坐标值
	$img->setOffsetY(1);//写入图片在指定格中的Y坐标值
	$img->setRotation(1);//设置旋转角度
	$img->getShadow()->setVisible(true);//
	$img->getShadow()->setDirection(50);//
	$img->setCoordinates('B'.$cell_number);//设置图片所在表格位置
	$img->setWorksheet($objPHPExcel->getActiveSheet());//把图片写到当前的表格中
    $objPHPExcel->getActiveSheet()->getRowDimension($cell_number) ->setRowHeight(150);
}   
$objWrite=PHPExcel_IOFactory::createWriter($objPHPExcel,"Excel2007");//按照指定格式生成excel文檔
if (!file_exists('./output/'.$timenamefolder.'/')){
    mkdir('./output/'.$timenamefolder.'/');
  }
$objWrite->save("output/".$timenamefolder."/".$filename);//保存到當前文檔夾下

echo '<br><br><button type="button" class="btn btn-info" onclick="window.location.href=\'./php/output/'.$timenamefolder.'/'.$filename.'\'">下載Excel</button>';

echo '&nbsp;<button type="button" class="btn btn-info" onclick="window.location.href=\'./php/download.php?timenamefolder='.$timenamefolder.'\'">下載圖檔</button>';
?>
