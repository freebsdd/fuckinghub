var memory = { 'load_more' : {'limit' : 0} };

$(document).on('click touch', '.prod_act', function(e){
    e.stopPropagation();
    e.preventDefault();

    var id = this, timeout = 60000;
    var add_opt_v2 = {
        'opt' : {}
    };

    var fields_form = '';
    if($(id).attr("data-form-name") != undefined){
        fields_form = $('form[name=' + $(id).attr('data-form-name') + ']').serializeArray();
    }

    if($(id).attr("data-fields") != undefined){
        var fields = $(id).attr("data-fields").split("##");
        $.each(fields,function(index, field) {
            data = field.split("=");
            add_opt_v2['opt'][data[0]] = data[1];
        });
    }

    if(add_opt_v2['opt']['action'] == 'load_more'){
        console.log('............');
        add_opt_v2['opt']['limit'] = memory['load_more']['limit'];
    }

    xhr_din_c = $.ajax({
        type: "POST",
        url: "/data/script",
        async: false,
        data: { "act": 1, "add_opt_v2": add_opt_v2, "els": fields_form, "url": window.location.href },
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

            if(farr['prod_act'] != undefined) prod_act(farr['prod_act']);

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

    return false;
});

var fps_timeout = undefined;
function prod_act(arr_opt){
    // console.log('#def prod_act: ', arr_opt);
    var action = ((arr_opt['action'] != undefined) ? arr_opt['action'] : '' );
    if(action == 'load_more'){
        memory['load_more']['limit'] = arr_opt['limit'];

        // console.log('load_more....................', memory);

        $('.prods').append(arr_opt['content']);

        fps_timeout = setTimeout( function() {
            $('.blush').removeClass('blush');
        } , 500);

    }
    else{
        alert('js::prod_proc - unknown action');
    }
}