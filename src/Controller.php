<?php
namespace Phidias\Icons;
use Intervention\Image\ImageManagerStatic as Image;

class Controller
{
    public function getList($provider)
    {
        $characters = include realpath(dirname(__FILE__)."/../webfonts/fontawesome/characters.php");
        return array_keys($characters);
    }

    public function get($icon, $request, $response)
    {
        $info      = pathinfo($icon);
        $iconName  = $info["filename"];
        $extension = isset($info["extension"]) ? $info["extension"] : "png";
        $size      = $request->getParameter("size",  512);
        $color     = trim($request->getParameter("color", "777"), '#');

        $filename       = "icons/{$iconName}_{$size}_{$color}.{$extension}";
        $targetFolder   = realpath(".");

        $protocol       = isset($_SERVER["HTTP_X_FORWARDED_PROTO"]) ? $_SERVER["HTTP_X_FORWARDED_PROTO"] : (isset($_SERVER["HTTPS"]) ? "https" : "http");
        $targetLocation = $protocol."://".$_SERVER["HTTP_HOST"].dirname($_SERVER["SCRIPT_NAME"])."/".$filename;

        if (is_file($targetFolder.'/'.$filename)) {
            return $response
                ->status(301)
                ->header("Location", $targetLocation);
        }

        $prefix     = explode("-", $iconName, 2)[0];
        $ttf        = realpath(dirname(__FILE__)."/../webfonts/$prefix/webfont.ttf");
        $characters = include realpath(dirname(__FILE__)."/../webfonts/$prefix/characters.php");

        if (!isset($characters[$iconName])) {
            return $response->status(404);
        }

        $iconChar = html_entity_decode('&#'.$characters[$iconName].';');

        $canvas = Image::canvas($size, $size);

        $canvas->text($iconChar, $size/2, $size/2, function($font) use ($ttf, $size, $color) {
            $font->file($ttf);
            $font->size($size-2);
            $font->color('#'.$color);
            $font->align('center');
            $font->valign('center');
        });

        $canvas->save($targetFolder.'/'.$filename);

        return $response
            ->status(301)
            ->header("Location", $targetLocation);
    }
}