<option value="<?= $category['id']?>"
    <?php if($category['id'] == $this->model->parent_id) echo ' selected'?>
    <?php if($category['id'] == $this->model->id) echo ' disabled'?>
    ><?= $tab . $category['name']?>
</option>
<?php if( isset($category['childs']) ):     //Если у текущей категории есть потомки ?>
    <ul>
        <?= $this->getMenuHtml($category['childs'], $tab . ' - ')     //тогда вызываем метод getMenuHtml, который разбивает меню на подгруппы ?>
    </ul>
<?php endif;?>