
// 導入WOW動態
new WOW().init();




$(function(){

	// 回到頂端
    $('.btn-goTop').click(function(){
      var $body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');
      $body.animate({
        scrollTop: 0
      }, 600);
      return false;
    });
    $(window).scroll(function () {
      var scrollVal = $(this).scrollTop();
      if(scrollVal > 80){
        $('.side-btn').fadeIn();
      }else{
        $('.side-btn').fadeOut();  
      };
    });


  //wrap高度
    var fh = $('.footer').height();
    // var hh = $('.header').height();
    // console.log(fh);
    $('.wrap').css({
      'margin-bottom':fh*-1,
      'padding-bottom':fh,
      // 'padding-top':hh-1
    });

    $(window).resize(function(){
      var fh = $('.footer').height();
      var hh = $('.header').height();
      // console.log(fh);
      $('.wrap').css({
        'margin-bottom':fh*-1,
        'padding-bottom':fh,
        // 'padding-top':hh-1
      });
    });


	// menu固定    
    // $(window).scroll(function () {
    //   var scrollVal = $(this).scrollTop();
    //   if(scrollVal > 80){
    //     $('.header').addClass('fixed');
    //     $('.banner').addClass('header-fixed');
    //   }else{
    //     $('.header').removeClass('fixed');
    //     $('.banner').removeClass('header-fixed');
    //   };
    //   if(scrollVal > 200){
    //     $('.header').addClass('fixed-0');
    //   }else{
    //     $('.header').removeClass('fixed-0');
    //   };
    // });


    // dropdown-hover
      // $(".dropdown").hover(            
      // function() {
      //     $('.dropdown-menu', this).stop( true, true ).fadeIn("fast");
      //     $(this).toggleClass('open');            
      // },
      // function() {
      //     $('.dropdown-menu', this).stop( true, true ).fadeOut("fast");
      //     $(this).toggleClass('open');          
      // });





});