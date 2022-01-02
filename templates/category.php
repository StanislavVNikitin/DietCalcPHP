<h2>Категория  продуктов: <b><?=$namecategory?></b></h2>

<div class="row">
    <?php foreach ($categoryfood as $item): ?>
    <div class="col-3">
        <img src="/images/foods/<?=$item['image']?>" title = "<?=$item['name']?>">
        <p><?=$item['name']?></p>
        <div class="input-group">
        <div type="button" class="col-2 btn btn-outline-danger" onclick="this.nextElementSibling.stepDown()">
                <b>-</b></div>
        <input id="inputCountFood-<?=$item['id']?>" class="col-8 form-control multiple size" type="number" name="foodcount" min="0"
                   value="<?= $count ?>">
        <div type="button" class="col-2 btn btn-outline-success" onclick="this.previousElementSibling.stepUp()">
                <b>+</b></div>
        </div>
        <input id="submmitAddFood" type="submit" class="adddiet btn btn-primary mb-3 col-12" name="submit" data-id="<?=$item['id']?>"
               value="<?= $button ?>">
    </div>
<?php endforeach; ?>
</div>


<script>
    let buttons = document.querySelectorAll('.adddiet');

    buttons.forEach((elem) => {
        elem.addEventListener('click', () => {
            let id = elem.getAttribute('data-id');
            var count = document.getElementById("inputCountFood-"+id).value;
            ( async () => {
                    const response = await fetch('/api/addtodiet/', {method: 'POST', headers: new Headers({'Content-Type': 'application/json'}), body: JSON.stringify({foodid: id, foodcount: count})});
            })();
        })
    });
</script>