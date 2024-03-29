function ajaxUploadImage(method, url, data){
    return {
        method: method,
        url: url,
        data: data,
        request: function request() {
            $.ajax({
                type: this.method,
                url: this.url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: this.data,
                processData : false, // 告訴jQuery不要去處理髮送的資料
                contentType : false, // 告訴jQuery不要去設定Content-Type請求頭
                mimeType: 'multipart/form-data',
                async: false,
                error: function(data) {
                    var error = data.responseJSON;
                    console.log(data)
                    console.log(error)
                    $('#upload_ans').html('');
                    $('#upload_ans').append('<span class="badge badge-danger">Upload faild.</span>');
                },
                success: function(data) {
                    let dataItem = JSON.parse(data);
                    $('#upload_ans').html('');
                    $('#upload_ans').append('<span class="badge badge-success">Upload success.</span>');
                    $('#image_holder').attr('src',dataItem.file);
                }
            });
        }
    }
}

function ajaxCheckAlbum(method, url, data){
    return {
        method: method,
        url: url,
        data: data,
        request: function request() {
            $.ajax({
                type: this.method,
                url: this.url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: this.data,
                processData : false, // 告訴jQuery不要去處理髮送的資料
                contentType : false, // 告訴jQuery不要去設定Content-Type請求頭
                mimeType: 'multipart/form-data',
                async: false,
                error: function(data) {
                    $('#album_ans').html('');
                    $('#album_ans').append('<span class="badge badge-danger">This album was not found.</span>');
                    var error = data.responseJSON;
                    console.log(data)
                    console.log(error)
                },
                success: function(data) {
                    $('#album_ans').html('');
                    $('#album_ans').append('<span class="badge badge-success">Verification succeeded.</span>');
                }
            });
        }
    }
}

function ajaxGetAccessToken(method, url, data){
    return {
        method: method,
        url: url,
        data: data,
        request: function request() {
            $.ajax({
                type: this.method,
                url: this.url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: this.data,
                processData : false, // 告訴jQuery不要去處理髮送的資料
                contentType : false, // 告訴jQuery不要去設定Content-Type請求頭
                mimeType: 'multipart/form-data',
                async: false,
                error: function(data) {
                    var error = data.responseJSON;
                    console.log(data)
                    console.log(error)
                },
                success: function(data) {
                    console.log(JSON.parse(data))
                    let dataItem = JSON.parse(data);
                    $date = new Date();
                    localStorage.removeItem('accessToken');
                    localStorage.removeItem('refreshToken');
                    localStorage.removeItem('lastTime');
                    localStorage.setItem('refreshToken', dataItem.refreshToken);
                    localStorage.setItem('accessToken', dataItem.accessToken);
                    localStorage.setItem('lastTime', JSON.stringify($date));
                }
            });
        }
    }
}