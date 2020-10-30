SortableJS for Yii 2.0 
=========================

This is an [Yii framework 2.0](http://www.yiiframework.com) implementation of [SortableJS](https://github.com/SortableJS/sortablejs) extension. To create and reorder lists with drag-and-drop. For use with modern browsers and touch devices.

[![Latest Stable Version](https://poser.pugx.org/toir427/yii2-sortablejs/v/stable.png)](https://packagist.org/packages/toir427/yii2-sortable)
[![Code Climate](https://codeclimate.com/github/toir427/yii2-sortablejs/badges/gpa.svg)](https://codeclimate.com/github/toir427/yii2-sortablejs)
[![Total Downloads](https://poser.pugx.org/toir427/yii2-sortablejs/downloads.png)](https://packagist.org/packages/toir427/yii2-sortablejs)
[![License](https://poser.pugx.org/toir427/yii2-sortablejs/license)](https://packagist.org/packages/yiitoir427/yii2-sortablejs)

Installation
------------

The preferred way to install this extension is through [composer](https://getcomposer.org/download/).

Either run

```
php composer.phar require toir427/yii2-sortablejs
```

or add

```
"toir427/yii2-sortablejs": "^1.0"
```

to the require section of your `composer.json` file.

Usage
-----

```php
use toir427\sortablejs\Sortable;

<?= Sortable::widget([
    'items' => [
        'Item 1',
        ['content' => 'Item2'],
        [
            'content' => 'Item3',
            'options' => ['class' => 'text-danger'],
        ],
    ],
    'clientOptions' => [
        'selectedClass'     => 'selected',
        'fallbackTolerance' => 3,
        'animation'         => 150,
    ],
]); ?>
```
Examples
-------
More [Examples](https://sortablejs.github.io/sortablejs).

Configurations
-------
For this extension configuration see SortableJS [Options](https://github.com/SortableJS/sortablejs#options).

License
-------

**yii2-sortablejs** is released under the Apache 2.0 License. See the [LICENSE.md](LICENSE.md) for details.