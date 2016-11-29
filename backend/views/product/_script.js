//select 添加样式
$(".field-productspecification-spec_id").hide();
$(".field-product-online_scheduled").hide();
$("div.form-group select").addClass("selectpicker");
$("div.form-group select").attr({"data-style" : "form-control","data-style-Base" : ""});


//提交表单是，选中多个规格，否则跳出提示框

$("#w0").submit(function(e){
	if($("#product-is_multi_spec").find("option:selected").val() == 'Y'){
		var checks = $('[name="multiple_spec_id[]"]');
		check_val = [];
	    for(k in checks){
	        if(checks[k].checked)
	            check_val.push(checks[k].value);
	    }
	    if(check_val.length == 0){
	    	 bootbox.alert({  
	    		 message: "<?php echo Yii::t('backend', 'Please choose to add the specifications?')?>",
	    		 buttons: {  
	                ok: {  
	                     label: "<?php echo Yii::t('backend', 'Cancel')?>", 
	                 }  
	             },  
	             callback: function() {},
	         }); 
			return false;
	    }
	}
	return true;
});



//form 表单
function is_multi_spec(val){
	if(val == '否'){
		$('.is_hide').show();
		$(".form_is_hide").show();
		$(".grid_is_hide").hide();
	}else if(val == '是'){
		$('.is_hide').show();
		$(".form_is_hide").hide();
		$(".grid_is_hide").show();
	}
}

//上架时间
function is_online(val){
	if(val == '否'){
		$(".field-product-online_scheduled").show();
	}else if(val == '是'){
		$(".field-product-online_scheduled").hide();
	}
}



$(window).load(function(){
	var spec = $("select#product-is_multi_spec").next().find("div ul li");
	var selected = $("select#product-is_multi_spec").next().find("button").attr("title");
	is_multi_spec(selected);
	spec.click(function(){
		var spec_text = $(this).find("a span").text();
		is_multi_spec(spec_text);
	})

	var online = $("select#product-online").next().find("div ul li");
	var online_selected = $("select#product-is_multi_spec").next().find("button").attr("title");
	online.click(function(){
		var online_text = $(this).find("a span").text();
		is_online(online_text);
	})
	
})









