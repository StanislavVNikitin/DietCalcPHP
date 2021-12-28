<h1>Диетологический калькулятор</h1>
<?php if (!empty($message)): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong><?= $message ?></strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" data-bs-target="#my-alert"
                aria-label="Close"></button>
    </div>
<?php endif; ?>


<form action="/dietcalc/<?= $action ?>" method="post">
    <div>
        <input hidden type="text" name="idfoodtodiet" value="<?= $idfoodtodiet ?>"><br>
        <label for="selectFood" class="form-label">Выбор продукта для добавления</label>
        <select id="selectFood" class="form-select" aria-label="Default select example" name="foodid"
                <?php if ($action == "save"): ?>disabled<?php endif; ?>>
            <?php foreach ($foods as $food): ?>
                <option <?php if ($food['id'] == $idfood): ?>selected<?php endif; ?>
                        value="<?= $food['id'] ?>"><?= ($food['special_foods'] == 1) ? "**" : "" ?><?= $food['name'] ?><?= ($food['special_foods'] == 1) ? "**" : "" ?></option>
            <?php endforeach; ?>
        </select>
        <div class="input-group">
            <button type="button" class="col-2 btn btn-outline-danger" onclick="this.nextElementSibling.stepDown()">
                <b>-</b></button>
            <input id="inputCountFood" class="col-8 form-control multiple size" type="number" name="foodcount" min="0"
                   value="<?= $count ?>">
            <button type="button" class="col-2 btn btn-outline-success" onclick="this.previousElementSibling.stepUp()">
                <b>+</b></button>
        </div>
        <input id="submmitAddFood" type="submit" class="btn btn-primary mb-3 col-12" name="submit"
               value="<?= $button ?>">
    </div>
</form>

<table class="table table-bordered">
    <thead>
    <tr>
        <th class="col-6">Продукты</th>
        <th class="col-1">Кол.</th>
        <th class="col-1">Бел.</th>
        <th class="col-1">Жир.</th>
        <th class="col-1">Угл.</th>
        <th class="col-1">Калл.</th>
        <th class="col-1"></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($products as $item): ?>
        <tr>
            <td class="col-6"><?= $item['name'] ?></td>
            <td class="col-1"><?= $item['count'] ?></td>
            <td><?= $item['protein'] ?></td>
            <td><?= $item['fat'] ?></td>
            <td><?= $item['carbohydrates'] ?></td>
            <td><?= $item['calories'] ?></td>
            <td class="text-center"><a href="/dietcalc/edit/<?= $item['id'] ?>">[<b style="color: darkgoldenrod">E</b>]</a>&nbsp;&nbsp;<a
                        href="/dietcalc/delete/<?= $item['id'] ?>">[<b
                            style="color: red">D</b>]</a></td>
        </tr>
    <?php endforeach; ?>
    <tr>
        <th scope="row" colspan="12"></th>
    </tr>
    <tr>
        <td scope="row" colspan="2"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <th scope="row" colspan="2">Итого</th>
        <td><?= $sumnvpdiet['sumprotein'] ?></td>
        <td><?= $sumnvpdiet['sumfat'] ?></td>
        <td><?= $sumnvpdiet['sumcarbohydrates'] ?></td>
        <td><?= $sumnvpdiet['sumcalories'] ?></td>
        <td></td>
    </tr>
    </tbody>
</table>

<button type="button" class="btn btn-success">Сохранить диету</button>
<button type="button" class="btn btn-danger">Очистить все</button>