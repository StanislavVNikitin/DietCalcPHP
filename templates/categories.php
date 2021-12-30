<h2>Категории продуктов</h2>

<div class="row">
<?php foreach ($category as $item): ?>
    <div class="col-4">
        <a href="/categoryitem/<?=$item['id']?>">
        <img src="/images/category/<?=$item['image']?>">
        <p><?=$item['name']?></p>
        <hr>
        </a>
    </div>
<?php endforeach; ?>
</div>
