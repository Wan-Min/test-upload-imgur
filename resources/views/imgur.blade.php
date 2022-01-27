<!DOCTYPE html>
<html lang="en">
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
                <ul>
                    <li>建立專案時我會在 localstorage 裡面加上 accessToken、refreshToken、lastTime 三個參數</li>
                    <li>若要查看 token 右鍵 → 檢查 → Application → Local Storage 可查看但不要刪除</li>
                    <li>使用 Local Storage 的原因是他跟 Cookie 及 Session 不一樣，他不會過期也沒有存取限制</li>
                    <li>Imgur 的 token 期限是 1 個月，系統在每次取用時會判定 25 天自動更換一次，避免過期</li>
                    <li>目前的 Imgur 是 https://wwwanmin.imgur.com/all/ (我的XD) 之後可以依客戶為主</li>
                    ( a.開沅樸 imgur 帳號分別開客戶相簿; b.分別開客戶的 imgur 帳號，為了管理方便推 a 方案 )
                    <li>取得相簿 ID 方法 進入 imgur 相簿 → Edit this album → Embed Album → 取得整串 url 後找到 data-id="a/C3BKKNU"，C3BKKNU 為相簿 ID</li>
                    <li>取得照片 ID 方法 進入 imgur 相簿 → 點進照片後複製 Image Link → https://imgur.com/Wb0aodb，Wb0aodb 為相片 ID</li>
                    <li>若有輸入相簿 ID 則會上傳到指定相簿，若沒有輸入相簿 ID 則會上傳至無相簿分類</li>
                </ul>
                {{-- <button class="btn btn-outline-secondary" type="button" id="testAccess" onclick="getAccessToken()">Get Access Token</button> --}}
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
                        <div id="upload_ans">
                        </div>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="file" class="custom-file-input" id="uploadImageFile" aria-describedby="button-upload">
                                <label class="custom-file-label" id="uploadImageFileLabel" for="uploadImageFile">Choose File</label>
                            </div>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="button-upload">Upload</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div>
                    <img id="image_holder" src="" alt="" referrerpolicy="no-referrer">
                </div>
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
            //check token life time
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

            //upload image to imgur
            $('#button-upload').on('click',function(){
                getAccessToken();
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

            //監聽 filie 變化
            document.querySelector('.custom-file-input').addEventListener('change',function(e){
                var fileName = document.getElementById("uploadImageFile").files[0].name;
                var nextSibling = e.target.nextElementSibling
                nextSibling.innerText = fileName
            })

            //check album isset
            $('#button-album').on('click',function(){
                getAccessToken();
                var album = $('#setAlbum').val();
                if(album != ''){
                    var formData = new FormData();
                    formData.append('album', album);
                    formData.append('refresh_token', localStorage.getItem('refreshToken'));
                    formData.append('access_token', localStorage.getItem('accessToken'));
                    var ajaxRequest = new ajaxCheckAlbum('POST', '{{ route('check.album') }}',formData);
                    ajaxRequest.request();
                }
                else{
                    $('#album_ans').html('');
                    $('#album_ans').append('<span class="badge badge-warning">Please enter the album ID.</span>');
                }
            })
        </script>
    </body>
</html>
                