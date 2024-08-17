<?php
?>
<main class="form-signin text-center">
    <form method="post" action="/login">
        <img class="mb-4" src="<?=DOCUMENT_STATIC?>/images/math.png" alt="" width="72" height="57">
        <h1 class="h3 mb-3 fw-normal">Вход в систему</h1>

        <div class="form-floating">
            <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email" required>
            <label for="floatingInput">Email address</label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="pass" required>
            <label for="floatingPassword">Password</label>
        </div>

        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="remember-me" name="addCookie"> Запомнить
            </label>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Отправить</button>
        <p class="mt-5 mb-3 text-muted">tynyanyi@mail.ru© 2024–<?=date("Y", time());?></p>
    </form>
</main>
