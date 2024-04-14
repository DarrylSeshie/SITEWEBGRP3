<?php
class Image
{
    public $id_image;
    public $url_image;

    public function __construct($array = null)
    {
        if ($array != null) {
            $this->setIdImage($array["id_image"]);
            $this->setUrlImage($array["url_image"]);
        }
    }

    public function getIdImage()
    {
        return $this->id_image;
    }

    public function setIdImage($id_image)
    {
        $this->id_image = intval($id_image);
    }

    public function getUrlImage()
    {
        return $this->url_image;
    }

    public function setUrlImage($url_image)
    {
        $this->url_image = $url_image;
    }
}
?>