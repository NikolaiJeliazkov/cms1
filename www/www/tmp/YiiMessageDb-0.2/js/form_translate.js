
var project_path='';
var source_lang='';

$(document).ready(function(){
	$("#dd_lang_sel").change(function(){
		updateTranslateForm(project_path, source_lang);
	});
});



function updateTranslateForm(prj_path, src_lang) {

	project_path=prj_path;
	source_lang=src_lang;

	$.post("index.php?r=site/gettranslateform",
		{ 'sel_target_lang': $('#dd_lang_sel option:selected').text(),
		  'project_path': project_path,
		  'source_lang': source_lang },
		function(json){
			$("#translate_form").html(json.form);
			$("#log_msg_tr").text(json.log);
		}, 'json');

}
