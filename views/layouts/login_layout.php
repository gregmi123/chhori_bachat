<?php
use yii\helpers\Html;
use app\assets\AppAsset;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" sizes="76x76" href="theme/assets/img/apple-icon.png">
        <link rel="icon" type="image/png" href="images/enblem.png">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <style>
body {
	font-family: sans-serif;
	
	
}
body{
	height: 500px;
	width: 500px;
	background-color:#EBF3FA;
      
        

}
label{
   float: left;
   margin-left: 70px;
}
.header img {
	border-radius: 25px;
	height: 100px;
	width: 100px;
	margin: auto;
	margin-top:20px;
}
.container{
	/* width: 450px;
	height: 500px;
	margin: 15% auto;
	
	background-color: 
	
	margin-left: 470px; */
	
  width: 450px;
  height: 500px;
  background-color: #1766d4;;
  position: absolute;
  box-shadow: 0 0 10px #333;
  border-radius: 25px;
  /*it can be fixed too*/
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
  margin: auto;
  /*this to solve "the content will not be cut when the window is smaller than the content": */
  max-width: 100%;
  max-height: 100%;
  overflow: auto;

}
.header{
	text-align: center;
	
}
 .header h1{
 	color: #333 ;
 	font-size: 45px;
 	margin-bottom: 30px;
 }
 .main {
 	text-align: center;
 }

 .help-block{
     color: red;
    
 }
 

 .main span{
 	position: relative;

 }
 
 .main button {
 	padding-left: 0px;
 	background-color: #83acf1;
 	letter-spacing: 1px;
 	font-weight: bold;
 }

 .main button:hover{
 	box-shadow: 2px 2px 5px #555;
 }
.main img{
	height: 40px;
	width: 20px;
	margin-left: -10px;
	margin-bottom: 200px;
}
</style>
    </head>

    <body class="login-page">
        <?php $this->beginBody() ?>

        <?= $content ?>

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
