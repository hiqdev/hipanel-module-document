<?php

/*
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\document\widgets;

class DocumentState extends \hipanel\widgets\Type
{
    /** {@inheritdoc} */
    public $model         = [];
    public $values        = [];
    public $defaultValues = [
        'none'    => ['ok'],
        'danger'  => [],
        'default' => ['deleted'],
        'warning' => ['outdated'],
        'info'    => []
    ];
    public $field = 'state';
    public $i18nDictionary = 'hipanel:document';
}
