<?php

namespace App\Controllers;

use App\Controllers\FrontEndController;
use App\System\Route;

class Api extends FrontEndController
{
    /** all api and non header contents comes here */
    public function generate_code()
    {
        $length = '6';
        $chars = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'j', 'k', 'm', 'n', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '2', '3', '4', '5', '6', '7', '8', '9', ',', '@', '$');
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            $code .= $chars[rand(0, count($chars) - 1)];
        }
        $_SESSION['captcha'] = $code;
        return $code;
    }
    public function security_image()
    {
        $code = isset($_SESSION['captcha']) ? $_SESSION['captcha'] : $this->generate_code();
        $font = 'content/fonts/comic.ttf';
        $width = '110';
        $height = '20';
        $font_size = $height * 0.75;
        $image = @imagecreate($width, $height) or die('GD not installed');
        $background_color = imagecolorallocate($image, 0, 0, 0);
        $text_color = imagecolorallocate($image, 233, 14, 91);
        $textbox = imagettfbbox($font_size, 0, $font, $code);
        $x = ($width - $textbox[4]) / 2;
        $y = ($height - $textbox[5]) / 2;
        imagettftext($image, $font_size, 0, $x, $y, $text_color, $font, $code);
        header('Content-Type: image/png');
        imagepng($image);
        imagedestroy($image);
    }
    public function loadcaptcha()
    {
        $random_alpha = md5(rand());
        $captcha_code = substr($random_alpha, 0, 6);
        $_SESSION["captcha_code"] = $captcha_code;
        $target_layer = imagecreatetruecolor(70, 30);
        $captcha_background = imagecolorallocate($target_layer, 169, 68, 66);
        imagefill($target_layer, 0, 0, $captcha_background);
        $captcha_text_color = imagecolorallocate($target_layer, 0, 0, 0);
        imagestring($target_layer, 5, 5, 5, $captcha_code, $captcha_text_color);
        header("Content-type: image/jpeg");
        imagepng($target_layer);
        imagedestroy($target_layer);
        exit;
    }
   
}
