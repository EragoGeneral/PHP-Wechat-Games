function thisPage(count, curPage) {    
    count = count || 1;    
    count = Number(count);                    
    curPage = curPage || 1;    
    curPage = Number(curPage);  
    var per = 8;              
    per = Number(per);    
    var showPages = 0;    
    showPages = Number(showPages);    
    var showEnd = 0;    
    showEnd = Number(showEnd);    
    if (count%per > 0) {       
        var pages = (parseInt(count/per) + 1);    
    } else {    
        var pages = parseInt(count/per);    
    }    
    var str = '<span class="loadPage">'+curPage+'/'+ pages +' 页</span>';    
    str += '<span class="totalPage"> 共 '+ pages +' 页</span>'  
    if(curPage != 1){    
       str += '<span class="firstPage" data-page="1"><a href="http://*****.*****.com/thanksgiving?p=0#content">首页</a></span>'  
    }    
    if(curPage - 1 > 0){    
       str += '<span class="prevPage" data-page="'+(curPage-1)+'"><a href="http://*****.*****.com/thanksgiving?p='+ (curPage-2) +'#content">上一页</a></span>'  
    }
    if(pages <= 5){    
     showPages = 1;    
     showEnd = pages;    
    }else if(pages - curPage >= 4){    
     showPages = curPage;    
     showEnd = curPage+4;    
    }else if(pages - curPage < 4){    
     showPages = pages - 4;    
     showEnd = pages;    
    }    
    for(var i=showPages; i<=showEnd; i++){    
     if( i == curPage){    
        str += '<a class="page_trigger page_cur" data-page="'+i+'" onclick="javascript:;">'+ i +'</a>'   
     }else{    
        str += '<a class="page_trigger"  data-page="'+i+'" href="http://*****.*****.com/thanksgiving?p='+(i-1)+'#content">'+ i +'</a>'   
     }    
    }    
    if(curPage + 1 <= pages){    
       str += '</span><span class="nextPage" data-page="'+(curPage+1)+'"><a href="http://*****.*****.com/thanksgiving?p='+ curPage +'#content">下一页</a></span>';    
    }    
    if(curPage!=pages){    
       str += '<span class="lastPage" data-page="'+pages+'"><a href="http://*****.*****.com/thanksgiving?p='+ (pages-1) +'#content">尾页</a></span>';    
    }           
    $('.page_box').eq(0).html(str);
} 