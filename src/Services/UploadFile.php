<?php
namespace App\Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UploadFile extends AbstractController
{
    public function generate_name($lenght = 20){
        $code = "3a7ze2rt0yu8io4pq9sd0f1ghj6k0lm5nb7vcx3w";
        $result = "";

        while (strlen($result) < 20) {
            $result .= $code[rand(0, strlen($code)-1)];
        }

        return $result;

    }

    public function saveFile($file){
        $extension = $file->guessExtension();
        $filename = $this->generate_name(30).".".$extension;
        //$filename = $file->getClientOriginalName();
        $file->move($this->getParameter('image_dir'), $filename);

        return '/_assets/images/articles/'.$filename;
    }

    public function updateFile($file, $oldFile){
        $file_url = $this->saveFile($file);
        try {
            unlink($this->getParameter('static_dir').$oldFile);
        } catch (\Throwable $th) {
            //throw $th;
        }
        return $file_url;
    }
}

?>