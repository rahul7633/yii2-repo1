<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $nodes Array */

$this->title = 'Branch';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-12">
            <ul>
            <li class="glyphicon glyphicon-user" style="padding:5px;">&nbsp;<?php echo $nodes[0] [0] ['username'] ?></li>
            <?php writeNodes($nodes[0] [0] ['id'], $nodes); ?>
            </ul>
        </div>
    </div>
</div>

<?php function writeNodes($parentId, $nodes) {
    if (!isset($nodes[$parentId]) || !count($nodes[$parentId])) {
        echo '<ul><li class="glyphicon glyphicon-plus" style="padding:5px;">&nbsp;' 
        . '<a href="'.Url::to(array('/user/create', 'parent_id'=>$parentId)).'">'
        . 'Insert' 
        . '</a></li></ul>';
        return;
    }
    echo '<ul>';
    foreach($nodes[$parentId] as $item) {
        echo '<li class="" style="padding:5px;">&nbsp;' 
        . '<a href="'.Url::to(array('/user/index', 'parent_id'=>$item['id'])).'">'
        . $item ['username'] 
        . '</a></li>';
        writeNodes($item['id'], $nodes);
    }
    if (count($nodes[$parentId])<2) {
        echo '<li class="glyphicon glyphicon-plus" style="padding:5px;">&nbsp;' 
        . '<a href="'.Url::to(array('/user/create', 'parent_id'=>$item['parent_id'])).'">'
        . 'Insert' 
        . '</a></li>';
    }
    echo '</ul>';
}