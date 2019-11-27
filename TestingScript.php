<?php
    require 'EncryptionTask.php';
    
    $textToEncryptTest1 = "hello world!";
    $encyptionKeyTest1 = "thekey";
    
    $textToEncryptTest2 = "testing98765[]~";
    $encyptionKeyTest2 = "test";

    $textToEncryptTest3 = "Hello, How are you today?";
    $encyptionKeyTest3 = "MORNING";

    test($textToEncryptTest1,$encyptionKeyTest1);
    test($textToEncryptTest2,$encyptionKeyTest2);
    test($textToEncryptTest3,$encyptionKeyTest3);

    function test($textToEncrypt,$encyptionKey){
        $textEncrypted = generateEncryptedText($textToEncrypt,$encyptionKey);
        $textDecrypted = decryptText($textEncrypted,$encyptionKey);
        echo "Input Text:".$textToEncrypt."  Encyption Key:".$encyptionKey."\r\n";  
        echo "Encrypted Text:".$textEncrypted."   Decrypted Text:".$textDecrypted; 
        echo "  ||  \r\n\r\n";
    }
?>