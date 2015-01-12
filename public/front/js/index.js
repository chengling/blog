$(function(){
	//////////////导航条
	$('#top_right').find('li').hover(function(){

		$('#bar').stop();
		var cur=$(this).index();
		$('#bar').animate({'left' : 163 + 61 * cur}, 500)
	},function(){
		$('#bar').stop();
		$('#bar').animate({'left' : 163}, 300)

	})

	////////////// 右侧最新文章(无缝滚动)
	var arcTimer = setInterval(run,3000);
	var i=0;
	function run(){
		if(i == 2){
			$('.arc_js_move').css({top:'0px'});
			i = 0;
		}
		i++;
		$('.arc_js_move').animate({top:-75 * i + 'px'}, '1500');
			
	}
	// 右侧最新文章(鼠标移入移出HOVER事件)
	$('.arc_js_move').hover(function(){
		clearInterval(arcTimer);
	},function(){
		arcTimer = setInterval(run,3000);
	})

	///////////////项目展示左边大图自动轮换
	var autoRunTimer = setInterval(auto_run,2000);
	var sta = 0;
	function auto_run(){
		sta++;		
		sta=(sta>3)?0:sta;
		// alert(sta);
		$('.foucs_photo_l').find('img').hide();
		$('.foucs_photo_l').find('img').eq(sta).fadeIn(500);

	}



	//////////////////返回顶部
	function change(){
		var newTop=$(window).height()-$('#back_top').height();
		var newLeft=$(window).width()-$('#back_top').width();
		$('#back_top').css({'top':newTop+$(window).scrollTop()-80+'px','left':newLeft-20+'px'})
	}
	//滚动事件
	$(window).scroll(function(){
		change();
		//判断什么时候该出现
		if ($(window).scrollTop()<200) {
			$('#back_top').hide();
		}
		if ($(window).scrollTop()>200) {
			$('#back_top').show();
		}		

	});

	//点击回到顶部事件
	var speed=150;
	$('#back_top').click(function(){
		var goTopTimer=setInterval(goTop,1)
		function goTop(){
			$(window).scrollTop($(window).scrollTop()-speed);			
			if ($(window).scrollTop()==0) {
				clearInterval(goTopTimer);
			}
		}
	})


	/////////////主页文章焦点图
	$('.arc_left').hover(
		function(){
			$(this).addClass('hover');
		},
		function(){
			$(this).removeClass('hover');
	})


	/////////////点击验证码更换
	$('#verify_img').click(function(){
		var src = $(this).attr("src");
		$(this).attr({"src" : src + "&" + Math.random()})
	})

	//关于我们页面效果
	$(function(){
		$('#table').fadeIn(2000);
		$(".right_little_box").slideDown(2000);
	})

	
})