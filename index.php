<!DOCTYPE html>
<html>
<head>
	<title>QRcodeGenerator</title>
    <meta http-equiv="Content-Type" content="text/html; charset=big5">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="ajax.js" ></script>
	<style type="text/css">
        html, body {
        /* 設定body高度為100% 拉到視窗可視的大小 */
            height: 100%;
            
        }
        #id_wrapper {
            /* 設定高度最小為100%, 如果內容區塊很多, 可以長大 */
            min-height: 100%;
        }
        #id_header {
            /* 設定header的高度 */
            height: 40px;
        }

        #id_content {
            padding: 60px 20%;
            padding-bottom: 50px;
        }
        
        #id_footer {
            height: 50px;
            margin-top: -50px;
            background-color: #333;
            color:#eee;
            text-align: center;
            font-size: 16px;
             
        }
	    div{
	    	text-align:center;
	    }
        #id_content::before{
            content:'';
            display: inline-block;
            height: 100%;
            width: 0;
            vertical-align: middle;
        }
        
        #inputurl{
        	background-color: white;
        	width:50%;
        	height:500px;
            padding:20px;
            border-style:solid;
            position: relative;
            display: inline-block;
            margin: 1em;
            vertical-align: middle;
        }
        #outputimg{
        	background-color: white;
        	width:33%;
        	height:500px;
            padding:20px;
            border-style:solid;
            position: relative;
            display: inline-block;
            margin: 1em;
            vertical-align: middle;
        }
        a:hover{
            text-decoration:none; 
        }
	</style>
</head>
<body style="background-color: 	#00DDDD; ">

    <div id='id_wrapper'>

        <div id='id_header'>
            <nav class="navbar navbar-dark bg-dark">
                <a class="navbar-brand mb-0 h1" href="./index.php">QR code Generator</a>
                
            </nav> 
        </div>
        
        
        <div id='id_content'>

            <h2 style="color:white;font-weight:bold;text-align: left;">情緒辨識影片上傳介面</h2>
            <div id='inputurl'>
                <div class="btn-group" role="group" aria-label="Basic example" style="text-align:left;width: 100%">
                  <button type="button" class="btn btn-outline-info" onclick="SingleInput();">單個輸入</button>
                  <button type="button" class="btn btn-outline-info"onclick="MultipleInput();">多個輸入</button>
                </div>
                <br>
                <br>
                <div id='single_input'>
                    <h3 style="font-weight:bold;">在此輸入網址</h3>
                    <br>
                    <input type="text" name="d" id ='url'/ class="form-control" placeholder="http://example.com">
                    <br>
                    <button type="button" class="btn btn-primary"onclick="doQRcode()">Get QR code</button>
                </div>
                <div id='multiple_input' style='display: none;'>
                    <h3 style="font-weight:bold;">在此上傳EXCEL檔</h3>
                    <p style="color: red;">*Excel中只能有一個網址欄位 &nbsp;&nbsp;<a href="./demo.xlsx" download>Excel範例</a></p>
                    
                    <br>
                    <form id='excelForm'>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="excelFile" name='excelFile' onchange="CheckFile();">
                            <label class="custom-file-label" for="excelFile" id='excellabel'>選擇檔案</label>
                        </div>
                        <br>
                        <br>
                        <button type="submit" class="btn btn-primary">Get QR code</button>    
                    </form>
                    
                </div>
            </div>

            <div id='outputimg'>
                <h3>QR code</h3>
                <p id='urlname'></p>

                <a  id='qrcode_a' href="" download><img src="" id="qrcode" alt="" /></a>

                <div id='outputexcel'>
                    
                </div>
            </div>
                
        </div>
        
        
    </div>
	<footer id="id_footer" >
        <p style="color:white; line-height: 50px; margin: 0;">QR code Made By QRcode Perl CGI & PHP scripts ver. 0.50</p>
    </footer>

<script type="text/javascript">
	function doQRcode(){

        
        document.getElementById("urlname").style.display = ("none");
		var qr_url = document.getElementById('url').value;
        var qr_crawler = $.get( "./php/callcrawler.php?url="+qr_url, function( data ) {
            document.getElementById("urlname").style.display = ("");
            $( "#urlname" ).html( data );
            
        });
        var qr_img = document.getElementById('qrcode');
        var qr_data = "./php/qr_img.php?d="+qr_url+"&e=M&s=4"
        var qr_a = document.getElementById('qrcode_a');
        qr_img.src = qr_data;
        qr_a.href = qr_data;
	}
    function SingleInput(){
        document.getElementById('single_input').style.display = ("");
        document.getElementById('qrcode').style.display = ("");
        document.getElementById('multiple_input').style.display = ("none");
        document.getElementById('outputexcel').style.display = ("none");
    }
    function MultipleInput(){
        document.getElementById('single_input').style.display = ("none");
        document.getElementById('qrcode').style.display = ("none");
        document.getElementById('multiple_input').style.display = ("");
        document.getElementById('outputexcel').style.display = ("");
    }
    function CheckFile(){
        var FilePath = document.getElementById('excelFile').value;
        if(FilePath){
            var File_Extension = FilePath.slice((FilePath.lastIndexOf(".") - 1 >>> 0) + 2);
            if (File_Extension!='xlsx'){
                alert('輸入檔案格式錯誤');
                document.getElementById('excelFile').value = '';
            }
            else{
                var startIndex = (FilePath.indexOf('\\') >= 0 ? FilePath.lastIndexOf('\\') : FilePath.lastIndexOf('/'));
                var filename = FilePath.substring(startIndex+1);
                document.getElementById('excellabel').innerText = filename;
            }    
        }
        else{
            document.getElementById('excellabel').innerText = '選擇檔案';
        }
        
    }
</script>
</body>
</html>