<div class="card p-4">
    <img class="card-img-top mb-4" src="https://i.ibb.co/dPRz139/pexels-luis-quintero-15778613.jpg" alt="Card image cap">
    <h2>Login</h2>
    <?php
    use gira\core\form\Form;
    $form = Form::begin('post', '');
    echo $form->filed($model, 'email', 'Enter your email', 'email', 'Email@gmail.com');
    echo $form->filed($model, 'password', 'Enter your password', 'password', '******');
    $end = Form::end('Login');
    ?>
</div>