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
 
}