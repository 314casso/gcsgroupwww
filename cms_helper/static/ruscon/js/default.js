//
//
//
function dummy() { }
function no_progress_bar_dummy() { }

//
//
//
$(document).ready(function(){
	init_all();

	$.ajaxSetup ({
	// Disable caching of AJAX responses */
		cache: false
	});

});

//
//
//
function hide_modals () { 
	$("#modal_dialog_confirm").dialog("destroy");
	$("#modal_dialog_loading").dialog("destroy");
}
function hide_modals_with_init () { 
//	hide_modals();
	window.location = window.location;
}

//
//
//
function destroy_editor_instances () {
	if( $(".jquery_ckeditor").attr("class") == "jquery_ckeditor" ) {
		$('.jquery_ckeditor').ckeditor( function(){ this.destroy() } );
	}
	if( $(".jquery_ckeditor_basic").attr("class") == "jquery_ckeditor_basic" ) {
		$('.jquery_ckeditor_basic').ckeditor( function(){ this.destroy() } );
	}
}


//
//
//
function init_all() {
	hide_modals ();

	init_colorpicker();
	init_datepicker();
	init_sortable();
	init_animation();
	init_forms();
//	init_tabs();
	init_editor();
//	init_wait_link();
}

//
//
//
function show_modal (dialog_uri, dialog_title, dialog_width, dialog_height) {
	$("#modal_dialog_loading").dialog({ modal: true });
	$("#modal_dialog").dialog("destroy");
	destroy_editor_instances();

	$.get( dialog_uri,  
		function(data){
			if(!dialog_title){ dialog_title = "Администрирование" }
			if(!dialog_width){ dialog_width = "760" }
			if(!dialog_height){ dialog_height = "400" }

			$("#modal_dialog").html(data);
			$("#modal_dialog").attr("title", dialog_title);
			$("#modal_dialog").dialog({
				width: "" + dialog_width + "px", 
				height: "" + dialog_height + "" ,
//				,modal: true
				close: function(ev, ui) {
					destroy_editor_instances();
				}
			});
			init_all();
		}
	);
}
function update_modal (dialog_uri) {
	destroy_editor_instances();
	$("#modal_dialog_loading").dialog({ modal: true });
	$.get( dialog_uri,  
		function(data){
			$("#modal_dialog").html(data);
			init_all();
		}
	);
}

//
//
//
function init_editor () {
	$(".editor___").each(function(i){
//		alert( $(this).attr("id") );
		var oFCKeditor = new FCKeditor( $(this).attr("id") ) ;
		oFCKeditor.BasePath	= "/js/editor/" ;
		oFCKeditor.ToolbarSet = $(this).attr("toolbarset") ;
		oFCKeditor.Width = "730" ;
		oFCKeditor.Height = $(this).attr("height") ;
		oFCKeditor.ReplaceTextarea() ;
	});
}

//
//
//
function submit_form_ajax ( form_name, on_script_end ) {
	var is_correct = "1";
	$("#" + form_name + " .required,#" + form_name + " .required_").each(function (i) {
		if( $(this).attr("value") == "") {
			if( $(this).attr("className").indexOf("required_") == "-1") { $(this).attr("className", $(this).attr("className").replace("required", "required_") ); }
			$(this).focus();
			is_correct = "0";
			return false;
		} else {
			$(this).attr("className", $(this).attr("className").replace("required_", "required") );
		}
	});

	if( is_correct == "1" ) {
		$("#modal_dialog_loading").dialog({ modal: true, height: "100" });
		$("body").append("<iframe src='/admin/submit_form_ajax/' name='ajax_file_upload' id='ajax_file_upload' style='display: none'></iframe>");
		$("form#"+form_name+"").attr("target","ajax_file_upload");
		$("form#"+form_name+"").attr("action","/admin/submit_form_ajax/");
		$("form#"+form_name+"").submit();
		var timeout    = 3000;
		var closetimer = 0;
		if ( on_script_end ) {
			var myFunction = new Function( on_script_end );
			closetimer = window.setTimeout( myFunction , timeout);
		} else {
			closetimer = window.setTimeout( hide_modals_with_init , timeout);
		}
	}
}


//
//
//
function init_sortable () {
	$(".sortable").each(function(i){
		$(this).sortable({
			placeholder: 'ui-state-highlight',
			update: function (event, ui) {
				$.get( '/admin/edit_serialize/?string=' + $(this).sortable('serialize').replace(/&/gi, 'amp;'), 
					function(data){
//						alert(data);
					}
				);
			}
		});
		$(this).disableSelection();
	});
}
//
//
//
function init_datepicker () {
	$(".datapicker").each(function(i){
		$(this).datepicker($.datepicker.regional['ru']);
		$(this).datepicker('option', {dateFormat: 'yy-mm-dd'});
		if( $(this).attr("value_") ){
			$(this).val( $(this).attr("value_") );
		} else {
			var myDate = new Date();
			var prettyDate = myDate.getFullYear() + '-' + eval(myDate.getMonth() + 1) + '-' + myDate.getDate();
			$(this).val(prettyDate);
		}
	});
}

//
//
//
function init_wait_link () {
//	$("a").each(function(i){
//	$(this).click(function(){
//		if( $(this).attr("href").substr(0,1) == "#" || $(this).attr("href").substr(0,34) == "javascript:no_progress_bar_dummy()" ){
//		} else {
//			$("#modal_dialog_loading").dialog({ modal: true });
//		}
//	});
//	});

//	$(":button").each(function(i){
//	$(this).click(function(){
//		if( $(this).attr("onClick").indexOf("toggle") >= "0" ||  $(this).attr("onClick").indexOf("hide_modal") >= "0" || $(this).attr("onClick").indexOf("no_progress_bar_dummy()") >= "0" ) {
//		} else {
//			$("#modal_dialog_loading").dialog({ modal: true });
//		}
//	});
//	});
}

//
//
//
function please_confirm ( message_text, on_script_end ) {

	$("#modal_dialog_confirm").html( message_text );
	$("#modal_dialog_confirm").attr( "title",  $("#please_confirm_text").html() );
	$("#modal_dialog_confirm").dialog({
		resizable: false,
		height:140,
		modal: true,
		buttons: {
			'OK': function() {
				var myFunction = new Function( on_script_end );
				myFunction();
				$(this).dialog('close');
			},
			Cancel: function() {
				$(this).dialog('close');
			}
		}
	});

}

//
//
//
function delete_element ( table_name, key_id, key_value, element_id ) {
	$.get( '/admin/delete_element/?table_name=' + table_name + '&key_id=' + key_id + '&key_value=' + key_value, 
		function(data){
			$("#" + element_id + "").hide("slow");
//			alert(data);
		}
	);
}

//
//
//
function submit_form_old ( form_name, is_ajax, on_script_end ) {
	$("#form_verify").val("1");
	$("#" + form_name + " .required,#" + form_name + " .required_").each(function (i) {
		if( $(this).attr("value") == "") {
			if( $(this).attr("className").indexOf("required_") == "-1") { $(this).attr("className", $(this).attr("className").replace("required", "required_") ); }
			$(this).focus();
			$("#form_verify").val("0");
			return false;
		} else {
			$(this).attr("className", $(this).attr("className").replace("required_", "required") );
		}
	});

	if( $("#form_verify").val() == "1" ) {
		$("form#"+form_name+"").attr("onsubmit", "return false()");
		$("form#"+form_name+"").submit();
	}
}

//
//
//
function change_menu ( menu_id ) {
	var open_id = menu_id.substring( menu_id.indexOf('_') + 1 );
	var class_name = menu_id.split('_');

	$('.' + class_name[0] + '').each(function (i) {
		if ( $(this).attr('id') == menu_id) {
			if( $(this).attr('value_') == '1' ) {
				$(this).attr('value_', '0');
			} else {
				$(this).attr('value_', '1');
			}
		} else {
			$(this).attr('value_', '0');
			$(this).hide();
		}
	});

	if( $('#' + class_name[0] + '_' + open_id + '').attr('value_') == '1' ) { 
		$('#' + class_name[0] + '_' + open_id + '').show();
	} else {
		$('#' + class_name[0] + '_' + open_id + '').hide();
	}
}

//
//
//
function submit_email ( email ) {
	if ( CheckEmailFormat ( email ) == false ) {
		alert ( 'Неверный формат e-mail');
	} else {
		$.get( '/admin/subscribe_email/?email=' + email + '', 
			function(data){
				$("#subscribe_form_div").html("Ваша заявка успешно отправлена");
//				alert(data);
			}
		);
	}
}

//
//
//
function CheckEmailFormat( email ) {
	var s = '[A-Za-z0-9][-\\w]*(\\.[A-Za-z0-9][-\\w]*)*'
	var re = new RegExp( '^'+s+'@'+s+'\\.[a-zA-Z]{2,4}$')
	email = email.replace( new RegExp('/\(.*?\)/'), '' )
	return re.test(email)
}

//
//
//
function init_animation () {
	$(".clients_animation_change").each(function(i){
		$(this).ulslide({
			width: 260,
			height: 'auto',
			axis: 'x',
			autoslide: 4000
		});
	});
	$(".clients_animation_slide").each(function(i){
		$(this).ulslide({
			width: 190,
			height: 80,
			axis: 'y',
			autoslide: 4000
		});
	});
	$(".clients_animation_fade").each(function(i){
		$(this).ulslide({
			width: 900,
			height: 400,
			affect: 'fade', 
			autoslide: 5000,
			duration: 300 
		});
	});
}

//
//
//
function init_colorpicker () {
	$(".colorpicker_").each(function(i){
		$(this).jPicker();
	});
}


//
//
//
function submit_form ( form_name ) {
	$("form#"+form_name+"").submit(function() {
	var is_correct = "1";
	$("#" + form_name + " .required, #" + form_name + " .required_").each(function (i) {
		if( $(this).attr("value") == "") {
			if( $(this).attr("class").indexOf("required_") == -1) { 
				$(this).attr("class", $(this).attr("class").replace("required", "required_") );
			}
			$(this).focus();
			is_correct = "0";
			return false;

		} else {
			if( $(this).attr("class").indexOf("required_") >= 0) { 
				$(this).attr("class", $(this).attr("class").replace("required_", "required") );
			}
		}
	});
	if( is_correct == "1" && $("#form_verify").val() == "0" ) {
		$("#form_verify").val("1");
		return true;
	} else { return false; }
	
	});
}

//
//
//
function init_forms () {
	if( $("#form_verify").val() >= "0" ) {
		$("#form_verify").val("0");
		$("#current_action").val("0");
	} else {
		$("form:last").append("<input type=hidden id=form_verify name=form_verify value=0 />");
		$("form:last").append("<input type=hidden id=current_action name=current_action value=0 />");
	}
	$("form").each(function(i){
		submit_form( $(this).attr("id") );
	});
}

