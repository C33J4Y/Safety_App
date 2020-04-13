$(document).ready(function () {

    // updating the view with notifications using ajax
    function load_unseen_notification(view = '',options) {

        $ .ajax({
            url: "emergency.php",
            type: "POST",
            data:{view:view,options:options},
            dataType: "json",
            success: function (data) {
                
                console.log(data.cat);
                console.log(data.act);
                console.log(data.alert);

                if(data.act == 'Y'){
                    console.log('ajax call was success');
                    
                    if(data.cat == '0' || data.cat == '1' || data.cat == '2'){
                        $('#banner').html(data.alert);
                        console.log(data.alert);
                    }else if(data.cat == '3'|| data.cat == '4' || data.cat =='5'){

                        console.log(data.alert);
                    }else if (data.cat == '6'){
                        console.log(data.comment)

                        // $('.dropdown-menu').append(
                            
                        //     '<p class="dropdown-itme">'+data.comment+'</p>'
                        // );
                    }
                   

                }else{
                    $('#banner').empty();
                   
                }
                
               
            }
        });
    }

   
    load_unseen_notification();

    // $('#submitModal1').click(function(){
    //     $('#submitModal1').attr('disabled',true);
    //     $('#dissmissmodal').attr('disabled',true);

    // });


    $('#submitModal1').click(function(){

        var radioValue = $('#EmergencyModal input:checked').val();
        console.log(radioValue);
        if(radioValue == 'option0'){
            load_unseen_notification('YES','0');
        }else if(radioValue == 'option1'){
            load_unseen_notification('YES','1');
        }else if(radioValue == 'option2'){
            load_unseen_notification('YES','2');
        }else if(radioValue == 'option3'){
            load_unseen_notification('YES','3');
        }else if(radioValue == 'option4'){
            load_unseen_notification('YES','4');
        }else if(radioValue == 'option5'){
            //other option
            
            var comment = $.trim($('#otherTextArea').val());
            console.log(comment);
            if (comment != '') {
                // load_unseen_notification('YES','6',comment);
            } else {
                alert('Need to fill out Text Area');
            }
        }

        // load_unseen_notification('YES');
    });



    $('#emergency').click(function(){
       
        $.get("includes/getSessionInfo.php", function (data) {
            console.log(data.name);
            console.log(data.level);
            if(data.level == '1'){
                $('#dismissModal').show();
            }else{
                $('#dismissModal').hide();
            }

        },'json');
    });


    $('#dismissModal').click(function () {
        console.log('dismiss');
        // $('.count').html('');
        load_unseen_notification('NO');
    });

    // var shooter = 8200;
    // var fire = 9700;
    // var tornado = 9000;
    // var timedelay = 5000;
    
    setInterval(function () {
        load_unseen_notification();;
        console.log('setInterval again');
    },5000);

});


