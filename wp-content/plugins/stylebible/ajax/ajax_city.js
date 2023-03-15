function buildRequest( formData ) {
	var requestParams = {};

	formData.forEach(form => {
		requestParams[form.name] = form.value;
	});

	return requestParams;
}
<!-- Add -->
jQuery(document).on('click','#btn-add',function(e) {
	console.log(e);
	return;
	var cityInfo = buildRequest( jQuery("#user_form").serializeArray());
	jQuery.ajax({
		url: ajaxUrl,
		type: "POST",								
		data: {
			...cityInfo,
			action: 'crud_city'
		},
		success: function(response){
			var response = JSON.parse( response );
			if(response.result){
				jQuery('#addCityModal').modal('hide');
				alert('City added successfully !'); 
                location.reload();						
			}
		}
	});
});
<!-- Update -->
jQuery(document).on('click', '.update', function(e){
	var city_id = jQuery(this).attr("data-id");
	var city_name=jQuery(this).attr("data-name");
	var currency = jQuery(this).attr("data-currency");
	jQuery('#id_u').val(city_id);
	jQuery('#city_u').val(city_name);
	jQuery('#currency_u').val(currency);
});
jQuery(document).on('click', '#update', function(e){
	var cityInfo = buildRequest(jQuery("#update_form").serializeArray());
	cityInfo.id = jQuery("#id_u").val();
	jQuery.ajax({
		url: ajaxUrl,
		type: "POST",
		data: {
			...cityInfo,
			action: 'crud_city'
		},
		success: function(response){
			var response = JSON.parse(response);
			if(response.result){
				jQuery('#editCityModal').modal('hide');
				alert('City updated successfully !'); 
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
	var cityInfo={};
	cityInfo.type=3;
	cityInfo.id=jQuery("#id_d").val();
	jQuery.ajax({
		url: ajaxUrl,
		type: "POST",
		data:{
			...cityInfo,
			action: 'crud_city'
		},
		success: function(dataResult){
			jQuery('#deleteCityModal').modal('hide');
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
					action: 'crud_city'
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
