$(document).ready(function(){
    $('#delete').click(function(){ 
     var municipal_id =  $('#municipal_id').val();
     $('#btn_submit').click(function(){
        var typed_pin = $('#typed_pin').val();
        if(municipal_id == typed_pin){
            deleteChhori();
        }else{
            alert("Please Enter Valid PIN No.");
        }
     });
    });
});

$(document).ready(function(){
    $('#delete-permanent').click(function(){ 
     var municipal_id =  $('#municipal_id').val();
     $('#btn_submit1').click(function(){
        var typed_pin = $('#typed_pin').val();
        if(typed_pin== "1339"){
            deleteChhori();
        }else{
            alert("Please Enter Valid PIN No.");
        }
     });
    });
});

$(document).ready(function(){
    $('#restore').click(function(){ 
     var municipal_id =  $('#municipal_id').val();
     $('#btn_submit1').click(function(){
        var typed_pin = $('#typed_pin').val();
        if(municipal_id == typed_pin){
            myFunction();
        }else{
            alert("Please Enter Valid PIN No.");
        }
     });
    });
});