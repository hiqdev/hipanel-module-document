<?php
/**
 * Documents module for HiPanel
 *
 * @link      https://hipanel.com/
 * @package   hipanel-module-document
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2018, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\document\models;

class Statistic extends Document
{
    public static function tableName()
    {
        return 'document';
    }

    public $types = 'invoice,acceptance';

    public function getSince()
    {
        return (new \DateTime())->modify('-10 months')->format('Y-m-d');
    }
}
