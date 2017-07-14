<?php
namespace Phidias\Icons;
use Intervention\Image\ImageManagerStatic as Image;

class Controller
{
    public function getList($prefix)
    {
        $characters = include realpath(dirname(__FILE__)."/../webfonts/$prefix/characters.php");
        return array_keys($characters);
    }

    public function get($prefix, $size, $color, $icon, $response)
    {
        if (!is_numeric($size)) {
            $size = 128;
        }
        $size = min($size, 2048);

        $info      = pathinfo($icon);
        $iconName  = $info["filename"];
        $extension = isset($info["extension"]) ? $info["extension"] : "png";

        $ttf        = realpath(dirname(__FILE__)."/../webfonts/$prefix/webfont.ttf");
        $characters = include realpath(dirname(__FILE__)."/../webfonts/$prefix/characters.php");

        if (!isset($characters[$iconName])) {
            return [$prefix, $size, $color, $iconName];
            return $response->status(404);
        }

        $iconChar = html_entity_decode('&#'.$characters[$iconName].';');

        $canvas = Image::canvas($size, $size);

        /* !!! Godammit!  fix alignment issues: */
        $offsetX = $prefix == 'md' ? $size/2 - $size/12 : $size/2;

        $canvas->text($iconChar, $offsetX, $size/2, function($font) use ($ttf, $size, $color) {
            $font->file($ttf);
            $font->size($size);
            $font->color('#'.$color);
            $font->align('center');
            $font->valign('center');
        });

        $filename = "/icons/{$prefix}/{$size}/{$color}/{$iconName}.{$extension}";
        $targetFile = realpath(".").$filename;
        @mkdir(pathinfo($targetFile)["dirname"], 0777, true);

        $canvas->save($targetFile);
        echo $canvas->response();
        return;
    }
}