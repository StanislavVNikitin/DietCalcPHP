<h1>Регистрация пользователя</h1>

<form class="form-horizontal" action='/auth/register' method="POST">

    <div class="form-group">
        <label class="control-label" for="username">Имя пользователя Логин</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="Введите ваш логин">
    </div>

    <div class="form-group">
        <label class="control-label" for="email">E-mail</label>
        <input class="form-control" type="text" id="email" name="email" placeholder="Введите ваш Email">
    </div>

    <div class="form-group">
        <label class="control-label" for="password">Пароль</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Введите пароль">
    </div>

    <div class="form-group">
        <label class="control-label" for="password_confirm">Подтвердите пароль</label>
        <input type="password" class="form-control" id="password_confirm" name="password_confirm"
               placeholder="Введите пароль для подтверждения">
    </div>
    <br>
    <button class="btn btn-outline-success">Зарегистрироваться</button>

</form>

