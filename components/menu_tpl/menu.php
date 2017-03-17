<li>
    <a href="<?= \yii\helpers\Url::to(['category/view', 'id' => $category['id']])   //Добавляем каждой ссылке(строке) идентификатор категории с помощью виджета MenuWidget ?>">
        <?= $category['name']?>
        <?php if (isset($category['childs'])): ?>
            <span class="badge pull-right"><i class="fa fa-plus"></i></span>
        <?php endif; ?>
    </a>
    <?php if (isset($category['childs'])):  //Если существуют потомки ?>
        <ul>
            <?= $this->getMenuHtml($category['childs']) ?>
        </ul>
    <?php endif; ?>
</li>

