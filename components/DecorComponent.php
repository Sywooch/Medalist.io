<?php 
namespace app\components;
 
 
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
 
class DecorComponent extends Component
{


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
 

 
 
}