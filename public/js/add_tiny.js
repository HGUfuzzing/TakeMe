tinymce.init({
    selector: 'textarea',
    height: '500',
    width: '100%',
    plugins: [
        'advlist autolink link image code lists charmap hr anchor pagebreak',
        'searchreplace wordcount visualblocks visualchars code fullscreen nonbreaking',
        'table emoticons template paste'
    ],
    toolbar: 
        'bullist numlist outdent indent |' +
        'code forecolor backcolor emoticons',
    menubar: '',
    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
});