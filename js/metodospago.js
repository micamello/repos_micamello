$(window).on('load',function(){
  $("#panel_P *").attr("disabled",true);
  $("#panel_D *").attr("disabled",false);
});

$("input[name=select_form]").click( function() {
	if ($("input:checked").val() == 'P'){
		$("#panel_P *").attr("disabled",false);
		$("#panel_D *").attr("disabled",true);
	}
	else{
    $("#panel_D *").attr("disabled",false);
		$("#panel_P *").attr("disabled",true);
	}
});