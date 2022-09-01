<?php

use PHPCrypter\Encryption\Encryption;
use PHPUnit\Framework\TestCase;
class EncryptionTest extends Testcase{
    
    public function test_if_data_is_encrypted(){

        $data = "Failing to realize everything, we can imagine everything";
        $encrypt = Encryption::encrypt($data);

        $this->assertTrue(is_string($encrypt) && strlen($encrypt) >= strlen($data));

    }

    public function test_if_data_is_decrypted(){
        $data = "Failing to realize everything, we can imagine everything";
        $encrypt = Encryption::encrypt($data);

        $decrypt = Encryption::decrypt($encrypt);

        $this->assertEquals($data, $decrypt);
    }
}