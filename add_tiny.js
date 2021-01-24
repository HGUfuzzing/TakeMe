tinymce.init({
    selector: 'textarea',
    height: "500",
    plugins: [
        'advlist autolink link image code lists charmap hr anchor pagebreak',
        'searchreplace wordcount visualblocks visualchars code fullscreen nonbreaking',
        'table emoticons template paste'
    ],
    toolbar: 
        'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' +
        'bullist numlist outdent indent | link image code|' +
        'forecolor backcolor emoticons',
    menubar: 'favs file edit view insert format tools table',
    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
});