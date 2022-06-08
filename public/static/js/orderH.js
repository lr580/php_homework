$(document).ready(function(){
	// 设置收货人
	$("input[name=consignee]").val($(".select-name:first").text());
	$("input[name=address]").val($(".address:first").text());
	$("input[name=phone]").val($(".bar-info>.phone:first").text());

	// 选择配送时段和支付方式时
	$(".time").click(function(){
		$(this).parent().children(".selected").removeClass("selected").addClass("select");
		$(this).removeClass("select").addClass("selected");
		$(this).parent().children("input:hidden").val($(this).text());
		// console.log($(this).text());
		// alert($(this).val());
	});
	
	// 切换送花对象时
	$(".words").hide();
	$(".words:first").show();
	$(".for-who").click(function(){
		var index=$(".send-word>div").index($(this));
		$(".words").hide();
		$(".words").eq(index).show();
		$(".for-who").removeClass("who-selected");
		$(this).addClass("who-selected");
	});
	// 当快速选择赠言时
	$(".word-select").click(function(){
		var len=$(this).text().length;
		var str=$(this).text().substr(2,len-2);
		// console.log(len);
		// console.log(str);
		$("textarea[name=message]").val(str);
		$(".type-word").text(202-len);
	});
	//当赠言超过200字时
	$("textarea[name=message]").keyup(function(e){
		var len=$(this).val().length;
		var left=200-len;
		// console.log(len);
		$(".type-word").text(left);
		if(left<=0){
			$(this).val($(this).val().substr(0,199));
		}
	});
	//关闭添加收件人面板
	$(".close-panel").click(function(){
		$("#add-panel").hide();
		$("#hgb").fadeOut("fast");
	});
	//点击提交
	$("#submit").click(function(event){
		var consignee=$("input[name=consignee]").val();
		var address=$("input[name=address]").val();
		var phone=$("input[name=phone]").val();
		var date=$("input[name=date]").val();
		var time=$("input[name=time]").val();
		var message=$("#message").val();
		var pay_with=$("input[name=pay-with]").val();
		var buy_name=$(".buy-name").text();
		var buy_phone=$(".buy-phone").text();

		$.post('ajax/submit-order.php',{
				consignee:consignee,
				address:address,
				phone:phone,
				date:date,
				time:time,
				message:message,
				pay_with:pay_with,
				buy_name:buy_name,
				buy_phone:buy_phone
			},function(data){
				// console.log(data);
			if(data=='success'){
				$("#successFrame").find("h2").html('提交成功');	//设置提示标题
				$("#hgb").fadeIn("fast").css({"height":$(window).height(),"top":(event.pageY-event.clientY),"left":(event.pageX-event.clientX)});	
				//设置遮罩位置，由于有可能滚动条已经被拉动过，所以必须要重定位，设置top和height
				$("#successFrame").fadeIn("fast").css({"left":($(window).width()/2-75+event.pageX-event.clientX),"top":(event.pageY-event.clientY+200)}).delay(1500).fadeOut("fast",function(){	//设置提示框位置并设置淡入淡出动画
					window.location.href='show-order.php';	//跳转到该链接
				});
			}else{
				event.preventDefault();
				$("#successFrame").find("h2").html(data);	//设置提示标题
				$("#hgb").fadeIn("fast").css({"height":$(window).height(),"top":(event.pageY-event.clientY),
					"left":(event.pageX-event.clientX)});	
				//设置遮罩位置，由于有可能滚动条已经被拉动过，所以必须要重定位，设置top和height
				$("#successFrame").fadeIn("fast").css({"left":($(window).width()/2-75+event.pageX-event.clientX),
					"top":(event.pageY-event.clientY+200)}).delay(1500).fadeOut("fast",function(){
						$("#hgb").fadeOut("fast");
					});

			}
		});
	});
});

// 选择收货人
function Select(obj){
	var name=$(obj).text();
	var address=$(obj).parent().find(".address").text();
	var phone=$(obj).parent().find(".phone").text();

	$(".select-name").removeClass("selected").addClass("select");
	$(obj).removeClass("select").addClass("selected");
	$("input[name=consignee]").val(name);
	$("input[name=address]").val(address);
	$("input[name=phone]").val(phone);
	$("#send-to").text("配送至："+address);
	$("#send-for").text("收货人："+name+" "+phone);
	// console.log($(this).text());
	// alert($(this).val());
}

// 对收货人进行操作
function ConsigneeOper(member,operation){
	if(member=="member"){
		if(operation=="add"){
			$("#edit-btn").hide();
			$("#add-panel").show().css({"left":($(window).width()/2-200)});
			$("#add-btn").show();
			$("#hgb").fadeIn("fast").css({"height":$(window).height(),"top":0});
			$(".edit-panel>input").val("");
		}
	}else if(operation=="edit"){
		$("#add-btn").hide();
		$("#add-panel").show().css({"left":($(window).width()/2-200)});
		$("#hgb").fadeIn("fast").css({"height":$(window).height(),"top":0});
		$("#edit-btn").show();
		$("#edit-btn").attr('onclick','javascript:SaveConsignee("'+member+'","edit")');
		var editId="#scn"+member;
		var editName=$(editId).find(".select-name").text();
		var address=$(editId).find(".address").text().split(" ");
		var editProvince=address[0];
		var editCity=address[1];
		var editAddr=address[2];
		if(address.length==1){
			editProvince="";
			editAddr=address[0];
		}
		var editPhone=$(editId).find(".phone").text();
		$("#addName").val(editName);
		$("#addPhone").val(editPhone);
		$("#addProvince").val(editProvince);
		$("#addCity").val(editCity);
		$("#addAddr").val(editAddr);
	}else if(operation=="delete"){
		// ajax删除服务器数据
		var deleteId="#scn"+member;
		$.post('ajax/delete-customer.php',{delID:member},function(data){
			// console.log(data);
			if(data=='success'){
				$(deleteId).hide();
			}
		});
	}else if(operation=="default"){
		var original=$(".default-address").parent();
		var originalID=$(original).attr('id');
		var idLen=originalID.length;
		var defaultId="#scn"+member;
		originalID=originalID.substr(3,idLen);
		// ajax设置默认
		$.post('ajax/set-default.php',{setID:member},function(data){
			if(data=='success'){
				// 删掉原默认
				$(original).find(".default-address").remove();
				$(original).find(".edit").remove();
				$(original).append('<a class="delete" href="javascript:ConsigneeOper(\''+originalID+'\',\'delete\')">删除</a>'
							+'<a class="edit" href="javascript:ConsigneeOper(\''+originalID+'\',\'edit\')">编辑</a>'
							+'<a class="set-default" href="javascript:ConsigneeOper(\''+originalID+'\',\'default\')">设为默认地址</a>');
				// 新增默认
				$(defaultId).find(".delete").remove();
				$(defaultId).find(".set-default").remove();
				$(defaultId).append('<span class="default-address">默认地址</span>');
			}
		});
	}
}
// 保存收货人信息
function SaveConsignee(member,operation){
	var addName=$("#addName").val();
	var addPhone=$("#addPhone").val();
	var addProvince=$("#addProvince").val();
	var addCity=$("#addCity").val();
	var addAddr=$("#addAddr").val();
	var address=addProvince+" "+addCity+" "+addAddr;
	switch(operation){
		case 'add':
			// ajax添加数据
			$("#hgb").fadeOut("fast");
			$("#add-panel").hide();
			$.post('ajax/add-customer.php',{addName:addName,addPhone:addPhone,address:address},function(data){
				// console.log(data);
				if(data=='success' || data=='default'){
					$(".select-name").removeClass("selected").addClass("select");
					$("#select-consignee").append(
						'<div class="bar-info"><div class="selected select-name" onclick="Select(this)">'
						+addName+'</div><span class="name">'+addName+'</span><span class="address">'+address
						+'</span><span class="phone">'+addPhone+'</span></div>');
					$("input[name=consignee]").val(addName);
					$("input[name=address]").val(address);
					$("input[name=phone]").val(addPhone);
					$("#send-to").text("配送至："+address);
					$("#send-for").text("收货人："+addName+" "+addPhone);
				}
			});
			break;
		case 'edit':
			//ajax更新服务器数据
			$("#hgb").fadeOut("fast");
			$("#add-panel").hide();
			var editId="#scn"+member;
			$.post('ajax/edit-customer.php',{addName:addName,addPhone:addPhone,address:address,custID:member},function(data){
				// console.log(data);
				if(data=='success'){
					$(editId).find(".select-name").text(addName);
					$(editId).find(".name").text(addName);
					$(editId).find(".address").text(address);
					$(editId).find(".phone").text(addPhone);
				}
			});
			break;
	}
}
// 保存订购人
function AddBuyer(){
	var name=$("#buy-name").val();
	var phone=$("#buy-phone").val();
	var email=$("#buy-email").val();
	// ajax更新服务器数据
	$("#add-buyer").parent().text("").append('<span class="buy-name">'+name
		+'</span><span class="buy-phone">'+phone+'</span><span class="buy-email">'+email+'</span>'
				+'<a href="javascript:EditBuyer()" class="edit-buy">编辑</a>');
}
// 修改订购人
function EditBuyer(){
	var name=$(".buy-name").text();
	var phone=$(".buy-phone").text();
	var email=$(".buy-email").text();
	// ajax更新服务器数据
	$(".edit-buy").parent().text("").append('<input id="buy-name" type="text" placeholder="您的姓名">'
				+'<input id="buy-phone" type="text" placeholder="手机号码或电话">'
				+'<input id="buy-email" class="disabled" type="text" value="hhccrr@foxmail.com" disabled="disabled">'
				+'<button onclick="AddBuyer()" id="add-buyer">确定</button>');
	$("#buy-name").val(name);
	$("#buy-phone").val(phone);
	$("#buy-email").val(email);
}