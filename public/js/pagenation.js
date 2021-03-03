 /**
 * Board Custom | @honeypigman
 * 
 */
$(document).ready(function() {    

    //Page Link
    $("#pagination").on('click', '.setPage', function () {

        $("#action").val('List');
        $("#current_page").val($(this).text());
        
        var formData = $("#boardFrm").serializeObject();
        $.ajax({
            method:"POST",
            url:"/admin/board/action/"+tbl,
            dataType : 'JSON',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:(formData),
            success : function(rs){

                if(rs.result){
                    $("#boardBody").empty().append(rs.result_list);
                    setPagenation(rs.result_page);
                }
            },
            error : function(error){
                alert('Error>'+error);
            }
        })
    })

    // Set Pagenation Next / Pre
    $("#pagination").on('click', '.movePage', function () {
        var setPage = 1;
        var setPageAct = $(this).text();
        var setTotalPage = $("#total_page").val();
        if( setPageAct == '>' ){ 
            setPage = parseInt($(".page-link").last().attr('aria-label'));
            if(setPage>setTotalPage){
                return false;
            }
        }else{
            setPage = parseInt($(".page-link").first().attr('aria-label'));
            if(setPage<1){
                return false;
            }
        }

        $("#current_page").val(setPage);
        
        // Custom
        submit('List', 'Y');  
    }) 

    // Set Pagenation
    var setPagenation = function(page){        
        var perPage = page['limit'];
        var setCurrentPage = (!page['current_page']?1:$("#current_page").val());
        var setPageGrp = Math.ceil(setCurrentPage/perPage);
        var setEPageNum = setPageGrp*perPage;
        var setSpageNum = (setEPageNum-perPage)+1;
        var setPageNation = "<li class='page-item movePage'><a class='page-link' href='#' aria-label='"+(setSpageNum-1)+"'><span aria-hidden='true'><</span></a></li>";
        for(setSpageNum; setSpageNum<=(page['totalPage']>setEPageNum?setEPageNum:page['totalPage']); setSpageNum++){
            var addClass="";    
            if(setSpageNum == setCurrentPage){
                addClass= "bg-secondary text-white";
            }
            setPageNation+="<li class='page-item setPage'><a class='page-link "+addClass+"' href='#' >"+setSpageNum+"</a></li>";
        }
        setPageNation+="<li class='page-item movePage'><a class='page-link' href='#' aria-label='"+setSpageNum+"'><span aria-hidden='true'>></span></a></li>";

        if(page['totalPage'] == setCurrentPage){
            setSpageNum=0;
        }
                
        // Pagination
        $("#pagination").empty().append(setPageNation);
        $("#current_page").val(setCurrentPage);
        $("#total_page").val(page['totalPage']);
    }

});