<!DOCTYPE html>
<html>

<head>
    <title>Login Admin</title>
</head>

<body>
    <h2>Login Admin</h2>
    <?php if (session()->getFlashdata('error')): ?>
        <p style="color:red;"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>
    <form method="post">
        <p><label>Username: <input type="text" name="username" required></label></p>
        <p><label>Password: <input type="password" name="password" required></label></p>
        <button type="submit">Login</button>
    </form>
</body>

</html>