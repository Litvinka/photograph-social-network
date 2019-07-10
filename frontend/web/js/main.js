$(document).ready(function(){
    $(".screen").css('height', $(window).height());
    $('.bt a').click(function(){
    var el = $(this).attr('href');
    $('body').animate({
        scrollTop: $(el).offset().top}, 1500);
        return false; 
    });

    
//если футер не внизу страницы
    var footer=$("#footer");
    var s=$(window).height()-30;
if(footer.offset().top<s){
    footer.css('position','fixed');
    footer.css('bottom','0px');
    footer.css('right','0px');
    footer.css('left','0px');
}

function readys(){
    document.getElementById('small_logo').style.height=document.getElementById('small_logo').style.width;
    //Изменение изображений аватарки и области видимости
    var width=document.getElementById('small_logo').width;
    var height=document.getElementById('small_logo').height;
    if(height<width){
        var $d=height/40;
        document.getElementById('small_logo').height="40";
        document.getElementById('small_logo').width=width/$d;
        document.getElementById("small_logo").style.left=(document.getElementById('small_logo').width-40)/2*(-1) + "px";
    }
    else{
        var $d=width/130;
        document.getElementById('small_logo').width="40";
        document.getElementById('small_logo').height=height/$d;
        document.getElementById("small_logo").style.top=(document.getElementById('small_logo').height-40)/2*(-1) + "px";
    }
}
readys();

}); 
// var scrolStart=window.pageYOffset;
// var height=0;
// document.addEventListener('scroll', function(){
// 	if($(window).width()>768){
// 		var scrolEnd=window.pageYOffset;
// 			if(scrolStart<scrolEnd){
// 				scrolStart=scrolEnd;
// 				if(height<$(window).height()*4){
// 					height=$(window).height()+height;
// 				}
// 				$('body').animate({
// 			        scrollTop: height}, 1500);
// 			        return false; 
// 			}
// 			if(scrolStart>scrolEnd){
// 				scrolStart=scrolEnd;
// 				if(height>0){
// 					height=height-$(window).height();
// 				}
// 				$('body').animate({
// 			        scrollTop: height}, 1500);
// 			        return false; 
// 		}
// 	}	
// });

function PhotoNav(e){
    var display=$('.photo_nav:first').css('display');
    if(display=="block"){
        $('.photo_nav:first').css('display','none');
    }
    else{
        $('.photo_nav:first').css('display','block');
    }
}


