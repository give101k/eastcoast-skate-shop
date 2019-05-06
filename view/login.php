<!DOCTYPE html>
<html>
  <head>
    <title>EastCost Skate Shop</title>
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" type="text/css" href="css/login.css" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
  </head>
  <html>
    <body class="text-center">
        <div>
        <form action="." method="post" id="login_form" class="form-signin">
          <input type="hidden" name="action" value="login" />
          <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
          <label class="sr-only">Email:</label>
          <input
            type="text"
            name="email"
            class="form-control"
            id="inputEmail"
            placeholder="Username"
            required
            autofocus
          />
          <label class="sr-only">Password:</label>
          <input
            type="password"
            name="password"
            class="form-control"
            id="inputPassword"
            placeholder="Password"
            required
          />
          <input
            type="submit"
            value="Login"
            class="btn btn-lg btn-primary btn-block"
          />
          <?php if ($login_message != null): ?>
          <div class="alert-danger alert top">
            <?php echo $login_message; ?>
          </div>
          <?php endif; ?>
        </form>
        <a href="index.php?action=home">
          <button class="btn btn-lg btn-primary btn-block">
            Home
          </button>
        </a>
        </div>
    </body>
  </html>
</html>
