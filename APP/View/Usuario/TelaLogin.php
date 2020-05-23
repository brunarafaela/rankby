<?php includePartial('header', 'Shared'); ?>
<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Login</h1>
                  </div>

              <?php if (@$Data['result']['error']): ?>
              <div class="alert alert-danger" role="alert">
                <?php echo $Data['result']['error'] ?>
              </div>
              <?php endif ?>

                  <form class="user form-signin" method="post" action="/usuario/loginsubmit">
                    <div class="form-group">
                      <input type="email" name="emailLogar" required autofocus class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Digite o endereço de email...">
                    </div>

                    <div class="form-group">
                        <div class="input-group" id="show_hide_password">
                          <input type="password" name="passLogar" id="pass" class="form-control form-control-user" id="exampleInputPassword" placeholder="Senha" required>
                        <div class="input-group-addon" style="padding: 0.5rem .75rem;display: flex;align-items: center;margin-bottom: 0;font-size: 1rem;font-weight: 400;line-height: 1.25;color: #495057;text-align: center;background-color: #e9ecef;border: 1px solid #d1d3e2;border-left: 0px;border-top-right-radius: 10rem;border-bottom-right-radius: 10rem;">
                        <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                   </div>
                    </div>
                    </div>

                    <button class="btn btn-primary btn-user btn-block" type="submit">
                      Login
                    </button>
                    <hr>
                  </form>
                  <div class="text-center small">Não  possui uma conta?  <a href="/usuario/cadastrar">Cadastrar</a></div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>

<script type="text/javascript" language="JavaScript">
$(function () {
  $('[data-toggle="popover"]').popover()
})

$(document).ready(function() {
    $("#show_hide_password a").on('click', function(event) {
        event.preventDefault();
        if($('#show_hide_password input').attr("type") == "text"){
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass( "fa-eye-slash" );
            $('#show_hide_password i').removeClass( "fa-eye" );
        }else if($('#show_hide_password input').attr("type") == "password"){
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass( "fa-eye-slash" );
            $('#show_hide_password i').addClass( "fa-eye" );
        }
    });
});
</script> 