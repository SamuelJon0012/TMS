


    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/5ffc8653c31c9117cb6d8992/1erp6pdd8';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
    })();

<!--End of Tawk.to Script-->



function preloader_on() {

    $('#preloader').show();

}
function preloader_off() {

    $('#preloader').hide();

}

function decorateAjax(xhr){

    xhr.fail(function(xhr){
        if (xhr.status == 401){
            document.location = '/login';
            return;
        }
        var txt = '('+xhr.status+') ';
        if ((xhr.responseJSON) && (xhr.responseJSON.message))
            txt += xhr.responseJSON.message;
        else
            txt += xhr.statusText;
        alert(txt);
    });

    xhr.always(function(){
        preloader_off();
    });

    return xhr;
}

function checkAjaxResponse(data){
    if (typeof data == 'string'){
        try{
            data = JSON.parse(data);
        }catch(e){
            return true;
        }
    }

    if (typeof data != 'object')
        return true;
    if ((data.success != undefined) && (!data.success)){

        if (typeof data.message == 'string'){
            try{
                data = JSON.parse(data.message);
            }catch(e){
                return true;
            }
        }


        alert(data.message || 'An error occurred');
        return false;
    }
    return true;
}

</script>
