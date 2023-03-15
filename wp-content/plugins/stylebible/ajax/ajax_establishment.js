function buildRequest( formData ) {
	var requestParams = {};

	formData.forEach(form => {
		requestParams[form.name] = form.value;
	});

	return requestParams;
}
<!-- Add -->
jQuery(document).on('click','#btn-add',function(e) {
	var establishmentInfo = buildRequest( jQuery("#user_form").serializeArray());
	console.log(establishmentInfo);
	jQuery.ajax({
		url: ajaxUrl,
		type: "POST",								
		data: {
			...establishmentInfo,
			action: 'crud_establishment'
		},
		success: function(response){
			var response = JSON.parse( response );
			if(response.result){
				jQuery('#addEstablishmentModal').modal('hide');
				alert('Establishment added successfully !'); 
                location.reload();						
			}
		}
	});
});
<!-- Update -->
jQuery(document).on('click', '.update', function(e){
	var id = jQuery(this).attr("data-id");
	var establishment=jQuery(this).attr("data-name");
	var area=jQuery(this).attr("data-area");
	var address=jQuery(this).attr("data-address");
	var website_url=jQuery(this).attr("data-website-url");
	var instagram_url=jQuery(this).attr("data-instagram-url");
	var tiktok=jQuery(this).attr("data-tiktok");
	var love=jQuery(this).attr("data-love");
	var price=jQuery(this).attr("data-price");
	var is_deleted=jQuery(this).attr("data-deleted");
	var author=jQuery(this).attr("data-author");
	var rating=jQuery(this).attr("data-rating");
	var hidden_gem=jQuery(this).attr("data-hidden-gem");
	var city_id=jQuery(this).attr("data-city-id");
	var category_id=jQuery(this).attr('data-category-id');
	var sub_category_id=jQuery(this).attr('data-sub-category-id');
	jQuery('#id_u').val(id);
	jQuery('#establishment_u').val(establishment);
	jQuery('#area_u').val(area);
	jQuery('#address_u').val(address);
	jQuery('#website_url_u').val(website_url);
	jQuery('#instagram_url_u').val(instagram_url);
	jQuery('#tiktok_u').val(tiktok);
	jQuery('#love_u').val(love);
	jQuery('#price_u').val(price);
	jQuery('#is_deleted_u').val(is_deleted);
	jQuery('#author_u').val(author);
	jQuery('#rating_u').val(rating);
	jQuery('#hidden_gem_u').val(hidden_gem);
	jQuery('#city_id_u').val(city_id);
	jQuery('#category_id_u').val(category_id);
	jQuery('#sub_category_id_u').val(sub_category_id);
});
jQuery(document).on('click', '#update', function(e){
	var establishmentInfo = buildRequest(jQuery("#update_form").serializeArray());
	establishmentInfo.id = jQuery("#id_u").val();
	jQuery.ajax({
		url: ajaxUrl,
		type: "POST",
		data: {
			...establishmentInfo,
			action: 'crud_establishment'
		},
		success: function(response){
			var response = JSON.parse(response);
			if(response.result){
				jQuery('#editEstablishmentModal').modal('hide');
				alert('Establishment updated successfully !'); 
                location.reload();
			}
		}
	}) 		
});
<!-- Delete -->
jQuery(document).on('click', '.delete', function(){
	var id=jQuery(this).attr("data-id");
	jQuery('#id_d').val(id);
});
jQuery(document).on('click', '#delete', function(){
	var establishmentInfo={};
	establishmentInfo.type=3;
	establishmentInfo.id=jQuery("#id_d").val();
	jQuery.ajax({
		url: ajaxUrl,
		type: "POST",
		data:{
			...establishmentInfo,
			action: 'crud_establishment'
		},
		success: function(dataResult){
			jQuery('#deleteEstablishmentModal').modal('hide');
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
			console.log(selected_values);
			jQuery.ajax({
				url: ajaxUrl,
				type: "POST",
				cache:false,
				data:{
					type: 4,						
					id : selected_values,
					action: 'crud_establishment'
				},
				success: function(response) {
					var ids = response.split(",");
					for (var i=0; i < ids.length; i++ ) {	
						jQuery("#"+ids[i]).remove(); 
						location.reload();
					}
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
