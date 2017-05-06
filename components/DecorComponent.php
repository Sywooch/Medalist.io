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
            <input type="checkbox" name="private" class="mdlst-switch-chk" <?php if($checkboxState ) { ?> checked="checked"<?} ?>>
        </div>
                                        
        <?

    }
 
}