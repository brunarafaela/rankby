<?php includePartial('header', 'Shared') ?>
<?php includePartial('menu', 'Shared', array('page' => 'cat')); ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Meu perfil</h1>
          </div>

          <!-- Content Row -->
         
            <div class="row mx-auto">
                <div class="col-lg-8 mx-auto">
                    
                    <div id="alertbox">
				    <?php if (@$Data['result']['success']): ?>
				        <div class="alert alert-success" role="alert">
						    <?php echo $Data['result']['success'] ?>
						 </div>
            			  <?php elseif (@$Data['result']['error']): ?>
						<div class="alert alert-danger" role="alert">
					        <?php echo $Data['result']['error'] ?>
					    </div>
					 <?php endif ?>
				</div>
				
                    <form method="post" action="/Usuario/alterarsenha" name="formEditProfile" action="" class="form mx-auto">
                        
                    <div class="form-group">
                    <label for="inputPassword">Senha</label>
                    <a style = "cursor:Pointer"class="" data-toggle="popover" title="Dica de senha" data-content="Deve conter pelo menos um número e uma letra maiúscula e minúscula e pelo menos 8 ou mais caracteres"><i class="fas fa-question-circle"></i></a>
                 <div class="input-group" id="show_hide_password">
                      <input onkeyup="validarSenhaForca()" type="password" name="passRegister" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" id="pass" class="form-control"  required>
             <div class="input-group-addon" style="padding: .5rem .75rem;margin-bottom: 0;font-size: 1rem;font-weight: 400;line-height: 1.25;color: #495057;text-align: center;background-color: #e9ecef;border: 1px solid rgba(0,0,0,.15);border-radius: .25rem;border-left: 0px;border-top-left-radius: 0px; border-bottom-left-radius: 0px;">
                    <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>      
               </div>
                </div>
                 </div>
                 <div class="form-group">
                     <div id="erroSenhaForca">
                         
                     </div>
                     <div class = "input-group" id = "impForcaSenha"></div>
                        <div id="erroSenhaForca">
                     </div>
                 </div>
                    <button class="btn btn-md btn-primary btn-block text-uppercase" type="submit" onclick="return vSenha()">Salvar</button>
                </form>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->
        
        
<?php includePartial('footer', 'Shared', array('page' => 'cat')); ?>

	
<script type="text/javascript" language="JavaScript">
	function validarSenhaForca(){
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

	mostrarForca(forca);
}

function mostrarForca(forca){
	if(forca < 30 ){
		document.getElementById("erroSenhaForca").innerHTML = 'Força da Senha<div class="progress"><div class="progress-bar bg-danger" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div></div>';
	}else if((forca >= 30) && (forca < 50)){
		document.getElementById("erroSenhaForca").innerHTML = 'Força da Senha<div class="progress"><div class="progress-bar bg-warning" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div></div>';
	}else if((forca >= 50) && (forca < 70)){
		document.getElementById("erroSenhaForca").innerHTML = 'Força da Senha<div class="progress"><div class="progress-bar bg-info" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div></div>';
	}else if((forca >= 70) && (forca < 100)){
		document.getElementById("erroSenhaForca").innerHTML = 'Força da Senha<div class="progress"><div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div></div>';
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