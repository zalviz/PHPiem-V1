$(document).ready(function() {
	tinymce.init({
		selector: '#<?=$id; ?>', 
		menubar: false,
		height: 500,
		plugins: [
			'advlist autolink lists link image charmap print preview anchor',
			'searchreplace visualblocks code fullscreen',
			'insertdatetime media table contextmenu paste code'
		],
		toolbar: 'formatselect | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table | link unlink anchor media image | code',
		content_css: '//www.tinymce.com/css/codepen.min.css'
	});
});
