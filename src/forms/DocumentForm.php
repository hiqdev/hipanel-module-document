<?php

namespace hipanel\modules\document\forms;

use hipanel\base\ModelTrait;
use hipanel\behaviors\File as FileBehavior;
use hipanel\helpers\ArrayHelper;
use hipanel\modules\document\models\Document;
use Yii;

/**
 * Class DocumentForm
 * @method processFiles() uploads files from `attachment` attribute and saves to `file_id`
 * @package hipanel\modules\document\forms
 */
class DocumentForm extends Document
{
    use ModelTrait;
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

//    public static function index()
//    {
//        return 'documents';
//    }
//
//    public static function type()
//    {
//        return 'document';
//    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => FileBehavior::class,
                'attribute' => 'attachment',
                'targetAttribute' => 'file_id',
                'scenarios' => ['create'],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client', 'attachment'], 'safe', 'on' => ['create']],
            [['type', 'title'], 'required', 'on' => ['create', 'update']],
            [['description', 'statuses'], 'safe', 'on' => ['create', 'update']],
            [['file_id'], 'integer', 'on' => ['create', 'update']],
            [
                ['validity_start', 'validity_end'],
                'datetime',
                'format' => 'php:Y-m-d',
                'on' => ['create', 'update'],
                'enableClientValidation' => false,
                'when' => function () {
                    return Yii::$app->user->can('document.manage') || 1;
                },
            ],
            [
                ['validity_end'],
                'compare',
                'compareAttribute' => 'validity_start',
                'operator' => '>',
                'on' => ['create', 'update'],
                'enableClientValidation' => false,
                'when' => function () {
                    return Yii::$app->user->can('document.manage') || 1;
                },
            ],
            ['statuses', 'safe', 'on' => ['create', 'update']],
            [['id'], 'integer', 'on' => ['update']]
        ];
    }

    /**
     * @param Document $document
     * @return static
     */
    public function fromDocument(Document $document)
    {
        $attributes = $document->toArray();
        $this->setAttributes($attributes, false);

        if ($document->isRelationPopulated('statuses')) {
            $this->statuses = implode(',', ArrayHelper::getColumn($document->statuses, 'type'));
        }

        return $this;
    }
}
