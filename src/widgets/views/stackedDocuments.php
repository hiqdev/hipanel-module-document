<?php

/**
 * @var array
 * @var \yii\web\View $this
 */
use hipanel\helpers\StringHelper;
use hipanel\modules\document\widgets\DocumentStatusIcons;
use yii\helpers\Html;

$this->registerCss(<<<CSS
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

.preview-box {
    position: relative;
    display: block;
    padding: 10px;
    background-color: #fff;
    border-bottom: 1px solid #eaeef1;
    box-shadow: 1px 2px 1px 0px #eaeef1;
}

.preview-box .preview-file {
    margin-right: 15px;
    position: relative;
    float: left;
}

.preview-box .preview-file a {
    width: 64px;
    height: 64px;
    display: inline-block;    
    max-width: 100%;
    vertical-align: middle;
    text-align: center;
}

.preview-box .preview-file a:before {
  content: "";
  display: inline-block;
  vertical-align: middle;
  height: 100%;
}

.preview-box .preview-file a img {

}

.preview-box .preview-content {

}

.text-sm {
    font-size: 13px;
}

.text-ellipsis {
    display: block;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
CSS
);
?>

<div class="stacked-documents">
    <?php if (count($groups)) : ?>
        <?php foreach ($groups as $date => $documents) :
/** @var \hipanel\modules\document\models\Document[] $documents */ ?>
            <div class="group">
                <div class="title">
                    <i class="fa fa-calendar"></i>&nbsp;&nbsp;<?= Yii::$app->formatter->asDate($date, 'LLLL Y') ?>
                </div>
                <div class="row">
                    <?php $iteration = 1; ?>
                    <?php foreach ($documents as $document) : ?>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="preview-box">
                                <div class="preview-file">
                                    <?= \hipanel\widgets\FileRender::widget([
                                        'file' => $document->file,
                                        'thumbHeight' => $this->context->thumbSize,
                                        'thumbWidth' => $this->context->thumbSize,
                                        'iconOptions' => [
                                            'class' => 'fa-3x',
                                        ],
                                        'lightboxLinkOptions' => [
                                            'data-lightbox' => 'files-' . $date,
                                        ],
                                    ]); ?>
                                </div>
                                <div class="preview-content clearfix">
                                    <div class="statuses pull-right">
                                        <?= DocumentStatusIcons::widget(['model' => $document]) ?>
                                    </div>
                                    <?php
                                    $title = Html::encode(StringHelper::truncate($document->getDisplayTitle(), 15));
                                    echo Html::a($title, ['@document/view', 'id' => $document->id]);
                                    ?>
                                    <div class="text-muted text-sm text-ecliellipsis"><?= Yii::$app->formatter->asDate($document->create_time) ?></div>
                                </div>
                            </div>
                        </div>
                        <?php
                        if ($iteration % 2 === 0) {
                            echo Html::tag('div', '', ['class' => 'clearfix']);
                        }
                        ++$iteration;
                        ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <?= Yii::t('hipanel:document', 'No documents found') ?>
    <?php endif; ?>
</div>

