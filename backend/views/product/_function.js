function update_status(key){
	   jQuery.ajax(
		   {
			  type: 'get',
			  url: '/nxshop/backend/web/index.php?r=product-specification/index' ,
			  data: {id:key} ,
			  success: function(data){
				   var data = jQuery.parseJSON(data);
				   $('#productspecification-spec_id').val(data.spec_id);
				   $('#productspecification-name').val(data.name);
				   $('#productspecification-price').val(data.price);
				   $('#productspecification-weight').val(data.weight);
				   $('#productspecification-stock').val(data.stock);
				   $('#productspecification-sku').val(data.sku);
				   $('#productspecification-tax_rate').val(data.tax_rate);
				   $('#productspecification-order').val(data.order);
				   $('#productspecification-size').find("option:selected").html(data.size);
				   $('#productspecification-color').find("option:selected").html(data.color);
				   
				   $('#popup').attr('action', "/nxshop/backend/web/index.php?r=product-specification/update&id="+key); 
				   $('#btn_spec').html("<?php echo Yii::t('backend', 'Update')?>");
				   $("#popup").show();
				   $('#request').hide();
			  },
			  beforeSend: function(){
				  $("#popup").hide();
				  $('#request').show();
			  }
			}
	   );	   	   
};

//打开弹出框清除表单数据，避免弹出框数据残留
function create_spec(){
	return;
//	$('#popup')[0].reset(); 
//    $('#popup').attr('action', "/nxshop/backend/web/index.php?r=product/create-spec");
//    $('#btn_spec').html("<?php echo Yii::t('backend', 'Create')?>");
}

function delete_Spec_batch(){
	 var keys = $("#batch_id").yiiGridView("getSelectedRows");
	 if(keys && keys.length < 1){
		 bootbox.alert({
    		 message: "<?php echo Yii::t('backend', 'Please choose to delete the specifications?')?>",
    		 buttons: {  
                ok: {  
                     label: "<?php echo Yii::t('backend', 'Cancel')?>", 
                 }  
             },  
             callback: function() {},
         }); 
		 return ;
	 }
	 $("#delete_Spec").attr('href','/nxshop/backend/web/index.php?r=product-specification/delete&id='+keys);
	 return ;
}

