<?php 
namespace app\components;
 
 
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
 
class DecorComponent extends Component
{
    public function infoPanel( $text, $type='important', $class = '' )
    {

        
        ?>

<div class="mdlst-pan mdlst-pan-<?=$type?> <?=$class?>">
    <div class="mdlst-pan-icon"></div>
    <div class="mdlst-pan-text"><?=$text?></div>
</div>

 
        <?
    }
    public function button( $text, $url = '', $class = '' )
    {

        if( empty($url)) {
            $tag = 'button';
        }else{
            $tag = 'a';
        }
        
        ?>
            <<?=$tag?> class="mdlst-button  <? if(!empty($url) ) { ?> href="<?=$url?>"<? }?> mdlst-button-default <?=$class?>"><?=$text?></<?=$tag?>>
 
        <?
    }


    /**
    * style = plus-add plus-cross plus-edit
    */
    public function plus($url = '', $class = '', $style = 'plus-add'){
        ?>
         <a class="container-menu-list-meta-add margin-0 <?=$class?> <?=$style?> " href="<?=$url?>">
                                                                <span class="container-menu-list-meta-add-plus">+</span>
                                                            </a>
        <?
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