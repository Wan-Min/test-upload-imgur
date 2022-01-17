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
                <button class="btn btn-outline-secondary" type="button" id="testAccess" onclick="getAccessToken()">Get Access Token</button>
                <form class="form" id="upload_form">
                    <div class="form-group">
                        <div id="album_ans">
                        </div>
                        <div class="input-group">
                            <input type="text" name="album" id="setAlbum" class="form-control" placeholder="Album ID" aria-label="Album ID" aria-describedby="button-album">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="button-album">Check</button>
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="file" class="custom-file-input" id="uploadImageFile" aria-describedby="button-upload">
                                <label class="custom-file-label" for="uploadImageFile">Choose File</label>
                            </div>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="button-upload">Upload</button>
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
            function getAccessToken(){
                let now_time = new Date();
                var last_time = new Date(localStorage.getItem('lastTime'));
                var difference_day = Math.abs(now_time-last_time)/(1000 * 3600 * 24);
                if(difference_day >= '25'){
                    var formData = new FormData();
                    formData.append('refresh_token', localStorage.getItem('refreshToken'));
                    var ajaxRequest = new ajaxGetAccessToken('POST', '{{ route('access.token') }}',formData);
                    ajaxRequest.request();
                }
            }

            $('#button-upload').on('click',function(){
                var formData = new FormData();
                var file = document.getElementById('uploadImageFile').files[0];
                var album = $('#setAlbum').val();
                formData.append('album', album);
                formData.append('file', file);
                formData.append('refresh_token', localStorage.getItem('refreshToken'));
                formData.append('access_token', localStorage.getItem('accessToken'));
                var ajaxRequest = new ajaxUploadImage('POST', '{{ route('upload.image') }}',formData);
                ajaxRequest.request();
            })

            $('#button-album').on('click',function(){
                var formData = new FormData();
                var album = $('#setAlbum').val();
                formData.append('album', album);
                formData.append('refresh_token', localStorage.getItem('refreshToken'));
                formData.append('access_token', localStorage.getItem('accessToken'));
                var ajaxRequest = new ajaxCheckAlbum('POST', '{{ route('check.album') }}',formData);
                ajaxRequest.request();
            })
        </script>
    </body>
</html>
{{-- if(difference_day >= '25'){
                    var formData = new FormData();
                    formData.append('refresh_token', localStorage.getItem('refreshToken'));
                    var ajaxRequest = new ajaxGetAccessToken('POST', '{{ route('access.token') }}',formData);
                    ajaxRequest.request();
                } --}}
                