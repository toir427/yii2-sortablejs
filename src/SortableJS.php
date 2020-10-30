<?php

namespace toir427\sortablejs;

use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * To create and reorder lists with drag-and-drop. For use with modern browsers and touch devices.
 *
 * For example:
 *
 * ```php
 * <?= Sortable::widget([
 *     'items' => [
 *         'Item 1',
 *         ['content' => 'Item2'],
 *         [
 *             'content' => 'Item3',
 *             'options' => ['class' => 'text-danger'],
 *         ],
 *     ],
 *     'clientOptions' => [
 *         'selectedClass'     => 'selected',
 *         'fallbackTolerance' => 3,
 *         'animation'         => 150,
 *     ],
 * ]); ?>
 * ```
 *
 * @see    https://github.com/toir427/yii2-sortablejs
 * @author Tuychiev Toir <toir427@gmail.com>
 * @since  1.0.0
 */
class SortableJS extends Widget
{
    /***
     * @inheritDoc
     */
    public static $autoIdPrefix = 'sortablejs';

    /**
     * @var array the HTML attributes for the container tag of the list view.
     * The "tag" element specifies the tag name of the container element and defaults to "div".
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = ['class' => 'row'];

    /**
     * @var array the HTML attributes for the item tag. This will be overwritten
     * by the "options" set in individual [[items]].
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $itemOptions = [];

    /**
     * @var array list of sortable items. Each item can be a string representing the item content
     * or an array of the following structure:
     *
     * ~~~
     * [
     *     'content' => 'item content',
     *     // the HTML attributes of the item tag. This will overwrite "itemOptions".
     *     'options' => [],
     * ]
     * ~~~
     */
    public $items = [];

    /**
     * @var bool disable items by default. This will be overwritten
     * by the "disabled" set in individual [[items]].
     */
    public $disabled = false;

    /**
     * @var string css class to style disabled items.
     */
    public $disabledClass = 'disabled';

    /**
     * @var array the options for the underlying toir427 SortableJS widget.
     * Please refer to the toir SortableJS Documentation for possible options.
     * @see https://github.com/toir427/yii2-sortablejs#options
     */
    public $clientOptions = [];

    /**
     * @var array List of available events
     * @see https://github.com/toir427/yii2-sortablejs#options
     */
    private $_availableClientEvents = ['setData', 'onChoose', 'onUnchoose', 'onStart', 'onEnd', 'onAdd', 'onUpdate', 'onSort', 'onRemove', 'onFilter', 'onMove', 'onClone', 'onChange'];

    /***
     * @inheritDoc
     */
    public function run()
    {
        if (empty($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }

        $id = $this->options['id'];
        $this->initClientOptions();

        $tag = ArrayHelper::remove($this->options, 'tag', 'div');
        echo Html::beginTag($tag, $this->options);
        echo $this->renderItems();
        echo Html::endTag($tag);

        $this->registerClientEvents($id);
        $this->registerClientWidget($id);
    }

    /**
     * Initializes the client widget options.
     */
    protected function initClientOptions()
    {
        if ($this->disabled || $this->itemHasEnabledOption('disabled')) {
            if (empty($this->clientOptions['filter'])) {
                $this->clientOptions['filter'] = '.sortablejs-disabled';
            }
        }
    }

    /**
     * Check if there is any item which has the passed option enabled
     *
     * @param string $option key name of the array element
     * @return bool
     */
    protected function itemHasEnabledOption($option)
    {
        foreach ($this->items as $item) {
            if (ArrayHelper::getValue($item, $option, false)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Registers a sortable widget
     * @param string $id the ID of the widget
     */
    protected function registerClientWidget($id)
    {
        $clientOptions = Json::htmlEncode($this->clientOptions);
        SortableJSAsset::register($this->getView());

        $js = <<<JS
        var el = document.getElementById("{$id}");
        Sortable.create(el, {$clientOptions});
JS;
        $this->getView()->registerJs($js);
    }

    /**
     * Registers SortableJS widget events
     * @throws InvalidConfigException if `$clientEvents` array contains an unsupported event name.
     */
    protected function registerClientEvents()
    {
        if (!empty($this->clientEvents)) {
            foreach ($this->clientEvents as $event => $handler) {
                if (in_array($event, $this->_availableClientEvents)) {
                    $this->clientOptions[$event] = $handler;
                } else {
                    throw new InvalidConfigException('Unknow event "' . $event . '".');
                }
            }
        }
    }

    /**
     * Renders the item list of the SortableJS container as specified on [[items]].
     * @return string the rendering result.
     */
    private function renderItems()
    {
        $items = [];

        foreach ($this->items as $k => $item) {
            $currentItemOptions = ArrayHelper::getValue($item, 'options', ['class' => 'col-md-2']);
            $itemOptions        = ArrayHelper::merge($this->itemOptions, $currentItemOptions);

            if (ArrayHelper::getValue($item, 'disabled', $this->disabled)) {
                $itemFilterClass = substr($this->clientOptions['filter'], 1);
                Html::addCssClass($itemOptions, [$filterItem, $this->disabledClass]);
            }

            $itemTag = ArrayHelper::remove($itemOptions, 'tag', 'div');
            $content = is_string($item) ? $item : ArrayHelper::getValue($item, 'content', 'Item ' . $k);
            $items[] = Html::tag($itemTag, $content, $itemOptions);
        }

        return implode(PHP_EOL, $items);
    }
}