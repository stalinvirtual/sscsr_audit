<?php
namespace App\Helpers;
class EncryptionSecurity
{


   
    protected $encryptMethod = 'AES-256-CBC';


    public function decrypt(string $encryptedString, string $key)
    {
        $json = json_decode((string) base64_decode($encryptedString), true);

        // check array keys must exists to prevent errors.
        if (
            !is_array($json) || 
            !array_key_exists('salt', $json) || 
            !array_key_exists('iv', $json) ||
            !array_key_exists('ciphertext', $json) ||
            !array_key_exists('iterations', $json)
        ) {
            return null;
        }

        try {
            $salt = hex2bin($json['salt']);
            $iv = hex2bin($json['iv']);
        } catch (\Exception $e) {
            return null;
        }

        $cipherText = base64_decode($json['ciphertext']);

        $iterations = intval(abs((int)$json['iterations']));
        if ($iterations <= 0) {
            $iterations = 999;
        }
        $hashKey = hash_pbkdf2('sha512', $key, $salt, $iterations, ($this->encryptMethodLength() / 4));
        unset($iterations, $json, $salt);

        $decrypted= openssl_decrypt($cipherText , $this->encryptMethod, hex2bin($hashKey), OPENSSL_RAW_DATA, $iv);
        if (!is_string($decrypted)) {
            $decrypted = null;
        }
        unset($cipherText, $hashKey, $iv);

        return $decrypted;
    }// decrypt


  
    public function encrypt(string $string, string $key): string
    {
        $ivLength = openssl_cipher_iv_length($this->encryptMethod);
        $iv = openssl_random_pseudo_bytes($ivLength);
 
        $salt = openssl_random_pseudo_bytes(256);
        $iterations = 999;
        $hashKey = hash_pbkdf2('sha512', $key, $salt, $iterations, ($this->encryptMethodLength() / 4));

        $encryptedString = openssl_encrypt($string, $this->encryptMethod, hex2bin($hashKey), OPENSSL_RAW_DATA, $iv);

        $encryptedString = base64_encode($encryptedString);
        unset($hashKey);

        $output = ['ciphertext' => $encryptedString, 'iv' => bin2hex($iv), 'salt' => bin2hex($salt), 'iterations' => $iterations];
        unset($encryptedString, $iterations, $iv, $ivLength, $salt);

        return base64_encode(json_encode($output));
    }// encrypt


    /**
     * Get encrypt method length number (128, 192, 256).
     * 
     * @return integer.
     */
    protected function encryptMethodLength(): int
    {
        $number = (int) filter_var($this->encryptMethod, FILTER_SANITIZE_NUMBER_INT);

        return intval(abs($number));
    }// encryptMethodLength


   
    public function setCipherMethod(string $cipherMethod)
    {
        $this->encryptMethod = $cipherMethod;
    }// setCipherMethod


}
?>