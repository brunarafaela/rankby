<?php includePartial('header', 'Shared') ?>
<body class="bg-gradient-primary">
    <script>
     
</script>

  <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
          <div class="col-lg-7">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Crie uma conta!</h1>
              </div>
            <div id="erro">
              
            </div>
            <?php if (@$Data['result']['error']): ?>
              <div class="alert alert-danger" role="alert">
                <?php echo $Data['result']['error'] ?>
              </div>
              <?php endif ?>
                
                
              <form class="user form-signin"  method="post" action="/Usuario/cadastro_submit" id="formCadastroUsuario" name="formCadastroUsuario">
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" onkeyup="return validarNome()" name="nomeRegister" id="name" pattern="[A-Za-z\s]+$"  autofocus placeholder="Nome">
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" onkeyup="return validarSobrenome()" name="sobrenomeRegister" id="lastName" pattern="[A-Za-z\s]+$"  autofocus placeholder="Sobrenome">
                  </div>
                </div>
                <div class="form-group">
                  <input type="text" id="email" class="form-control form-control-user" onkeyup="return validarEmail()" name="emailRegister"  placeholder="Endereço de email">
                </div>

                <div class="form-group">
                 <div class="input-group" id="show_hide_password">
               
                <input  type="password" name="passRegister"  id="pass" onkeyup="return validarSenha()" class="form-control form-control-user" placeholder="Senha" >
              
                <div class="input-group-addon" style="padding: 0.5rem .75rem;display: flex;align-items: center;margin-bottom: 0;font-size: 1rem;font-weight: 400;line-height: 1.25;color: #495057;text-align: center;background-color: #e9ecef;border: 1px solid #d1d3e2;border-left: 0px;border-top-right-radius: 10rem;border-bottom-right-radius: 10rem;">
                  <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                </div> 

                <a style = "cursor:Pointer"class="" data-toggle="popover" title="Dica de senha" data-content="Deve conter pelo menos um número e uma letra maiúscula e minúscula e pelo menos 8 ou mais caracteres e caracteres especiais"><i class="fas fa-question-circle"></i></a>  
               
                </div>
                </div>
                <div id="erroSenhaForca">
                    
                </div>
                <button type="submit" href="login.html" onclick="return validarForm()" class="btn btn-primary btn-user btn-block">
                  Criar conta
                </button>
              </form>
              <hr>
              <div class="text-center small">
               Já possui uma conta? <a href="/usuario/login"> Acessar!</a>
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
function validarForm(){
    if(validarNome() === true && validarSobrenome() === true && validarEmail() === true){
        return true;
    }else{
        document.getElementById("erro").innerHTML = '<div class="alert alert-danger" role="alert">Preencha todos os campos corretamente para efetuar o cadastro</div>';
        return false;
    }
}

    function validarNome(){
        var nome = document.getElementById('name').value;
        var corCampoNome = document.getElementById('name');
         if(nome =="" || nome.length < 3 || !isNaN(nome)){
            corCampoNome.style.border = "1px solid red";
            return false;
        }else{
            corCampoNome.style.border = "1px solid green"
            return true;
        }
    }
    function validarSobrenome(){
        var sobrenome = document.getElementById('lastName').value;
        var corCampoSobrenome = document.getElementById('lastName');
        
        if(sobrenome =="" || sobrenome.length < 3 || !isNaN(sobrenome)){
            corCampoSobrenome.style.border = "1px solid red";
            
            return false;
        }else{
            corCampoSobrenome.style.border = "1px solid green"
           
            return true;
        }
    }

  function validarEmail(){
        var email = document.getElementById('email').value;
        var corCampoEmail = document.getElementById('email');
        if(email == "" || !isNaN(email) || email.length < 5 || email.indexOf('@') == -1 || email.indexOf('.') == -1){
            corCampoEmail.style.border = "1px solid red";
            return false;
        }else{
            corCampoEmail.style.border = "1px solid green";
            return true;
        }
}

function validarSenha(){
    var senha = document.getElementById('pass').value;
    var forca = 0;
    
    if((senha.length >= 4) && (senha.length <= 7)){
		forca += 10;
	}else if(senha.length > 7){
		forca += 25;
	}

	if((senha.length >= 5) && (senha.match(/[a-z]+/))){
		forca += 10;
	}

	if((senha.length >= 6) && (senha.match(/[A-Z]+/))){
		forca += 20;
	}

	if((senha.length >= 7) && (senha.match(/[@#$%&;*]/))){
		forca += 25;
	}

	if(senha.match(/([1-9]+)\1{1,}/)){
		forca += -25;
	}
	
	if(forca < 30 ){
		document.getElementById("erroSenhaForca").innerHTML = 'Força da Senha<div class="progress mb-3"><div class="progress-bar bg-danger" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div></div>';
	}else if((forca >= 30) && (forca < 50)){
		document.getElementById("erroSenhaForca").innerHTML = 'Força da Senha<div class="progress mb-3"><div class="progress-bar bg-warning" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div></div>';
	}else if((forca >= 50) && (forca < 70)){
		document.getElementById("erroSenhaForca").innerHTML = 'Força da Senha<div class="progress mb-3"><div class="progress-bar bg-info" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div></div>';
	}else if((forca >= 70) && (forca < 100)){
		document.getElementById("erroSenhaForca").innerHTML = 'Força da Senha<div class="progress mb-3"><div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div></div>';
	}
    
}
    

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