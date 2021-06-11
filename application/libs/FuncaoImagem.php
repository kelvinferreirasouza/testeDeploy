<?php

namespace Ops\libs;

use WideImage\WideImage;

class FuncaoImagem
{

    function wideImagePhoto($search, $path, $width, $height, $name = null, $ext, $quality = null)
    {

        $file = $search;
        $size = getimagesize($file);


        //load da imagem
        $image = WideImage::load($search);

        //redimensiona a imagem para o tamanho mais próximo

        $resized = $image->resize($width, $height, 'outside');



        //corta as imagem
        $cropped = $resized->crop('center', 'center', $width, $height);


        //salva as imagem
        if ($quality) {
            $cropped->saveToFile($path . $name . $ext, $quality);
        } else {
            $cropped->saveToFile($path . $name . $ext);
        }
    }
}
