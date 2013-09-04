<?php

/**
 * ## EGalleryMagnificPopup class file.
 *
 * @author Edgard Lorraine Messias <edgardmessias@gmail.com>
 * @copyright Copyright &copy; Edgard Lorraine Messias 2013-
 */
$dir = dirname(__FILE__);
$alias = md5($dir);
Yii::setPathOfAlias($alias, $dir);
Yii::import($alias . '.EGroupMagnificPopup');

/**
 * Description of EGroupMagnificPopup
 *
 * @see http://dimsemenov.com/plugins/magnific-popup/
 * @author Edgard Lorraine Messias <edgardmessias@gmail.com>
 */
class EGalleryMagnificPopup extends EGroupMagnificPopup {

    public $defaultGalleryOptions = array(
        'enabled' => true,
    );
    public $galleryOptions = array();

    public function init() {
        $this->galleryOptions = CMap::mergeArray($this->galleryOptions, $this->defaultGalleryOptions);
        $this->defaultOptions = CMap::mergeArray($this->defaultOptions, array(
                    'gallery' => $this->galleryOptions,
        ));
        parent::init();
    }

}
