<?php

declare(strict_types=1);

namespace hipanel\modules\document\forms;

use hipanel\modules\document\models\Document;
use yii\base\Model;
use Yii;

class PrepareMailOutForm extends Model implements MailOutFormInterface
{
    public ?string $balance = null;
    public ?string $type = null;
    public ?string $from = null;
    public ?string $subject = null;
    public ?string $message = null;
    public ?string $recipients = null;
    public ?string $attach = null;
    public bool $html = false;
    public ?string $direct_only = null;

    public const ANY_BALANCE = 'any';
    public const POSITIVE_BALANCE = 'positive';
    public const NEGATIVE_BALANCE = 'negative';
    public const INVOICE_TYPE = 'invoice';
    public const PROFORMA_TYPE = 'proforma';

    public function rules()
    {
        return [
            [['balance', 'from', 'subject', 'message'], 'required'],
            ['balance', 'in', 'range' => array_keys($this->getBalanceOptions())],
            [['attach', 'direct_only', 'html'], 'boolean', 'trueValue' => '1', 'falseValue' => '0'],
            ['from', 'email'],
            [['subject', 'message', 'type', 'recipients'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'balance' => Yii::t('hipanel.document.mailout', 'Balance'),
            'attach' => Yii::t('hipanel.document.mailout', 'Attach files'),
            'from' => Yii::t('hipanel.document.mailout', 'From'),
            'subject' => Yii::t('hipanel.document.mailout', 'Subject'),
            'message' => Yii::t('hipanel.document.mailout', 'Message'),
            'direct_only' => Yii::t('hipanel.document.mailout', 'Direct clients only'),
            'recipients' => Yii::t('hipanel.document.mailout', 'Recipients'),
            'type' => Yii::t('hipanel.document.mailout', 'Type of attachments'),
            'html' => Yii::t('hipanel.document.mailout', 'Use HTML message'),
        ];
    }

    public function getBalanceOptions(): array
    {
        return [
            self::ANY_BALANCE => Yii::t('hipanel.document.mailout', 'Any'),
            self::POSITIVE_BALANCE => Yii::t('hipanel.document.mailout', 'Positive'),
            self::NEGATIVE_BALANCE => Yii::t('hipanel.document.mailout', 'Negative'),
        ];
    }

    public function getTypeOptions(): array
    {
        return [
            self::INVOICE_TYPE => Yii::t('hipanel.document.mailout', 'Invoice'),
            self::PROFORMA_TYPE => Yii::t('hipanel.document.mailout', 'Proforma'),
        ];
    }

    public function perform(): void
    {
        $apiData = Document::perform('prepare-mailout', $this->attributes, ['batch' => true]);
        $this->setAttributes($apiData);
    }
}
