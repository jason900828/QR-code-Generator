$(document).ready(function (e){
    var d ;
    $("#excelForm").on('submit',(function(e){
        e.preventDefault();
        $.ajax({
            url: "./php/uploadexcel.php",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(data){
                d = data;
                $("#outputexcel").html(d);
            },
            
            error: function(){}             
        });
    }));
    $(document).ajaxStop(function(){ 
    });
    
});



