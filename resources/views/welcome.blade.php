<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/css?family=Noto+Sans+TC&display=swap" rel="stylesheet">
        <link href="/css/bootstrap_r.css" rel="stylesheet">
        <link href="/css/default.css" rel="stylesheet">

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">

        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <form class="form" id="upload_form">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="file" class="custom-file-input" id="uploadImageFile" aria-describedby="inputGroupFileAddon04">
                                <label class="custom-file-label" for="inputGroupFile04">選擇檔案</label>
                            </div>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="inputGroupFileAddon04">上傳</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/wow.js"></script>
        <script src="/js/ajax.js"></script>
        <script src="https://kit.fontawesome.com/588be6838c.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="/js/sweetalert2.all.min.js"></script>

        <script type="text/javascript">
            $('#inputGroupFileAddon04').on('click',function(){
                var formData = new FormData();
                var file = document.getElementById('uploadImageFile').files[0];
                formData.append('file', file);
                var ajaxRequest = new ajaxUploadImage('POST', '{{ route('upload.image') }}',formData);
                ajaxRequest.request();
            })
                // var id = 'uploadImage_'+idArray[1];
                // url = '/webmin/content/homebanner/update/image';
                
                    
        </script>
    </body>
</html>
{{-- formData.append('image', file);
                    var ajaxRequest = new ajaxUploadImage('POST', '{{ route('upload.image') }}', formData, id, key, lang, update, url);
                    ajaxRequest.request(); --}}
{{-- function upload_file(){
                $.ajax({
                    type: 'POST',
                    url: '{{ route('upload_file') }}',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token()}}'
                    },
                    data: new FormData($('#upload_form')[0]), 
                    processData: false, 
                    contentType: false,
                    success: function(data){
                        swal.fire({
                            title: '檔案上傳成功',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1000,
                        }).then(function(){
                            
                        })                       
                    },
                    error: function(data) {
                        var error = data.responseJSON;
                        console.log(error)
                    }
                })
            } --}}