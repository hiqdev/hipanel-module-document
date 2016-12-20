<?php

/**
 * @var array $groups
 * @var \yii\web\View $this
 */

use hipanel\modules\document\widgets\DocumentStatusIcons;
use yii\helpers\Html;

?>
    <div class="stacked-documents">
        <?php if (count($groups)) : ?>
            <?php foreach ($groups as $date => $documents) :
            /** @var \hipanel\modules\document\models\Document[] $documents */ ?>
            <div class="group">
                <div class="title">
                    <i class="fa fa-calendar"></i> <?= Yii::$app->formatter->asDate($date) ?>
                </div>
                <div class="body">
                        <?php foreach ($documents as $document) : ?>
                            <div class="item">
                                <div class="preview">
                                    <?= \hipanel\widgets\FileRender::widget([
                                        'file' => $document->file,
                                        'thumbHeight' => $this->context->thumbSize,
                                        'thumbWidth' => $this->context->thumbSize,
                                        'lightboxLinkOptions' => [
                                            'data-lightbox' => 'files-' . $date,
                                        ],
                                    ]); ?>
                                </div>
                                <div class="statuses">
                                    <?= DocumentStatusIcons::widget(['model' => $document]) ?>
                                    <?= Html::a('<i class="fa fa-external-link"></i>',
                                        ['@document/view', 'id' => $document->id], [
                                            'class' => 'pull-right btn btn-default btn-xs',
                                        ]) ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <?= Yii::t('hipanel:document', 'No documents found') ?>
    <?php endif; ?>
    </div>
<?php

$this->registerCss(<<<CSS
    .stacked-documents {
    
    }
    
    .stacked-documents .body {
        margin: 2px;
        display: flex;
        align-items: flex-start;
        flex-wrap: wrap;
    }
        
    .stacked-documents .group {
        margin-bottom: 15px;
    }
    
    .stacked-documents .group .statuses {
        margin: 5px 5px;
        overflow: auto;
    }

    .stacked-documents .group .title {
        font-weight: bold;
        margin: 1em 0;
    }    
    
    .stacked-documents .margin {
        margin: 1px 0;
    }
    
    .stacked-documents .group .item {
        position: relative;
        margin: 0.3em 5px;
        border: rgba(0, 0, 0, 0.05) 1px solid;
        box-shadow: 0 0 1px 0 #a2958a;
        padding: 4px 4px 0 4px;
    }
    
    .stacked-documents .group .item:hover {
        box-shadow: 0 0 2px 0 #333;
    }

    .stacked-documents .group .item .preview {
        text-align: center;
    }
CSS
);
