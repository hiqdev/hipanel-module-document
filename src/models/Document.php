<?php

namespace hipanel\modules\document\models;

use hipanel\base\ModelTrait;
use hipanel\behaviors\File as FileBehavior;
use hipanel\models\File as FileModel;
use hipanel\modules\document\models\query\DocumentQuery;
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
            [['create_time', 'update_time', 'validity_start', 'validity_end'], 'datetime'],
            [['type', 'state'], 'safe'],
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

    public function getObject()
    {
        return $this->hasOne(Object::class, ['id' => 'object_id'])->via('file');
    }

    public function getStatuses()
    {
        return $this->hasMany(Status::class, ['object_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return DocumentQuery
     */
    public static function find($options = [])
    {
        return new DocumentQuery(get_called_class(), [
            'options' => $options,
        ]);
    }
}
