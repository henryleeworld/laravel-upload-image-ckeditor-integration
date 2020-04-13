<!DOCTYPE html>
<html>
<head>
    <title>CKEditor 圖片上傳</title>
    <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
</head>
<body>
<textarea name="editor1"></textarea>
<script type="text/javascript">
    CKEDITOR.replace('editor1', {
		//language:'zh-tw',
        filebrowserUploadUrl: "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form',
	    toolbarGroups: [
		    { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		    { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
		    { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
		    { name: 'forms', groups: [ 'forms' ] },
		    '/',
		    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		    { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
		    { name: 'links', groups: [ 'links' ] },
		    { name: 'insert', groups: [ 'insert' ] },
		    '/',
		    { name: 'styles', groups: [ 'styles' ] },
		    { name: 'colors', groups: [ 'colors' ] },
		    { name: 'tools', groups: [ 'tools' ] },
		    { name: 'others', groups: [ 'others' ] },
		    { name: 'about', groups: [ 'about' ] }
	    ]
    });
</script> 
</body>
</html>