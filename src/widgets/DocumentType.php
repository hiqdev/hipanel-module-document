<?php
/**
 * Documents module for HiPanel
 *
 * @link      https://hipanel.com/
 * @package   hipanel-module-document
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2018, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\document\widgets;

class DocumentType extends \hipanel\widgets\Type
{
    /** {@inheritdoc} */
    public $model         = [];
    public $values        = [];
    public $defaultValues = [
        'none'    => ['other'],
        'primary' => ['id', 'agreement'],
        'success' => ['invoice', 'acceptance'],
    ];
    public $field = 'type';
    public $i18nDictionary = 'hipanel:document';
}
