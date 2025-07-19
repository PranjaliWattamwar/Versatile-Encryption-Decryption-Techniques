<?php
?>
<html>
<head>
    <title>Image Encryption and Decryption</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.min.js"></script>
    <script>
        function encryptImage() {
            var fileInput = document.getElementById("image");
            var file = fileInput.files[0];
            var reader = new FileReader();
            reader.onload = function(event) {
                var key = "This is a secret key"; // Change this to your own secret key
                var iv = CryptoJS.lib.WordArray.random(16);
                var encryptedData = CryptoJS.AES.encrypt(event.target.result, key, { iv: iv });
                var encryptedImage = document.getElementById("encryptedImage");
                encryptedImage.src = "data:image/jpeg;base64," + encryptedData;
                encryptedImage.dataset.iv = iv.toString();
            };
            reader.readAsDataURL(file);
        }

        function decryptImage() {
            var encryptedImage = document.getElementById("encryptedImage");
            var key = "This is a secret key"; // Change this to your own secret key
            var iv = CryptoJS.enc.Hex.parse(encryptedImage.dataset.iv);
            var encryptedData = CryptoJS.enc.Base64.parse(encryptedImage.src.split(",")[1]);
            var decryptedData = CryptoJS.AES.decrypt({ ciphertext: encryptedData }, key, { iv: iv });
            var decryptedImage = document.getElementById("decryptedImage");
            decryptedImage.src = "data:image/jpeg;base64," + decryptedData;
        }
    </script>
</head>
<body>
    <h1>Image Encryption and Decryption using AES</h1>
    <h2>Encryption</h2>
    <input type="file" name="image" id="image" accept="image/*" />
    <br /><br />
    <button type="button" onclick="encryptImage()">Encrypt</button>
    <br /><br />
    <img id="encryptedImage" />
    <br /><br />
    <h2>Decryption</h2>
    <button type="button" onclick="decryptImage()">Decrypt</button>
    <br /><br />
    <img id="decryptedImage" />
</body>
</html>
