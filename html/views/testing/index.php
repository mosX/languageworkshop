<div class="container">
    <form class="form">
        <?php foreach($this->m->data as $item){ ?>
            <h3><?=$item->value?></h3>
            <ul>
                <?php foreach($item->answers as $answer){ ?>
                    <li><input type="checkbox"> <?=$answer->text?></li>
                <?php } ?>
            </ul>
        <?php } ?>
        <div class="form-group">
            <input type="submit" value="Проверить">
        </div>
    </form>
</div>