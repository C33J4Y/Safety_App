$(document).ready(function () {

    // updating the view with notifications using ajax
    function load_unseen_notification(view = '', options) {

        $.ajax({
            url: "emergency.php",
            type: "POST",
            data: { view: view, options: options },
            dataType: "json",
            success: function (data) {

                if (data.act == 'Y') {

                    console.log('ajax call was success');
                    
                    if(data.cat == '0' || data.cat == '1' || data.cat == '2'){
                        $('#banner').html(data.alert);
                        console.log(data.alert);
                    }else if(data.cat == '3'|| data.cat == '4' || data.cat =='5'){
                        $('.dropdown-menu').html(data.alert);
                        // if (data.count > 0) {
                        //     $('.count').html(data.count);
                        // }

                    }else if (data.cat == '6'){
                        console.log(data.comment)

                        // $('.dropdown-menu').append(
                            
                        //     '<p class="dropdown-itme">'+data.comment+'</p>'
                        // );
                    }
                   

                } else {
                    $('#banner').empty();

                }


            }
        });
    }




    $('#cancel').click(function(){
        window.history.back();
    });

    $('#submitEmergency').click(function () {

        var radioValue = $('#EmerForm input:checked').val();
        if (radioValue == 'option0') {
            load_unseen_notification('YES', '0');
        } else if (radioValue == 'option1') {
            load_unseen_notification('YES', '1');
        } else if (radioValue == 'option2') {
            load_unseen_notification('YES', '2');
        } else if (radioValue == 'option3') {
            load_unseen_notification('YES', '3');
        } else if (radioValue == 'option4') {
            load_unseen_notification('YES', '4');
        } else if (radioValue == 'option5') {
            load_unseen_notification('YES', '5');
        } 
        // sends the user back to previous page after launch
        window.history.back();
        
    });


    $('#dismissButton').click(function () {
        console.log('dismiss');
        load_unseen_notification('NO', '6');
        window.history.back();
    });

    // var shooter = 8200;
    // var fire = 9700;
    // var tornado = 9000;
    // var timedelay = 5000;

    setInterval(function () {
        load_unseen_notification();;
        console.log('setInterval again');
    }, 5000);

});


