<ul class="navbar-nav me-auto mb-2 mb-lg-0">
    <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="/">Главная</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/category/">Категории</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/dietcalc/">Диетологический калькулятор</a>
    </li>
</ul>

<?php if ($auth): ?>
    Добро пожаловать <?= $name ?>, <a href="/logout">[Выход]</a>
<?php else: ?>
    <form class="d-flex" action="/login" method="post">
        <input class="form-control input-sm" type="text" name="login" placeholder="Логин">
        <input class="form-control input-sm" type="password" name="pass" placeholder="Пароль">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" name="save" id="flexSwitchCheckDefault">
            <label class="form-check-label" for="flexSwitchCheckDefault">Запомнить? &nbsp;</label>
        </div>
        <button class="btn btn-outline-success btn-sm" type="submit">Вход</button>
    </form>
<?php endif; ?>

