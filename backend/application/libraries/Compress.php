<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Compress {
    
    // @var file_url
    public $file_url;

    // @var new_name_image
    public $new_name_image;

    // @var quality
    public $quality;
    
    // @var destination
    public $destination;

    public function __construct($file_url = null, $new_name_image = null, $quality = null, $destination = null) {
        $this->file_url = $file_url;
        $this->new_name_image = $new_name_image;
        $this->quality = $quality;
        $this->destination = $destination;
    }
    
    /**
     * Function to compress image
     * @return array
     * @throws Exception
     */
    public function compress_image(){
        
        //Send image array
        $array_img_types = array('image/gif', 'image/jpeg','image/jpg', 'image/pjpeg', 'image/png', 'image/x-png');
        $new_image = null;
        $last_char = null;
        $image_extension = null;
        $destination_extension = null;
        $png_compression = 3;
        $real_path_file = parse_url($this->file_url, PHP_URL_PATH);
        $real_destination = $_SERVER['DOCUMENT_ROOT'].parse_url($this->destination, PHP_URL_PATH);
        $result = array();
        
        try{
            
            //If not found the file
            if(empty($this->file_url) && !file_exists($this->file_url)){
                throw new Exception('Please inform the image!');
                return false;
            }
            // echo $real_path_file;exit();
            //Get image width, height, mimetype, etc..
            $image_data = getimagesize($real_path_file);
            // pre($image_data);exit;
            //Set MimeType on variable
            $image_mime = $image_data['mime'];
            
            //Verifiy if the file is a image
            if(!in_array($image_mime, $array_img_types)){
                throw new Exception('Please send a image!');
                return false; 
            }
            // echo 
            //Get file size
            $image_size = filesize($real_path_file);
                                    
            //if image size is bigger than 5mb
            if($image_size > 10485760){
                throw new Exception('Please send a imagem smaller than 5mb!');
                return false;
            }
            
            //If not found the destination
            if(empty($this->new_name_image)){
                throw new Exception('Please inform the destination name of image!');
                return false;
            }
            
            //If not found the quality
            if(empty($this->quality)){
                throw new Exception('Please inform the quality!');
                return false;
            }
            
            $image_extension = pathinfo($this->file_url, PATHINFO_EXTENSION);
            //Verify if is sended a destination file name with extension
            $destination_extension = pathinfo($this->new_name_image, PATHINFO_EXTENSION); 
            //if empty
            if(empty($destination_extension)){
                $this->new_name_image = $this->new_name_image.'.'.$image_extension;
            }
            
            //Verify if folder destination isn't empty
            if(!empty($real_destination)){
                
                //And verify the last one element of value
                $last_char = substr($real_destination, -1);
                
                if($last_char !== '/'){
                    $real_destination = $real_destination.'/';
                }
            }
            list($src_width, $src_height) = getimagesize($real_path_file);
            //Switch to find the file type
            switch ($image_mime){
                //if is JPG and siblings
                case 'image/jpeg':
                case 'image/pjpeg':
                    //Create a new jpg image
                    
                    $new_image = imagecreatefromjpeg($real_path_file);
                    $width = $this->width;
                    $height = $this->height;
                    $new_image_crop = imagecreatetruecolor($width, $height);
                    $src_x = ($src_width - $width) / 2;
                    $src_y = ($src_height - $height) / 2;
                    imagecopyresampled ($new_image_crop, $new_image, 0, 0, 0, 0, $width, $height, $src_width, $src_height);
                    imagejpeg($new_image_crop, $real_destination.$this->new_name_image, $this->quality);
                    break;
                //if is PNG and siblings
                case 'image/png':
                case 'image/x-png':
                    //Create a new png image
                    $new_image = imagecreatefrompng($real_path_file);
                    imagealphablending($new_image , false);
                    imagesavealpha($new_image , true);
                    $width = $this->width;
                    $height = $this->height;
                    $new_image_crop = imagecreatetruecolor($width, $height);
                    $src_x = ($src_width - $width) / 2;
                    $src_y = ($src_height - $height) / 2;
                    imagecopyresampled ($new_image_crop, $new_image, 0, 0, 0, 0, $width, $height, $src_width, $src_height);
                    imagepng($new_image_crop, $real_destination.$this->new_name_image, $png_compression);
                    break;
                // if is GIF
                case 'image/gif':
                    //Create a new gif image
                    $new_image = imagecreatefromgif($real_path_file);
                    imagealphablending($new_image, false);
                    imagesavealpha($new_image, true);
                    $width = $this->width;
                    $height = $this->height;
                    $new_image_crop = imagecreatetruecolor($width, $height);
                    $src_x = ($src_width - $width) / 2;
                    $src_y = ($src_height - $height) / 2;
                    imagecopyresampled ($new_image_crop, $new_image, 0, 0, 0, 0, $width, $height, $src_width, $src_height);
                    imagegif($new_image_crop, $real_destination.$this->new_name_image);
            }
            
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
        
        $result = array(
            'image' => $this->new_name_image,
            'real_file_path' => $real_destination.$this->new_name_image,
            'url_file_path' => $this->destination.'/'.$this->new_name_image
        );
        
        //Return the new image resized
        return $result;
        
    }
}
