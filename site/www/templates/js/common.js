function func_pub_sub(f_act, id){
    var f_id = id;
    var fields_form = '';
    if($(id).attr("data-form-name") != undefined){
        fields_form = $('form[name=' + $(id).attr('data-form-name') + ']').serializeArray();
    }

    var add_opt_v2 = {
        'opt' : {}
    };
    if($(id).attr("data-fields") != undefined){
        var fields = $(id).attr("data-fields").split("##");
        $.each(fields,function(index, field) {
            data = field.split("=");
            add_opt_v2['opt'][data[0]] = data[1];
        });
    }

    console.log('add_opt_v2: ', add_opt_v2);

    $('body').prepend('<div id="frm_wait" class="sq_msg sq_up" style="opacity: 0.9; background: rgba(0,0,0,.1); display: block;"><div class="sq_msg_form fw">Подождите...</div></div>');

    var timeout = 60000; //def
    if($(id).attr("data-timeout") != undefined){
        timeout = $(id).attr("data-timeout");
    }

    var sr = 'script';
    if($(id).attr("data-s-name") != undefined){
        sr = $(id).attr("data-s-name");
    }
    var async = true;
    if($(id).attr("data-async") != undefined){
        async = $(id).attr("data-async");
    }
    xhr_din_c = $.ajax({
        type: "POST",
        url: "/data/script",
        async: async,
        data: { "act": f_act, "add_opt_v2": add_opt_v2, "els": fields_form, "url": window.location.href },
        beforeSend: function(jqXHR, settings){

        },
        success: function(data){
            //$(farr['div_id']).remove();
            console.log(data);
            //var farr = $.parseJSON(data);

            var farr;
            try{
                farr = $.parseJSON(data);
            }catch(e){
                alert(e.name);
                if($('div#frm_wait').length > 0) $('div#frm_wait').remove();

                return false;
            }finally{
                //alert("finished");
            }

            func_pub_sub_res(farr, f_act, id);

            if($('div#frm_wait').length > 0) $('div#frm_wait').remove();
        },
        error: function(x, t, e){
            //$("#status2").html(data);
            //***alert('error');
            // console.log( 'error...' );
            console.error( x, t, e );
            if( t === 'timeout') {
                // Произошел тайм-аут
                alert('Запрос выполнялся дольше обычного, попробуйте ещё раз');
                if($('div#frm_wait').length > 0) $('div#frm_wait').remove();
            } else {
                console.log('Error: ' + e);
            }
        },
        complete: function(data){
            //$("#status2").html(data);
            //***alert('complete');
        },
        // timeout: 10000
        timeout: timeout
    });
}

function func_pub_sub_short(add_opt_v2, fields_form, id, fact) {

    if(false){
        add_opt_v2 = {
            'opt' : {
                'pl' : 'calls',
                'action' : sort_by,    //'tel',
                'data' : source
            }
        };
        func_pub_sub_short(add_opt_v2, fields_form, this, 4);
    }

    if(add_opt_v2['opt']['no_wait'] == undefined){
        $('body').prepend('<div id="frm_wait" class="sq_msg sq_up" style="opacity: 0.9; background: rgba(0,0,0,.1); display: block;"><div class="animsition-loading"></div></div>');
    }
    var sync = true;
    if(add_opt_v2['opt']['async'] != undefined){
        sync = add_opt_v2['opt']['async'];
    }

    var processing_com_func = true;
    if(add_opt_v2['opt']['processing_com_func'] != undefined){
        processing_com_func = add_opt_v2['opt']['processing_com_func'];
    }

    var has_return = false, val_return = undefined;
    if(add_opt_v2['opt']['return'] != undefined){
        has_return = true;
    }
    if(fact == undefined) fact = 1;
    var farr = undefined;
    xhr_pub_sub_short = $.ajax({
        type: "POST",
        url: "/data/script",
        async: sync,
        data: { "act": fact, "add_opt_v2": add_opt_v2, "els": fields_form, "url": window.location.href },
        success: function(data){
            console.log(data);
            //var farr = $.parseJSON(data);
            try{
                farr = $.parseJSON(data);
            }catch(e){
                alert(e.name);
                if($('div#frm_wait').length > 0) $('div#frm_wait').remove();
                return [false, 'function return is error: ' + e.name];
            }finally{
                //alert("finished");
            }

            if(processing_com_func) func_pub_sub_res(farr, 10, id);
            if(has_return){
                //console.log('return: ', farr);
                if(farr[0] == true) return farr;
                else swal({   title: "Внимание!",   text: farr[1], html: true,  type: "error",   confirmButtonText: "Закрыть" });
            }
        },
        error: function(data){
            //$("#status2").html(data);
            //***alert('error');
        },
        complete: function(data){
            //$("#status2").html(data);
            //***alert('complete');
        }
    });

    if($('div#frm_wait') != undefined) $('div#frm_wait').remove();

    if(!sync || has_return){
        if(farr == undefined || farr[0] == undefined){
            console.error('[0] - undefined, farr: ', farr);
            alert('Пришёл пустой ответ от сервера');
            return [false, 'Пришёл пустой ответ от сервера'];
        }
        else if(farr[0] == true) return farr;
        else{
            alert(farr[1]);
            return farr;
        }
    }
    else{
        return farr;
    }
}

function func_pub_sub_res(farr, fact, id){

    console.log('func_pub_sub_res:: ', farr);

    try{
        var t = farr[0];
    }
    catch(e){
        //alert(e.name);
        alert('Пришёл пустой ответ от сервера');
        if($('div#frm_wait').length > 0) $('div#frm_wait').remove();

        return false;
    }
    finally{
        //alert("finished");
    }

    if(farr[0] == true){
        if(farr['prod_act']) prod_act(farr);
    }
    else{
        alert(farr[1]);
    }

}


var timeinterval = 0;
$(document).on('click', '.btn_frm, .btn_frm2', function(e){
    e.stopPropagation();
    e.preventDefault();
    var act = 1;
    if($(this).hasClass('btn_frm2')) act = 2;
    func_pub_sub(act, this);
    return false;
});
