<?php

use \kartik\grid\GridView;
use \app\components\WidgetHelper;

?>

<h1>Список для <?= ($listType == 'teacher') ? 'преподавателя' : 'менеджера' ?></h1>

<?php

if ($dataProvider) {
    echo GridView::widget(WidgetHelper::widgetGridList($listType, $dataProvider, Yii::$app->request->get(1)['lesson_type']));
}

// move header to the top
$js = <<<JS
let title = $('#w0-container tr.kv-grid-group-row');
let head = $('#w0-container thead');
title.prependTo(head);
JS;

$this->registerJs($js);
?>
