<?php

    function generateEncryptedText($textToEncrypt,$encryptionKey){
        //some input validation
        if($encryptionKey==null){
            return false;
        }
        $textValid = validateString($textToEncrypt);
        $keyValid = validateString($encryptionKey);
        if ($textValid===false || $keyValid===false){
            return false;
        }
        
        $encryptedText = '';
        $text_length = strlen($textToEncrypt);
        $key_length = strlen($encryptionKey);

        for ($x = 0; $x <= ($text_length-1); $x++){
            $keyPosition = keyPositionWrap($key_length,$x); //A check incase the key position needs to wrap back to the start

            $n = $x + ord( substr($encryptionKey,$keyPosition,1) ); //Adds the position with the ASCII value of the key in the same position
            
            $prime = getPrimeNumber($n); //Uses the function to calculates the sum of nth prime numbers
            
            $encrptedCharacterVal = $prime + $x + ord(substr($textToEncrypt,$x,1)); //Apply encryption algorithm
            $encryptedAsciiValue = asciiWrapValue($encrptedCharacterVal); 
            $encrptedCharacter = chr($encryptedAsciiValue); //casts ASCII value to character

            $encryptedText .= $encrptedCharacter;
        }
        return $encryptedText;
    }

    function validateString($string){
        $string_length = strlen($string) - 1;

        for ($x = 0; $x <= $string_length; $x++){
            $charValue = ord(substr($string,$x,1));
            if ($charValue < 32 || $charValue > 126){
                return false;
            }
        }
        return true;
    }

    function keyPositionWrap($key_length,$iteration){
        if( ($key_length-1) < $iteration ) {
            $keyPosition = $iteration - $key_length;
            
            while ($keyPosition >= $key_length-1){
              $keyPosition -= $key_length;
            }
        } else {
            $keyPosition = $iteration;
        }
        return $keyPosition;
    }

    function getPrimeNumber($n){
        if ($n < 1) {
            return false;
        }
        $primes = [];
        $i = 2;
        while (count($primes) < $n) {
            foreach ($primes as $prime) {
                if ($i % $prime == 0) {
                    $i++;
                    continue 2;
                }
            }
            $primes[]=$i++;
        }
        return end($primes);
    }

    function asciiWrapValue($asciiNumber) {
        if( $asciiNumber > 126){
            while ($asciiNumber > 126){
                $asciiNumber -= 95;
            }
        }
    return $asciiNumber;
    }

    function decryptText($encryptedText,$encryptionKey){
        //some input validation
        if($encryptionKey==null){
            return false;
        }
        $textValid = validateString($encryptedText);
        $keyValid = validateString($encryptionKey);
        if ($textValid===false || $keyValid===false){
            return false;
        }

        $decryptedText = '';
        $encrypted_text_length = strlen($encryptedText);
        $key_length = strlen($encryptionKey);

        for ($x = 0; $x <= ($encrypted_text_length-1); $x++){
            $keyPosition = keyPositionWrap($key_length,$x); //A check incase the key position needs to wrap back to the start
            
            $keyCharVal = ord(substr($encryptionKey,$keyPosition,1));
            $n = $x + $keyCharVal; //adds the position with the ASCII value of the key in the same position
            
            $prime = getPrimeNumber($n);
            $encryptedCharVal = ord(substr($encryptedText,$x,1)); //cast character to ASCII value

            while($encryptedCharVal < $prime){
                $encryptedCharVal += 95;
            }
            $decryptedTextVal = ($encryptedCharVal - $prime) - $x;
            if ($decryptedTextVal < 32){
                $decryptedTextVal += 95;
            }
            $decryptedCharacter = chr($decryptedTextVal); //casts ASCII value to character
            $decryptedText .= $decryptedCharacter;
        }
        return $decryptedText;
    }
  
?>