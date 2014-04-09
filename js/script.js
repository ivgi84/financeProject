$(function(){

    function progressHandlingFunction(e){
        if(e.lengthComputable){
            $('progress').attr({value:e.loaded,max:e.total});
        }
    }

    $("#sendBtn").on("click",function(){

        var formData= new FormData($('form')[0]);

        console.log(formData);

        $.ajax({
            url:"CouponUploadFn.php",
            type:"POST",

            xhr: function() {  // Custom XMLHttpRequest
                var myXhr = $.ajaxSettings.xhr();
                if(myXhr.upload){ // Check if upload property exists
                    myXhr.upload.addEventListener('progress',progressHandlingFunction, false); // For handling the progress of the upload
                }
                return myXhr;
            },
            beforeSend:function(){
                $("progress").removeClass('hidden');
                $("#sendBtn").text("Sending...");
            },
            success:function(msg){
                $("#userMsg").html(msg);
            },
            error:function(){
                alert("Error while sending");
            },
            complete:function(){
                $("progress").addClass('hidden');
                $("#sendBtn").text("Send");
            },
            timeout:3000,
            data:formData,
            cache: false,
            contentType: false,
            processData: false

        });
    });

    setInterval(function(){
        if($("#userMsg").length>0){
            $("#userMsg").empty();
        }
    },80000);

});
