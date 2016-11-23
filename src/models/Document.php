<?php

namespace hipanel\modules\document\models;

use hipanel\base\ModelTrait;
use hipanel\behaviors\File as FileBehavior;
use hipanel\models\File as FileModel;
use Yii;

/**
 * Class Document represents document
 *
 * @property int $id
 * @property string $title
 * @property string $description
 *
 * @package hipanel\modules\document\models
 */
class Document extends \hipanel\base\Model
{
    use ModelTrait;

    /**
     * @inheritdoc
     */
    public static $i18nDictionary = 'hipanel:document';

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
            [['id', 'type_id', 'state_id', 'object_id', 'client_id', 'seller_id'], 'integer'],
            [['client', 'seller', 'title', 'description'], 'safe'],
            [['create_time', 'update_time'], 'datetime'],
            [['type', 'state'], 'safe'],

            [['attachment'], 'safe', 'on' => ['create']],
            [['type', 'title'], 'required', 'on' => ['create', 'update']],
            [['description'], 'safe', 'on' => ['create', 'update']],
            [['state_id', 'file_id'], 'integer', 'on' => ['create', 'update']],
//            [['state'], 'required', 'on' => ['update']],
        ];
    }

    /**
     * @return mixed
     */
    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
            'type_id' => Yii::t('hipanel', 'Type'),
            'attachment' => Yii::t('hipanel:document', 'File'),
        ]);
    }

    public function getFile()
    {
        return $this->hasOne(FileModel::class, ['id' => 'id']);
    }
}
