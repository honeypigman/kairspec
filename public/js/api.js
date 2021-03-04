$(document).ready(function(){

    $("input").click(function(){
        this.select();
    });

    // Init
    //submit('list', 'GET', 'array');

    // Operation Setting
    $("#operation").on('change', function(){
        $("#resBody").empty().html('<span class="text-secondary">The data does not exist.</span>');

        var operation = $(this).val();
        $("div[id^='setForm_']").addClass('d-none');
        $("#setForm_"+operation).removeClass('d-none');
        
        // Set Uri
        var getUri = $("#"+operation+"Form [id='uri']").val();
        $("#"+operation+"Form [id='uri']").val(getUri+'/'+operation);
    });


    // 
    $("#send").on('click', function(){

        var api = $("#api").text();
        var formData = $("#form").serializeObject();

        if( api=='kairspec' ){
            var operation = $("#operation").val();
            if(!operation){
                alert('Warn> Make a choice [Operation]');
                $("#operation").focus();
                return false;
            }
            // 초기화 설정
            $('#setDatabase').remove();
            $('<input>').attr({
                type: 'hidden',
                id: 'setDatabase',
                name: 'setDatabase',
                value:operation
            }).appendTo($("#"+operation+"Form"));
            formData = $("#"+operation+"Form").serializeObject();
        }
        
        $.ajax({
            method:"POST",
            url:"/send",
            dataType : 'JSON',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:(formData),
            success : function(rs){

                var result = rs.header['resultCode'];
                var msg = rs.header['resultMsg'];
                var rows = rs.body['numOfRows'];

                if(result == '00'){

                    console.log(rs.body['items'][['item']]);

                    cnt=0;
                    resResult = "";

                    if( api=='kairspec' ){
                        $.each(rs.body['items'][['item']], function(k, v){               
                            if ( rows>1 ){
                                $.each(v, function(k, v){
                                    console.log(k);
                                    resResult+=setResForm(cnt, k, v);
                                });
                            }else{
                                resResult+=setResForm(cnt, k, v);                                                 
                            }
                            cnt++;
                        });
                    }

                    $("#resBody").empty().append(resResult);

                }else{
                    alert('Error> '+result+":"+msg);    
                    return false;
                }
            },
            error : function(error){
                alert('Error>'+error);
            }
        });

    })    
});


var setResForm = function(no, k, v){
    var result = "<div class=\"accordion\" id=\"accordionExample\"></div><div class=\"accordion-item\">";    
    if( k =='dataTime' ){
        result+="<h2 class=\"accordion-header\" id=\"heading"+no+"\"><button class=\"accordion-button\" type=\"button\" data-bs-toggle=\"collapse\" data-bs-target=\"#collapse"+no+"\" aria-expanded=\"false\" aria-controls=\"collapse"+no+"\">";
        result+=v;
        result+="</button></h2>";
    }else{
        result+="<div id=\"collapse"+no+"\" class=\"accordion-collapse collapse show\" aria-labelledby=\"heading"+no+"\" data-bs-parent=\"#accordionExample\">";
            result+="<div class=\"accordion-body\">";
                result+="<div class=\"row\" style=\"margin:-20px;\">";
                    result+="<label class=\"col-sm-2 col-form-label\">"+k+"</label>";
                    result+="<div class=\"col-sm-10\">";
                        result+="<input type=\"text\" class=\"form-control-plaintext text-secondary\" value=\""+v+"\" disabled>";
                    result+="</div>";
                result+="</div>";
            result+="</div>";
        result+="</div>";
    }
    result+="</div></div>";

    return result;
}

/**
 * 
 * @param {*} action : list / show / store / update / destroy
 * @param {*} method  : get / post / delete / put
 */
var submit = function(action, method='POST', $type='json'){
    var formData = $("#form").serializeObject();
    $.ajax({
        method:method,
        url:'/api/'+action+'/'+$type,
        dataType : 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data:(formData),
        success : function(rs){

            if( $type=='json' ){
                var jsonStringify = JSON.stringify(rs);
                var list = JSON.parse(jsonStringify);
            }
            apiList="";
            $.each(rs, function(){
                apiList+="<tr>";
                    apiList+="<td>"+this._id+"</td>";
                    apiList+="<td>"+this.reqdate+"</td>";
                    apiList+="<td>"+this.updated_at+"</td>";
                apiList+="</tr>";
            });
            $("#apiListBody").empty().append(apiList);

        },
        error : function(error){
            alert('Error>'+error);
        }
    });
} 