<?php

namespace hipanel\modules\document\widgets\combo;

use hipanel\helpers\ArrayHelper;
use hiqdev\combo\StaticCombo;
use hipanel\models\Ref;

class FinancialDocumentTypeCombo extends StaticCombo
{
    final const INVOICE_TYPE = 'invoice';
    final const PAYMENT_REQUEST_TYPE = 'payment_request';

    public $hasId = true;

    public function init(): void
    {
        parent::init();
        $this->data = $this->getDocumentTypes();
    }

    private function getDocumentTypes(): array
    {

        return array_filter(Ref::getList('type,document', 'hipanel', ['orderby' => 'no_asc']), function($v, $k) {
            return strpos($k, static::INVOICE_TYPE) !== false || strpos($k, static::PAYMENT_REQUEST_TYPE) !== false;
        }, ARRAY_FILTER_USE_BOTH);
    }
}
