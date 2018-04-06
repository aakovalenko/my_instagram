<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
use frontend\modules\user\models\forms\PictureForm;
use dosamigos\fileupload\FileUpload;

?>


<h3>It's <?php echo Html::encode($user->username);?> page!</h3>
<p><?php echo HtmlPurifier::process($user->about); ?></p>

<img src="<?php echo $user->getPicture();?>" id="profile-picture" alt="Pic" />

<?php if ($currentUser->equals($user)) : ?>

<div class="alert alert-success display-none" id="profile-image-success">Profile image update</div>
<div class="alert alert-danger display-none" id="profile-image-fail"></div>

<?= FileUpload::widget([
    'model' => $modelPicture,
    'attribute' => 'picture',
    'url' => ['/user/profile/upload-picture'], // your url, this is just for demo purposes,
    'options' => ['accept' => 'image/*'],

    // Also, you can specify jQuery-File-Upload events
    // see: https://github.com/blueimp/jQuery-File-Upload/wiki/Options#processing-callback-options
    'clientEvents' => [
        'fileuploaddone' => 'function(e, data) {
                               alert("1");
                            }',

    ],
]); ?>

<hr>
<?php endif; ?>

<?php if  (Yii::$app->user->identity['id'] !== $user->getId()) :  ?>
<a href="<?php echo Url::to(['/user/profile/subscribe', 'id' => $user->getId()]);?>" class="btn brn-info">Subscribe</a>
<a href="<?php echo Url::to(['/user/profile/unsubscribe', 'id' => $user->getId()]);?>" class="btn brn-info">Unsubscribe</a>
<?php endif ?>
<hr>
<?php if ($currentUser): ?>
<?php if(!Yii::$app->user->isGuest): ?>
<h5>Friends, who are also following <?php echo Html::encode($user->username); ?>: </h5>
<div class="row">
    <?php foreach ($currentUser->getMutualSubscriptionsTo($user) as $item): ?>
    <div class="col-md-12">
        <a href="<?php echo Url::to(['/user/profile/view', 'nickname' => ($item['nickname']) ? $item['nickname'] : $item['id']]); ?>">
            <?php echo Html::encode($item['username']); ?>
        </a>
    </div>
    <?php endforeach;?>
</div>
<?php endif;?>
<?php endif;?>
<hr>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal1">
   Subscriptions: <?php echo $user->countSubscriptions(); ?>
</button>

<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal2">
   Followers: <?php echo $user->countFollowers(); ?>
</button>

<!-- Modal 1-->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
               <div class="row">
                   <?php foreach ($user->getSubscriptions() as $subscription):?>
                   <div class="col-md-12">
                       <a href="<?php echo Url::to(['/user/profile/view', 'nickname' => ($subscription['nickname']) ? $subscription['nickname'] : $subscription['id']]); ?>">
                           <?php echo Html::encode($subscription['username']); ?>
                       </a>
                   </div>
                   <?php endforeach; ?>
               </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>

<!-- Modal 2 -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php foreach ($user->getFollowers() as $follower):?>
                        <div class="col-md-12">
                            <a href="<?php echo Url::to(['/user/profile/view', 'nickname' => ($follower['nickname']) ? $follower['nickname'] : $follower['id']]); ?>">
                                <?php echo Html::encode($follower['username']); ?>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>