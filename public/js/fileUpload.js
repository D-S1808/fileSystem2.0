$(document).ready(function () {
    $('#submitFiles').on('submit', function (e) {
        e.preventDefault();
        var file = document.getElementById('formFileInput').files[0];
        var reader = new FileReader();

        reader.onload = function (e) {
            var arrayBuffer = e.target.result;
            var bytes = new Uint8Array(arrayBuffer);
            var binaryData = '';
            for (var i = 0; i < bytes.byteLength; i++) {
                binaryData += String.fromCharCode(bytes[i]);
            }

            // Encode binary data to Base64 string
            var base64Data = btoa(binaryData);
            
            console.log(binaryData);

            // Send Base64 encoded data to the server
            $.ajax({
                url: 'fileUpload.php',
                type: 'POST',
                data: { fileData: base64Data, fileName: file.name, fileType: file.type },
                success: function (response) {
                    $('#message').text(response);
                },
                error: function () {
                    $('#message').text('Error uploading file');
                }
            });
        };

        reader.readAsArrayBuffer(file); // Read the file as an ArrayBuffer
    });
});