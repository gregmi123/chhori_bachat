$(document).ready(function(){
    $('#print-div').click(function(){ 
     var municipal_id =  $('#municipal_id').val();
     var month =  $('#month').val();
     var multi_month =  $('#multi_month').val();
     var year =  $('#year').val();
     $('#btn_submit').click(function(){
        var typed_pin = $('#typed_pin').val();
        if(municipal_id == typed_pin){
            save(month,year,multi_month);
        }else{
            alert("Please Enter Valid PIN No.");
        }
       
     });
    });
});

$(document).ready(function(){
    $('#print-div1').click(function(){ 
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
