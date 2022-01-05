<h2> Вход на сайт </h2>

<?php if ($auth): ?>
    <h3>Здравствуйте <?= $name ?>, вы зашли на сайт! </h3> <a href="/auth/logout">[Выход]</a>
<?php else: ?>
    <form action="/auth/login" method="post">
        <div class="form-group">
            <label for="InputLogin">Логин</label>
            <input type="text" class="form-control" id="InputLogin" name="login" placeholder="Введите ваш логин">
        </div>
        <div class="form-group">
            <label for="InputPassword">Пароль</label>
            <input type="password" class="form-control" id="InputPassword" name="pass" placeholder="Введите ваш пароль">
        </div>
        <div class="form-group form-check">
            <input class="form-check-input" type="checkbox" role="switch" name="save" id="flexSwitchCheckDefault">
            <label class="form-check-label" for="flexSwitchCheckDefault">Запомнить? &nbsp;</label>
        </div>
        <button class="btn btn-outline-success btn-sm" type="submit"> Войти</button>
    </form>

<?php endif; ?>
