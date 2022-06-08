<?php

declare(strict_types=1);

namespace hipanel\modules\document\forms;

use hipanel\modules\document\models\Document;
use Yii;

class SendMailOutForm extends PrepareMailOutForm
{
    public ?string $preview = null;
    public ?string $to = null;
    public bool $test = false;
    private static array $data = [];

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'test' => Yii::t('hipanel.document.mailout', 'Fake send'),
        ]);
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            ['test', 'boolean'],
            [['to', 'preview'], 'string'],
        ]);
    }

    public function perform(): void
    {
        $apiData = Document::perform('send-mailout', $this->attributes, ['batch' => true]);
        foreach ($apiData as $login => $data) {
            $model = new static();
            $model->setAttributes($data);
            self::$data[$login] = $model;
        }
    }

    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        $result = [];

        foreach (self::$data as $idx => $datum) {
            $result[$idx] = $datum->attributes;
        }

        return $result;
    }
}
