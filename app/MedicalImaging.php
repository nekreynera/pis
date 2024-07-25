<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalImaging extends Model
{


    public static function createThumbnail($category, $filename) {

        $thumbs_size = 100;
        $img_path = "../img/clinic/" . $category . "/";
        $thumbs_path = "../img/clinic/" . $category. "/thumbs/";

        if(preg_match("/[.](jpg)$/", $filename)) {
            $im = imagecreatefromjpeg($img_path . $filename);
        } else if (preg_match("/[.](gif)$/", $filename)) {
            $im = imagecreatefromgif($img_path . $filename);
        } else if (preg_match("/[.](png)$/", $filename)) {
            $im = imagecreatefrompng($img_path . $filename);
        }

        $ox = imagesx($im);
        $oy = imagesy($im);

        $nx = $thumbs_size;
        $ny = floor($oy * ($thumbs_size / $ox));

        $nm = imagecreatetruecolor($nx, $ny);

        imagecopyresized($nm, $im, 0,0,0,0,$nx,$ny,$ox,$oy);

        if(!file_exists($thumbs_path)) {
            if(!mkdir($thumbs_path)) {
                return false;
            }
        }

        imagejpeg($nm, $thumbs_path . $filename);

        return true;
    }
}
