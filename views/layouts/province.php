<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use kartik\sidenav\SideNav;
if(isset($_GET['dis_id'])){
    $dis_id=$_GET['dis_id'];
}else{
    $dis_id=null;
}
$user_id=yii::$app->user->id;
// var_dump($dis_id);die;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
     <?php
                NavBar::begin([
                    'brandLabel' => '<img src = "images/enblem.png"/ width="30" height="30"><p style="margin-top:-25px;margin-left:34px;">छोरी बचत खाता व्यवस्थापन प्रणाली</p>',
                    'brandUrl' => Yii::$app->homeUrl,
                    'options' => [
                        'class' => ' navbar-inverse navbar-fixed-top',
                        'style' => 'margin-top:0px; background-color:#2f4a75; ',
                        
                    ],
                ]);
                echo Nav::widget([
                    'options' => ['class' => 'navbar-nav navbar-right', 'style' => 'margin-top:0px;'],
                    'items' => [
                        ['label' => 'होम', 'url' => ['/site/index']],
                        Yii::$app->user->isGuest ? (
                                ['label' => 'बाहिर निस्कनुहोस', 'url' => ['/site/login']]
                                ) : (
                                '<li>'
                                . Html::beginForm(['/site/logout'], 'post')
                                . Html::submitButton(
                                        'बाहिर निस्कनुहोस (' . Yii::$app->user->identity->username . ')',
                                        ['class' => 'btn btn-link logout','style'=>'color:#FFFFFF;' ,'data' => ['confirm' => 'के तपाई यो प्रणालीबाट बाहिर निस्कनुहुन्छ ??']]
                                )
                                . Html::endForm()
                                . '</li>'
                                )
                    ],
                ]);


                NavBar::end();
                ?>
      <div class="col-md-12 col-xs-12" style="margin-top: 50px;margin-right: 10px; padding: 0px;">
      <?php if(isset($dis_id)){ ?>
                    <div class="col-md-2 col-xs-4 noprint sticky" style="padding: 0px;">
                      <?=  SideNav::widget([
	'type' => SideNav::TYPE_DEFAULT,
	'heading' => 'छोरी बचत खाता व्यवस्थापन प्रणाली',
    'options'=>['style'=>'background-color:#2f4a75;color:white;'],
	'items' => [
		
        [
			'url' => ['users/index'],
			'label' => ' प्रयोगकर्ता ',
			'icon' => 'user'
                        
		],
        [
			'url' => ['site/district-report','dis_id'=>$dis_id],
			'label' => ' रिपोर्ट ',
			'icon' => 'user'
                        
		],
        [
			'url' => ['economic-year/index'],
			'label' => ' आर्थिक वर्ष ',
			'icon' => 'user'
                        
		],
                
    
		
	],
]);
    ?>
                    </div>
                    <?php } else { ?>
                        <div class="col-md-2 col-xs-4 noprint sticky" style="padding: 0px;">
                      <?=  SideNav::widget([
	'type' => SideNav::TYPE_DEFAULT,
	'heading' => 'छोरी बचत खाता व्यवस्थापन प्रणाली',
	'items' => [
		
                
                
        [
			'url' => ['users/verification','id'=>$user_id],
			'label' => ' प्रोफाइल ',
			'icon' => 'glyphicon glyphicon-folder-open'
                        
		],
		
        [
			'url' => ['site/province-report'],
			'label' => ' रिपोर्ट ',
			'icon' => 'glyphicon glyphicon-list-alt'
                        
		],
        [
			'url' => ['users/index'],
			'label' => ' प्रयोगकर्ता ',
			'icon' => 'user'
                        
		],
        [
			'url' => ['economic-year/index'],
			'label' => ' आर्थिक वर्ष ',
			'icon' => '	glyphicon glyphicon-pencil'
                        
		],
        // [
		// 	'label' => ' सेट्टिङ्ग ',
		// 	'icon' => '	glyphicon glyphicon-cog',
		// 	'items' => [
                
        //         ['label' => ' वर्ष ', 'icon'=>'', 'url'=>['year/index']],
                
                
                                
				
		// 	],
        // ],
	],
]);
    ?>
                    </div>

<?php } ?>
                    <div class ="col-md-10 col-xs-8" style="float:right;">
                        <div class="">

                            
                    <?=Breadcrumbs::widget([
                    'homeLink' => [
                    'label' =>Html::encode(Yii::t('yii', 'होम')),
                    'url' => Yii::$app->homeUrl,
                    'encode' => false,
                    ],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ])?>
                            <?= Alert::widget() ?>

                            <?= $content ?>
                        </div>
                    </div>
                </div>
            </div>



<?php $this->endBody() ?>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/61ff8bd2b9e4e21181bdb000/1fr73kcae';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
</body>
</html>
<?php $this->endPage() ?>
