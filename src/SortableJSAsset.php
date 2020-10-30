<?php
/**
 * @link      http://www.tuychiev.com/
 * @copyright Copyright (c) Tuychiev Toir
 * @license   http://www.tuychiev.com/license/
 */

namespace toir427\sortablejs;

use yii\web\AssetBundle;

/**
 * Asset bundle for toir427/yii2-sortablejs
 * Create reorderable drag-and-drop lists for modern browsers and touch devices.
 *
 * @see    https://github.com/toir427/yii2-sortablejs
 * @author Tuychiev Toir <toir427@gmail.com>
 * @since  1.0.0
 */
class SortableJSAsset extends AssetBundle
{
    /***
     * @inheritdoc
     */
    public $sourcePath = '@npm/sortablejs/dist';

    /**
     * Adds JS Files depending on [[YII_ENV_PROD]]
     */
    public function init()
    {
        parent::init();

        $this->js = [
            'sortable.umd.js',
        ];
    }
}
