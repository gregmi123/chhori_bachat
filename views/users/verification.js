$(document).ready(function(){
    $('#print-div3').click(function(){ 
        // alert('hello');
     var municipal_id =  $('#municipal_id1').val();
     $('#btn_submit1').click(function(){
        var typed_pin = $('#typed_pin1').val();
        if(municipal_id == typed_pin){
            initial();
        }else{
            alert("Please Enter Valid PIN No.");
        }
       
     });
    });
});
