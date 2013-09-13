<?php

/**
 * ## EBaseMagnificPopup class file.
 *
 * @author Edgard Lorraine Messias <edgardmessias@gmail.com>
 * @copyright Copyright &copy; Edgard Lorraine Messias 2013-
 */

/**
 * Description of EMagnificPopup
 *
 * @see http://dimsemenov.com/plugins/magnific-popup/
 * @author Edgard Lorraine Messias <edgardmessias@gmail.com>
 */
class EMagnificPopup extends CWidget {

    /**
     * Jquery selector to which element should apply the magnific-popup.
     * @var string jQuery Selector
     */
    public $target;

    /**
     * Options in the documentation for magnific-popup
     * @see http://dimsemenov.com/plugins/magnific-popup/documentation.html
     * @var array Magnific-Popup Option
     */
    public $options = array();
    public $defaultOptions = array(
        'type' => 'image'
    );

    /**
     * Language for internationalization.
     * Null for auto detect.
     * @var string 
     */
    public $language;
    
    /**
     * Effects in http://codepen.io/dimsemenov/pen/GAIkt
     * @var string  
     */
    public $effect;
    
    /**
     * Alias for 'type' in option;
     * @var type string
     */
    public $type;

    /**
     * Run this widget.
     * This method registers necessary javascript.
     */
    public function run() {

        $effectList = array('fade', 'with-zoom', 'zoom-in', 'newspaper', 'move-horizontal', 'move-from-top', '3d-unfold', 'zoom-out');
        if ($this->effect && in_array($this->effect, $effectList)) {
            $this->defaultOptions['mainClass'] = 'mfp-' . $this->effect;
            $this->defaultOptions['removalDelay'] = 500;
            $this->defaultOptions['callbacks'] = array(
                'beforeOpen' => new CJavaScriptExpression("function(){this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');}")
            );

            if ($this->effect == 'with-zoom') {
                $this->defaultOptions = CMap::mergeArray($this->defaultOptions, array(
                            'zoom' => array(
                                'enabled' => true,
                            ),
                ));
            }
        }

        if ($this->type !== null) {
            $this->options['type'] = $this->type;
        }

        $options = CMap::mergeArray($this->defaultOptions, $this->options);
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
            if ($this->effect && (isset($this->defaultOptions['mainClass']) && $this->defaultOptions['mainClass'])) {
                Yii::app()->clientScript->registerCssFile($baseUrl . '/magnific-popup.effects.css');
            }
        } else {
            throw new Exception('EBaseMagnificPopup - Error: Couldn\'t find assets to publish.');
        }
    }

}
