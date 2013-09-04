<?php

/**
 * ## EBaseMagnificPopup class file.
 *
 * @author Edgard Lorraine Messias <edgardmessias@gmail.com>
 * @copyright Copyright &copy; Edgard Lorraine Messias 2013-
 */

/**
 * Description of EBaseMagnificPopup
 *
 * @see http://dimsemenov.com/plugins/magnific-popup/
 * @author Edgard Lorraine Messias <edgardmessias@gmail.com>
 */
class EBaseMagnificPopup extends CWidget {

    public $target;
    public $options;
    public $defaultOptions = array(
        'type' => 'image'
    );
    public $language;

    /**
     * Run this widget.
     * This method registers necessary javascript.
     */
    public function run() {

        $options = CMap::mergeArray($this->options, $this->defaultOptions);
        $optionsJs = CJavaScript::encode($options);
        $js = "jQuery('{$this->target}').magnificPopup($optionsJs);";

        $this->publishAssets();
        Yii::app()->clientScript->registerScript(__CLASS__ . '#' . $this->id, $js);
    }

    /**
     * Function to publish and register assets on page 
     * @throws Exception
     */
    public function publishAssets() {
        $assets = dirname(__FILE__) . '/assets';
        $baseUrl = Yii::app()->assetManager->publish($assets);
        if (is_dir($assets)) {
            Yii::app()->clientScript->registerCoreScript('jquery');
            Yii::app()->clientScript->registerScriptFile($baseUrl . '/jquery.magnific-popup' . (!YII_DEBUG ? '.min' : '') . '.js', CClientScript::POS_HEAD);

            if ($this->language == null) {
                $this->language = strtolower(Yii::app()->language);
            }
            if ($this->language) {
                $avaliableLanguages = array('pt-br');

                if (in_array($this->language, $avaliableLanguages)) {
                    Yii::app()->clientScript->registerScriptFile($baseUrl . '/locales/jquery.magnific-popup.' . $this->language . '.js', CClientScript::POS_HEAD);
                } elseif (in_array(substr($this->language, 0, 2), $avaliableLanguages)) {
                    Yii::app()->clientScript->registerScriptFile($baseUrl . '/locales/jquery.magnific-popup.' . substr($this->language, 0, 2) . '.js', CClientScript::POS_HEAD);
                }
            }
            Yii::app()->clientScript->registerCssFile($baseUrl . '/magnific-popup.css');
        } else {
            throw new Exception('EBaseMagnificPopup - Error: Couldn\'t find assets to publish.');
        }
    }

}
