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
                    
                         <div class="row">
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
                        </div>
            
                    <form method="post" action="/Usuario/editar_perfil" name="formEditProfile" action="" class="form mx-auto">
                        
                        <input type="hidden" name="idUsuario" value="<?php echo Session()->get('aid') ?>" />
                        
                    <div class="form-group">
                            <label>Nome</label>
                            <input type="text"  name="nomeUpdate" id="nome" class="form-control" value="<?php echo Session()->get('nome') ?>" required />
                    </div>
                    <div class="form-group">
                            <label>Sobrenome</label>
                            <input type="text"  name="sobrenomeUpdate" id="sobrenome" class="form-control" value="<?php echo Session()->get('sobrenome') ?>"  required  />
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text"  name="emailUpdate" id="email" class="form-control" value="<?php echo Session()->get('email') ?>"  required/>
                    </div>
                   
                 <div class="form-group">
                     
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