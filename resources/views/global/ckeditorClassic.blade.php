<script src="https://cdn.ckeditor.com/ckeditor5/12.1.0/classic/ckeditor.js"></script>
<script>
    var csrf = '{{csrf_token()}}';
    @foreach($editors as $editor)
    CKEDITOR.replace('{{$editor}}',{
        language: 'fa',
        filebrowserImageUploadUrl: '{{route('frontend.image-upload',['_token' => csrf_token() ])}}',
        contentsCss: "body {font-family: Vazir,Tahoma;}",
    });
    @endforeach
</script>