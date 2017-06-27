<?php 
namespace app\components;
 
 
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
 
class DecorComponent extends Component
{

    static $shareScriptsLoaded = false;

    const DATE_FORMAT = 'd.m.Y H:i';
    const DATE_FORMAT_SHORT = 'd.m.Y';

    public function share( $data = [] ){
        ?>
        <?php if(! self::$shareScriptsLoaded) { 
            self::$shareScriptsLoaded = true;
            ?>
<script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
<script src="//yastatic.net/share2/share.js"></script>
        <? } ?>
<div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,moimir" data-counter="" <?php foreach($data as $param => $value){ ?> data-<?=$param?>="<?=$value?>" <? }?>></div>

        <?
    }


    public function shareWidget( $data = [], $title = '', $class = '' ){
        if( $title == '') { 
            $title = 'Поделитесь в социальных сетях: '; 
        }
        ?>
        <div class="share-widget <?=$class?>">
            <div class="share-widget-title"><?=$title?></div>
            <div class="share-widget-content"><? Yii::$app->decor->share($data) ?></div>
        </div>
        <?
    }

    public function _csrf(){

        ?>
            <input type="hidden" value="<?=Yii::$app->request->getCsrfToken()?>" name="_csrf">
        <?
    }

    public function translateDateString( $date_string ){
        $substitute = array('days' => 'дн.', 'weeks' => 'нед.');

        foreach ($substitute as $key => $value) {
            $date_string = str_replace($key, $value,  $date_string);
        }
        return $date_string;
    }

    public function scale( $percent ){

        if( $percent > 1){
            $percent = $percent / 100;
        }

        ?>
<div class="interests-selector-scale-viewport userpanel-info-scale-scale">
    <div class="interests-selector-scale-track" style="margin-left: -<?=(1-$percent)*100?>%;"></div>
</div>
        <?
    }

    public function infoPanel( $text, $type='important', $class = '' )
    {

        
        ?>

<div class="mdlst-pan mdlst-pan-<?=$type?> <?=$class?>">
    <div class="mdlst-pan-icon"></div>
    <div class="mdlst-pan-text"><?=$text?></div>
</div>

 
        <?
    }



    public function button( $text, $url = '', $class = '', $data = [] )
    {

        if( empty($url)) {
            $tag = 'button';
        }else{
            $tag = 'a';
        }
        
        ?>
            <<?=$tag?> class="mdlst-button mdlst-button-default <?=$class?>"  <? if(!empty($url) ) { ?> href="<?=$url?>"<? }?>  <?php foreach($data as $k=>$v) { ?> data-<?=$k?>="<?=$v?>" <?} ?>><?=$text?></<?=$tag?>>
 
        <?
    }


    /**
    * style = plus-add plus-cross plus-edit
    */
    public function plus($url = '', $class = '', $style = 'plus-add', $data = []){
        ?>
         <a class="container-menu-list-meta-add margin-0 <?=$class?> <?=$style?> " href="<?=$url?>" <?php foreach($data as $k=>$v) { ?> data-<?=$k?>="<?=$v?>" <?} ?>>
                                                                <span class="container-menu-list-meta-add-plus">+</span>
                                                            </a>
        <?
    }


    public function removeControll( $obj, $light= false){

        $classname = get_class( $obj );
        $classname = explode("\\",$classname);
        $classname = $classname[count($classname) - 1];
        $idVarName = strtolower($classname."_id");
        $id = $obj->{$idVarName};


        $this->plus('', 'js-remove-entity', $light?'plus-lightcross':'plus-cross', ['obj' => $classname, 'id' => $id]);
    }


    public function controllSwitch( $checkboxName, $checkboxText , $extraClass = '' , $checkboxState = false ){

        ?>


<div class=" <?=$extraClass?> mdlst-switch <?php if($checkboxState ) { ?>  mdlst-switch-on <?} ?>">
    <div class="  mdlst-switch-state">
        <div class="mdlst-switch-state-w">
            <div class="mdlst-switch-state-curtain"></div>
            <div class="mdlst-switch-state-track"></div>
        </div>
    </div>
    <div class="  mdlst-switch-text"><?=$checkboxText?></div>
    <input type="checkbox" name="<?=$checkboxName?>" class="mdlst-switch-chk" <?php if($checkboxState ) { ?> checked="checked"<?} ?>>
</div>
                                        
        <?

    }









    public static function getHash( $string ){
        return md5( md5($string)."medalyst123" );
    }
    
    public static function checkHash( $string, $hashed ){
        return ($hashed === self::getHash( $string ));
    }
 

	public static function createThumbnail($filepath, $thumbpath, $thumbnail_width, $thumbnail_height, $background=false) {
	    list($original_width, $original_height, $original_type) = getimagesize($filepath);
	    if ($original_width > $original_height) {
	        $new_width = $thumbnail_width;
	        $new_height = intval($original_height * $new_width / $original_width);
	    } else {
	        $new_height = $thumbnail_height;
	        $new_width = intval($original_width * $new_height / $original_height);
	    }
	    $dest_x = intval(($thumbnail_width - $new_width) / 2);
	    $dest_y = intval(($thumbnail_height - $new_height) / 2);

	    if ($original_type === 1) {
	        $imgt = "ImageGIF";
	        $imgcreatefrom = "ImageCreateFromGIF";
	    } else if ($original_type === 2) {
	        $imgt = "ImageJPEG";
	        $imgcreatefrom = "ImageCreateFromJPEG";
	    } else if ($original_type === 3) {
	        $imgt = "ImagePNG";
	        $imgcreatefrom = "ImageCreateFromPNG";
	    } else {
	   	    return false;
	    }

    	$old_image = $imgcreatefrom($filepath);
	    $new_image = imagecreatetruecolor($thumbnail_width, $thumbnail_height); // creates new image, but with a black background

    	// figuring out the color for the background
	    if(is_array($background) && count($background) === 3) {
	      list($red, $green, $blue) = $background;
	      $color = imagecolorallocate($new_image, $red, $green, $blue);
	      imagefill($new_image, 0, 0, $color);
	    // apply transparent background only if is a png image
	    } else if($background === 'transparent' && $original_type === 3) {
	      imagesavealpha($new_image, TRUE);
	      $color = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
	      imagefill($new_image, 0, 0, $color);
	    }

	    imagecopyresampled($new_image, $old_image, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);
	    $imgt($new_image, $thumbpath);
	    return file_exists($thumbpath);
}   	


	public static function getThumbnails($photos) {

		$thumbs = Array();
		foreach($photos as $photo){

        	$info = pathinfo( $photo->filename );
			array_push($thumbs,$info['dirname'].'/'.$info['filename'].'_tb.'.$info['extension']);
		}
		return $thumbs;

	}

	public static function getThumbnail($photo) {
		if(strpos($photo, 'http://gravatar.com') !== FALSE){
			return '';
		}

       	$info = pathinfo( $photo );
		return $info['dirname'].'/'.$info['filename'].'_tb.'.$info['extension'];
	}



    public static function classnameToName($classname){
        switch ($classname) {
            case 'Badge':
                return 'Награда';
                break;
            case 'Quest':
                return 'Квест';
                break;
            case 'Goal':
                return 'Цель';
                break;
            case 'Achievement':
                return 'Достижение';
                break;
            
            default:
                # code...
                break;
        }
    }
 

	public static function cutDescription($string) {
		$string = strip_tags($string);
		$string = substr($string, 0, 700);
		$string = rtrim($string, "!,.-");
		$string = substr($string, 0, strrpos($string, ' '));
		return $string."… ";
	}
}