<?php
declare(strict_types=1);

namespace hipanel\modules\document\widgets\combo;

use hipanel\modules\client\widgets\combo\ContactCombo;

final class ContactIndependentCombo extends ContactCombo
{
    /** {@inheritdoc} */
    public function getPluginOptions($options = [])
    {
        $options = array_merge(parent::getPluginOptions(), $options);
        unset($options['clearWhen']);

        return $options;
    }

    /** {@inheritdoc} */
    public function getFilter()
    {
        $filter = parent::getFilter();
        unset($filter['client']);

        return $filter;
    }
}
