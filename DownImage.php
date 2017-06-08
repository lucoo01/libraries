<?php
class DownImage{
        public $source;//远程图片URL
        public $from;//远程图片来源
        public $save_address;//保存本地地址
        public $set_extension; //设置图片扩展名
        public $quality; //图片的质量（0~100,100最佳，默认75左右）
        //下载方法（选用GD库图片下载）
        public function download(){
            if($this->from != 'qq'){
                //获取远程图片信息
                $info = @getimagesize($this->source);
                //获取图片扩展名
                $mime = $info['mime'];
                $type = substr(strrchr($mime, '/'), 1);
            }else{
                $type = 'jpeg';
            }
            //不同的图片类型选择不同的图片生成和保存函数
            switch($type){
                case 'jpeg':
                    $img_create_func = 'imagecreatefromjpeg';
                    $img_save_func = 'imagejpeg';
                    $new_img_ext = 'jpg';
                    $image_quality = isset($this->quality) ? $this->quality : 100;
                    break;
                case 'png':
                    $img_create_func = 'imagecreatefrompng';
                    $img_save_func = 'imagepng';
                    $new_img_ext = 'png';
                    break;
                case 'bmp':
                    $img_create_func = 'imagecreatefrombmp';
                    $img_save_func = 'imagebmp';
                    $new_img_ext = 'bmp';
                    break;
                case 'gif':
                    $img_create_func = 'imagecreatefromgif';
                    $img_save_func = 'imagegif';
                    $new_img_ext = 'gif';
                    break;
                case 'vnd.wap.wbmp':
                    $img_create_func = 'imagecreatefromwbmp';
                    $img_save_func = 'imagewbmp';
                    $new_img_ext = 'bmp';
                    break;
                case 'xbm':
                    $img_create_func = 'imagecreatefromxbm';
                    $img_save_func = 'imagexbm';
                    $new_img_ext = 'xbm';
                    break;
                default:
                    $img_create_func = 'imagecreatefromjpeg';
                    $img_save_func = 'imagejpeg';
                    $new_img_ext = 'jpg';
            }
            //根据是否设置扩展名来合成本地文件名
            if (isset($this->set_extension)){
                $ext = strrchr($this->source,".");
                $strlen = strlen($ext);
                $newname = basename(substr($this->source,0,-$strlen)).'.'.$new_img_ext;
            }else{
                $newname = basename($this->source);
            }
            
            //生成本地文件路径
            $save_address = $this->save_address.$newname;

            $img = @$img_create_func($this->source);
            if (isset($image_quality)){
                $save_img = @$img_save_func($img,$save_address,$image_quality);
            }else{
                $save_img = @$img_save_func($img,$save_address);
            }
            return $save_img;   
        }
    }