<?php

/**
 * ## EGroupMagnificPopup class file.
 *
 * @author Edgard Lorraine Messias <edgardmessias@gmail.com>
 * @copyright Copyright &copy; Edgard Lorraine Messias 2013-
 */
$dir = dirname(__FILE__);
$alias = md5($dir);
Yii::setPathOfAlias($alias, $dir);
Yii::import($alias . '.EBaseMagnificPopup');

/**
 * Description of EGroupMagnificPopup
 *
 * @see http://dimsemenov.com/plugins/magnific-popup/
 * @author Edgard Lorraine Messias <edgardmessias@gmail.com>
 */
class EGroupMagnificPopup extends EMagnificPopup {

    public $tagName = 'div';
    public $htmlOptions = array();
    public $delegate = 'a';

    public function init() {
        $this->defaultOptions = CMap::mergeArray($this->defaultOptions, array(
                    'delegate' => $this->delegate,
        ));
        $this->target = '#' . $this->id;
        echo CHtml::openTag($this->tagName, array('id' => $this->id), $this->htmlOptions);
        parent::init();
    }

    /**
     * Run this widget.
     * This method registers necessary javascript.
     */
    public function run() {
        echo CHtml::closeTag($this->tagName);
        parent::run();
    }

}
