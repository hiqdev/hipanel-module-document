<?php

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
