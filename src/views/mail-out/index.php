<?php

use hipanel\modules\document\assets\MailOutFormAsset;
use hipanel\modules\document\forms\PrepareMailOutForm;
use hipanel\modules\document\forms\SendMailOutForm;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var PrepareMailOutForm $prepareMailOutForm */
/** @var SendMailOutForm $sendMailOutForm */

MailOutFormAsset::register($this);

$this->title = Yii::t('hipanel.document.mailout', 'Mail-out');
$this->params['breadcrumbs'][] = $this->title;

?>

<div id="mail-out-app" v-cloak>

    <div id="show-preview-mail-out" class="modal fade" tabindex="-1" role="dialog"
         data-action="<?= Url::to(['@mail-out/preview']) ?>">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?= Yii::t('hipanel.document.mailout', 'Emails preview') ?> <span>{{ Object.keys(recipients).length }}</span></h4>
                </div>
                <div class="modal-body no-padding emails-box">
                    <div class="email-box" v-for="recipient in recipients">
                        <p v-if="recipient.split(':')[0] in previews">
                            {{ previews[recipient.split(':')[0]].preview }}
                        </p>
                        <div v-else>
                            <h6>{{ recipient }}</h6>
                            <button type="button"
                                    class="btn btn-default"
                                    data-loading-text="<?= Yii::t('hipanel.document.mailout', 'Loading preview...') ?>"
                                    @click="event => showPreviewFor(event, recipient)"
                            >
                                <?= Yii::t('hipanel.document.mailout', 'Show preview') ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-12">

            <div :class="{'box box-primary': true, 'collapsed-box': collapsed}">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Yii::t('hipanel.document.mailout', 'Prepare mail-out') ?></h3>
                    <div class="box-tools pull-right">
                        <button v-if="collapsed" type="button" class="btn btn-box-tool" @click="expand">
                            <i class="fa fa-pencil fa-fw"></i>
                        </button>
                    </div>
                </div>

                <?php $prepareForm = ActiveForm::begin([
                    'action' => Url::to(['@mail-out/prepare']),
                    'enableClientValidation' => true,
                    'validateOnBlur' => false,
                    'validateOnChange' => false,
                    'enableAjaxValidation' => false,
                    'options' => [
                        'ref' => 'prepareForm',
                    ],
                ]) ?>

                <div class="box-body">

                    <div class="row">
                        <div class="col-md-4">
                            <?= $prepareForm->field($prepareMailOutForm, 'from')->input('email', ['v-model.trim' => 'mailOut.from']) ?>
                            <?= $prepareForm->field($prepareMailOutForm, 'subject')->textInput(['v-model.trim' => 'mailOut.subject']) ?>
                            <?= $prepareForm->field($prepareMailOutForm, 'balance')
                                ->dropDownList($prepareMailOutForm->getBalanceOptions(), ['v-model' => 'mailOut.balance']) ?>
                            <?= $prepareForm->field($prepareMailOutForm, 'type')
                                ->dropDownList($prepareMailOutForm->getTypeOptions(), ['v-model' => 'mailOut.type']) ?>
                            <?= $prepareForm->field($prepareMailOutForm, 'attach')->checkbox(['v-model' => 'mailOut.attach', 'true-value' => '1', 'false-value' => '0']) ?>
                            <?= $prepareForm->field($prepareMailOutForm, 'direct_only')->checkbox(['v-model' => 'mailOut.direct_only', 'true-value' => '1', 'false-value' => '0']) ?>
                        </div>
                        <div class="col-md-8">
                            <?= $prepareForm->field($prepareMailOutForm, 'message')->textarea(['v-model.trim' => 'mailOut.message', 'rows' => 15]) ?>
                            <p class="help-block" style="columns: 3">
                                <?php foreach (['client' => 'Client\'s login',
                                                'client_name' => 'Client\'s name (from contacts)',
                                                'client_label' => 'Client\'s label (from memo)',
                                                'account' => 'Account\'s login',
                                                'account_label' => 'Account\'s label (from memo)',
                                                'documents' => 'Links to attachments',
                                                'balances' => 'Balances',
                                                'debts' => 'Debts',
                                                'prevovers' => 'Previous month overuses',
                                               ] as $key => $label) : ?>
                                    <strong>{<?= $key ?>}</strong> - <?= $label ?><br>
                                <?php endforeach ?>
                            </p>
                        </div>
                    </div>


                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">
                        <?= Yii::t('hipanel.document.mailout', 'Prepare') ?>
                    </button>
                </div>

                <?php ActiveForm::end() ?>

                <div v-if="isLoading" class="overlay"></div>
            </div>


        </div>

        <div :class="{'col-md-12': true, hidden: !collapsed}">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Yii::t('hipanel.document.mailout', 'Emails to send') ?></h3>
                </div>

                <?php $sendForm = ActiveForm::begin([
                    'action' => Url::to(['@mail-out/send']),
                    'enableClientValidation' => true,
                    'validateOnBlur' => false,
                    'validateOnChange' => false,
                    'enableAjaxValidation' => false,
                    'options' => [
                        'ref' => 'sendForm',
                        'data-confirm-message' => Yii::t('hipanel.document.mailout', 'Are you sure you want to send emails?'),
                        'data-success-message' => Yii::t('hipanel.document.mailout', 'Mail-out sent successfully'),
                    ],
                ]) ?>
                <div class="box-body">
                    <?= $sendForm->field($sendMailOutForm, 'recipients')->textarea(['v-model.trim' => 'mailOut.recipients', 'rows' => 15]) ?>
                    <?= Html::activeHiddenInput($sendMailOutForm, 'attach', ['v-model' => 'mailOut.attach', 'true-value' => '1', 'false-value' => '0']) ?>
                    <?= Html::activeHiddenInput($sendMailOutForm, 'direct_only', ['v-model' => 'mailOut.direct_only', 'true-value' => '1', 'false-value' => '0']) ?>
                    <?= Html::activeHiddenInput($sendMailOutForm, 'from', ['v-model' => 'mailOut.from']) ?>
                    <?= Html::activeHiddenInput($sendMailOutForm, 'subject', ['v-model' => 'mailOut.subject']) ?>
                    <?= Html::activeHiddenInput($sendMailOutForm, 'message', ['v-model' => 'mailOut.message']) ?>
                </div>
                <div class="box-footer" v-if="recipients.length > 0">
                    <button type="button" class="btn btn-default pull-left" @click="showModal">
                        <i class="fa fa-eye fa-fw"></i>
                        <?= Yii::t('hipanel.document.mailout', 'Emails preview') ?>
                    </button>&nbsp;
                    <button type="submit" class="btn btn-primary pull-right">
                        <i class="fa fa-send-o fa-fw"></i>
                        <?= Yii::t('hipanel.document.mailout', 'Send mail-out') ?>
                    </button>
                </div>

                <?php ActiveForm::end() ?>

                <div v-if="isLoading" class="overlay">
                    <i class="fa fa-circle-o-notch fa-spin"></i>
                </div>
            </div>

        </div>

    </div>

</div>
