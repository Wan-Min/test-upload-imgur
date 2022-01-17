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
                    // errorsHtml = '';
                    // errorsHtml += '<li>'+ error.errors +'</li>';
                    
                    Swal.fire({
                        html: '<span class="f-family" style="color: #707070;font-size: 14px;font-weight:600;">'+errorsHtml+'</span>',
                        icon: 'error',
                        showConfirmButton: false,
                        width: '300px',
                        heightAuto: false,
                    })
                },
                success: function(data) {
                    console.log(data.link)
                    Swal.fire({
                        title: '上傳成功',
                        icon: 'success',
                        showCancelButton: false,
                        showConfirmButton: false,
                        timer: 970,
                        width: '300px',
                        heightAuto: false 
                    })
                    // .then(function(){
                        // if(id.split('_').length > 1 || update){
                        //     $('#'+id).attr('src',data)
                        // }
                        // else{
                            // $('#show_create_image').html('');
                            // $('#show_create_image').append('<img class="img-responsive img-shadow" style="object-fit: cover;width: 100%;height: 10rem !important;" name="image" id="uploadImage" src="'+data+'">');
                            // $('#create_image').val(data)
                        // }
                        
                        // if(update){
                        //     $.ajax({
                        //         method: 'PUT',
                        //         url: route,
                        //         headers: {
                        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        //         },
                        //         async: false,
                        //         data: {
                        //             image: data,
                        //             lang: lang,
                        //             key: key,
                        //             migration: migration
                        //         }
                        //     }) 
                        // }
                    // })
                }
            });
        }
    }
}