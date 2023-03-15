function buildRequest( formData ) {
	var requestParams = {};

	formData.forEach(form => {
		requestParams[form.name] = form.value;
	});

	return requestParams;
}
<!-- Add -->
jQuery(document).on('click','#btn-add',function(e) {
	var categoryInfo = buildRequest( jQuery("#user_form").serializeArray());
	jQuery.ajax({
		url: ajaxUrl,
		type: "POST",								
		data: {
			...categoryInfo,
			action: 'crud_category'
		},
		success: function(response){
			var response = JSON.parse( response );
			if(response.result){
				jQuery('#addCategoryModal').modal('hide');
				alert('Category added successfully !'); 
                location.reload();						
			}
		}
	});
});
<!-- Update -->
jQuery(document).on('click', '.update', function(e){
	var category_id = jQuery(this).attr("data-id");
	var category_name=jQuery(this).attr("data-name");
	var order=jQuery(this).attr("data-order");
	jQuery('#id_u').val(category_id);
	jQuery('#category_u').val(category_name);
	jQuery("#order_u").val(order);
});
jQuery(document).on('click', '#update', function(e){
	var categoryInfo = buildRequest(jQuery("#update_form").serializeArray());
	categoryInfo.id = jQuery("#id_u").val();
	jQuery.ajax({
		url: ajaxUrl,
		type: "POST",
		data: {
			...categoryInfo,
			action: 'crud_category'
		},
		success: function(response){
			var response = JSON.parse(response);
			if(response.result){
				jQuery('#editCategoryModal').modal('hide');
				alert('Category updated successfully !'); 
                location.reload();
			}
		}
	}) 		
});
<!-- Delete -->
jQuery(document).on('click', '.delete', function(){
	var city_id=jQuery(this).attr("data-id");
	jQuery('#id_d').val(city_id);
});
jQuery(document).on('click', '#delete', function(){
	var categoryInfo={};
	categoryInfo.type=3;
	categoryInfo.id=jQuery("#id_d").val();
	jQuery.ajax({
		url: ajaxUrl,
		type: "POST",
		data:{
			...categoryInfo,
			action: 'crud_category'
		},
		success: function(dataResult){
			jQuery('#deleteCategoryModal').modal('hide');
			jQuery("#"+dataResult).remove();
			location.reload();
		}
	})
});
jQuery(document).on("click", "#delete_multiple", function() {
	var user = [];
	jQuery(".user_checkbox:checked").each(function() {
		user.push(jQuery(this).data('user-id'));
	});
	if(user.length <=0) {
		alert("Please select records."); 
	} 
	else { 
		WRN_PROFILE_DELETE = "Are you sure you want to delete "+(user.length>1?"these rows?":"this row?");
		var checked = confirm(WRN_PROFILE_DELETE);
		if(checked == true) {
			var selected_values = user.join(",");
			jQuery.ajax({
				url: ajaxUrl,
				type: "POST",
				cache:false,
				data:{
					type: 4,						
					id : selected_values,
					action: 'crud_category'
				},
				success: function(response) {
					var ids = response.split(",");
					for (var i=0; i < ids.length; i++ ) {	
						jQuery("#"+ids[i]).remove(); 
					}
					location.reload();	
				} 
			}); 
		}  
	} 
});
jQuery(document).ready(function(){
	jQuery('[data-toggle="tooltip"]').tooltip();
	var checkbox = jQuery('table tbody input[type="checkbox"]');
	jQuery("#selectAll").click(function(){
		if(this.checked){
			checkbox.each(function(){
				this.checked = true;                        
			});
		} else{
			checkbox.each(function(){
				this.checked = false;                        
			});
		} 
	});
	checkbox.click(function(){
		if(!this.checked){
			jQuery("#selectAll").prop("checked", false);
		}
	});
});
