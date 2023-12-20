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
    public function loadcaptchaold()
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
    public function loadcaptchanew()
    {

        // $captcha_code  = strtoupper(bin2hex(random_bytes(3)));
        $captchanumber = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789'; // Initializing PHP variable with string
        $captcha_code = substr(str_shuffle($captchanumber), 0, 6);
        // $random_alpha = md5($rand); //generation of random string
// /** Generate a captcha of length 6 */
// $captcha_code = substr($random_alpha, 0, 6);
        $_SESSION["captcha_code"] = $captcha_code;
        $rand = random_int(0, 10);
        /* Width and Height of captcha */
        $target_layer = imagecreatetruecolor(170, 50);
        /* Background color of captcha */
        $captcha_background = imagecolorallocate($target_layer, 240, 255, 255);
        imagefill($target_layer, 0, 0, $captcha_background);
        /* Captcha Text Color RGB */
        $captcha_text_color = imagecolorallocate($target_layer, 39, 55, 70);

        /* Text size and properties */
        $font_size = 18;
        $img_width = 80;
        $img_height = 0;
        /** For Lines */
        $line_color = imagecolorallocate($target_layer, 64, 60, 64);
        for ($i = 0; $i < 6; $i++) {
            imageline($target_layer, 0, 0, 840, 250, $line_color);
        }

        /* For pixels */
        $pixel_color = imagecolorallocate($target_layer, 0, 0, 255);
        for ($i = 0; $i < 1000; $i++) {
            imagesetpixel($target_layer, random_int(0, 170), random_int(0, 50), $pixel_color);
        }

        /* Text Size */
        /* you are the one is a font file */
        imagettftext($target_layer, $font_size, 0, 10, 33, $captcha_text_color, './default/templates/captcha/code2002.ttf', $captcha_code);
        $target_layer;

        header("Content-type: image/jpeg");
        imagejpeg($target_layer);
    }
public function loadcaptcha()
{
    $captchanumber = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    $captcha_code = substr(str_shuffle($captchanumber), 0, 6);
    $_SESSION["captcha_code"] = $captcha_code;

    $target_layer = imagecreatetruecolor(170, 50);
    $captcha_background = imagecolorallocate($target_layer, 240, 255, 255);
    imagefill($target_layer, 0, 0, $captcha_background);

    $captcha_text_color = imagecolorallocate($target_layer, 39, 55, 70);

    $font_size = 18;
    $img_width = 80;
    $img_height = 0;

    $line_color = imagecolorallocate($target_layer, 64, 60, 64);
    for ($i = 0; $i < 6; $i++) {
        imageline($target_layer, 0, 0, 170, 50, $line_color);
    }

    $pixel_color = imagecolorallocate($target_layer, 0, 0, 255);
    for ($i = 0; $i < 1000; $i++) {
        imagesetpixel($target_layer, random_int(0, 170), random_int(0, 50), $pixel_color);
    }

    imagettftext($target_layer, $font_size, 0, 10, 33, $captcha_text_color, './default/templates/captcha/code2002.ttf', $captcha_code);

    header("Content-type: image/jpeg");
    imagejpeg($target_layer);
    imagedestroy($target_layer);
}
    public function loadcaptcha3()
    {

        $captcha_code = '';
        $captcha_image_height = 50;
        $captcha_image_width = 130;
        $total_characters_on_image = 6;

        //The characters that can be used in the CAPTCHA code.
//avoid all confusing characters and numbers (For example: l, 1 and i)
        $possible_captcha_letters = 'bcdfghjkmnpqrstvwxyz23456789';
        $captcha_font = 'C:\xampp\htdocs\sscsr_audit\site\default\templates\monofont.ttf';

        $random_captcha_dots = 50;
        $random_captcha_lines = 25;
        $captcha_text_color = "0x142864";
        $captcha_noise_color = "0x142864";


        $count = 0;
        while ($count < $total_characters_on_image) {
            $captcha_code .= substr(
                $possible_captcha_letters,
                mt_rand(0, strlen($possible_captcha_letters) - 1),
                1);
            $count++;
        }

        $captcha_font_size = $captcha_image_height * 0.65;
        $captcha_image = @imagecreate(
            $captcha_image_width,
            $captcha_image_height
        );

        /* setting the background, text and noise colours here */
        $background_color = imagecolorallocate(
            $captcha_image,
            255,
            255,
            255
        );

        $array_text_color = $this->hextorgb($captcha_text_color);
        $captcha_text_color = imagecolorallocate(
            $captcha_image,
            $array_text_color['red'],
            $array_text_color['green'],
            $array_text_color['blue']
        );

        $array_noise_color = $this->hextorgb($captcha_noise_color);
        $image_noise_color = imagecolorallocate(
            $captcha_image,
            $array_noise_color['red'],
            $array_noise_color['green'],
            $array_noise_color['blue']
        );

        /* Generate random dots in background of the captcha image */
        for ($count = 0; $count < $random_captcha_dots; $count++) {
            imagefilledellipse(
                $captcha_image,
                mt_rand(0, $captcha_image_width),
                mt_rand(0, $captcha_image_height),
                2,
                3,
                $image_noise_color
            );
        }

        /* Generate random lines in background of the captcha image */
        for ($count = 0; $count < $random_captcha_lines; $count++) {
            imageline(
                $captcha_image,
                mt_rand(0, $captcha_image_width),
                mt_rand(0, $captcha_image_height),
                mt_rand(0, $captcha_image_width),
                mt_rand(0, $captcha_image_height),
                $image_noise_color
            );
        }

        /* Create a text box and add 6 captcha letters code in it */
        $text_box = imagettfbbox(
            $captcha_font_size,
            0,
            $captcha_font,
            $captcha_code
        );
        $x = ($captcha_image_width - $text_box[4]) / 2;
        $y = ($captcha_image_height - $text_box[5]) / 2;
        imagettftext(
            $captcha_image,
            $captcha_font_size,
            0,
            $x,
            $y,
            $captcha_text_color,
            $captcha_font,
            $captcha_code
        );

        /* Show captcha image in the html page */
        // defining the image type to be shown in browser widow
        header('Content-Type: image/jpeg');
        imagejpeg($captcha_image); //showing the image
       // imagedestroy($captcha_image); //destroying the image instance
      //  $_SESSION['captcha_code'] = $captcha_code;


    }
    public function hextorgb($hexstring)
    {
        $integar = hexdec($hexstring);
        return array("red" => 0xFF & ($integar >> 0x10),
            "green" => 0xFF & ($integar >> 0x8),
            "blue" => 0xFF & $integar);
    }
}
