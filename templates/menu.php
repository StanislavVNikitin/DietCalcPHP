<ul class="navbar-nav me-auto mb-2 mb-lg-0">
    <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="/">Главная</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/categories/">Категории</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/dietcalc/">Диетологический калькулятор( <span id="protein"><?=($protein)?$protein:0?> </span> бел. <span id="calories"><?=($calories)?$calories:0?></span> ККалл )</a>
    </li>
</ul>

<?php if ($auth): ?>
    Добро пожаловать <?= $name ?>, <a href="/auth/logout">[Выход]</a>
<?php else: ?>
    <form class="d-flex" action="/auth/login" method="post">
        <input class="form-control input-sm" type="text" name="login" placeholder="Логин">
        <input class="form-control input-sm" type="password" name="pass" placeholder="Пароль">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" name="save" id="flexSwitchCheckDefault">
            <label class="form-check-label" for="flexSwitchCheckDefault">Запомнить? &nbsp;</label>
        </div>
        <button class="btn btn-outline-success btn-sm" type="submit"> Вход </button>
        <a class="btn btn-outline-primary  btn-sm" href="/auth"> Зарегистрироваться </a>
    </form>

<?php endif; ?>

