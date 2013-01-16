// TODO: move this js code to separate js file as component
// and organize universal parent assignment for objects

$(function(){
	 
	$('#parent_type').on('change', function(){
		$('#parent_error').hide();
		$("input[name='"+ $(this).attr('id') +"']").val($(this).val());

		$.ajax({
			type: "GET",
			url: "/api/" + $(this).val(),
			data: {action: 'all'},
			dataType: "json"
		}).done(function(res) {
			var name = $('#parent_type').val().toLowerCase();
			$.each(res[name], function(index, value) {
				$('#parent_id').append($("<option></option>")
						.attr("value",value.id)
						.text(value.title));
			});
		});
	});

	$('#parent_id').on('change', function(){
		$('#parent_error').hide();
		$("input[name='"+ $(this).attr('id') +"']").val($(this).val());
		$('#parent_value').html($("input[name='parent_type']").val() + ": " + $("#parent_id option:selected").text() );
		$("#parent_remove").show();
	});

	$("#select_parent").on('click', function(){
		if(!$('#parent_id').val() || !$('#parent_type').val()){
			$('#parent_error').show();
			return false;
		}
		$('#myModal').modal('hide');
		return false;
	});

	$("#parent_remove").on('click', function(){
		$("input[name='parent_id']").val('');
		$("input[name='parent_type']").val('');
		$('#parent_value').html('');
		$(this).hide();
		return false;
	});
});