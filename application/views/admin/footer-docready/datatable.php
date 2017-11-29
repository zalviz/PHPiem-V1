var $datatable = $("#<?=$idtbl;?>");
var handleDataTableButtons = function() {
	if ($datatable.length) {
		$datatable.DataTable({
			dom: "Bfrtip",
			buttons: [
				{
					extend: "copy",
					className: "btn-sm"
				},
				{
					extend: "csv",
					className: "btn-sm"
				},
				{
					extend: "excel",
					className: "btn-sm"
				},
				{
					extend: "pdf",
					className: "btn-sm"
				},
				{
					extend: "print",
					className: "btn-sm"
				},
			],
			responsive: true,
			columnDefs: [{
				"targets": 0,
				"render": function(d,t,f,m){
					return '<input type="checkbox" name="eid" value="'+d+'">';
				}
			},{
				"targets": <?=$colink;?>,
				"render": function(d,t,f,m){
					return '<a href="<?=$dturl;?>/'+f[<?=$dcolink;?>]+'">'+d+'</a>';
				}
			}]
		});
	}
};

TableManageButtons = function() {
	"use strict";
	return {
		init: function() {
			handleDataTableButtons();
		}
	};
}();

$datatable.on('draw.dt', function() {
	$('input[type=checkbox]').iCheck({
		checkboxClass: 'icheckbox_flat-green'
	}).on('ifChecked', function(e){
		console.log('isi: ' + JSON.stringify($(this).val()));
	});
});

TableManageButtons.init();