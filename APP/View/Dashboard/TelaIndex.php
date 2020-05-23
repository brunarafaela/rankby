<?php includePartial('header', 'Shared') ?>
<?php includePartial('menu', 'Shared', array('page' => 'cat')); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    <!--<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>-->
  </div>

  <!-- Content Row -->
  <div class="row">

   
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Canais Cadastrados</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $Data['canais']->total ?> <small>Canais</small></div>
            </div>
            <div class="col-auto">
              <i class="fab fa-youtube fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Países</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $Data['count_pais']->total ?> <small>países</small></div>
            </div>
            <div class="col-auto">
               <i class="fas fa-globe-americas fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Categorias</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $Data['categorias']->total ?> <small>categorias</small></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-folder-open fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>


    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Seguindo</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">7  <small>youtubers</small></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-user-plus fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  
  <div class="row">

    <div class="col-lg-6 mb-4">
      
      
     
      
      
      <!-- Illustrations -->
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Busca rápida</h6>
        </div>
        <div class="card-body">
          
          <div class="row">
            
            <div class="col-md-4">
              <!-- Dropdown Arrow -->
              <div class="dropdown mb-4">
                <select id="mudar_categoria" class="form-control selectpicker">
                  <option value="">Todas categorias</option>
                  <?php foreach($Data['categorias_list'] as $categoria) { ?>
                    <option value="<?php echo $categoria->categoriaId ?>"><?php echo $categoria->categoriaNome ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            
            <div class="col-md-4">
              <!-- Dropdown Arrow -->
              <div class="dropdown mb-4">
                <select id="mudar_pais" class="form-control">
                  <option value="">Todos Países</option>
                  <?php foreach($Data['paises'] as $pais) { ?>
                    <option value="<?php echo $pais->paisCode ?>"><?php echo $pais->paisNome ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            
            <div class="col-md-4">
              <!-- Dropdown Arrow -->
              
              <button class="btn btn-primary btn-block" type="button" id="submit_rank">
                Ver Ranking
              </button>
              
            </div>
            
          </div>
          
        </div>
      </div>
      
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">O que é o Rankby</h6>
        </div>
        <div class="card-body text-justify">
          <p>O rankby é uma plataforma colaborativa que rankeia canais do Youtube. Nossa missão é auxiliar marcas na procura por youtubers para suas campanhas com influenciadores digitais, facilitando o trabalho daquelas que não possuem verba o suficiente para contratar agências publicitárias, dando destaque a canais de grande a pequeno porte, de acordo com os critérios definidos por seus respectivos briefings. Nossa visão é se tornar uma empresa referência no mercado de marketing de conteúdo.</p>
          <hr>
             <p>Para utilizar a plataforma é bem simples: use a barra de pesquisa no topo para procurar um canal que queira visualizar. Caso ele não seja encontrado, basta clicar na aba de cadastrar e inserir sua URL. Para encontrar uma lista de canais, clique em ranking e faça seu filtro de acordo com seus critérios.</p>
              <hr>
             <p>Encontrou algum erro? Entre em <a href="http://rankby.online/contato">contato</a> nos informando, e se possível envie uma foto da tela. Ficaremos felizes em ter o seu feedback ou sugestões! Este sistema foi feito com carinho por alunos do curso de Análise e Desenvolvimento de Sistemas da FATEC Ipiranga, Bruna Rafaela e Alessandro Piazza, <em>heavy-users</em> do Youtube <3.</p>
        </div>
      </div>
      
      
      
    </div>
    
    
    <div class="col-lg-6 mb-4">

      <!-- Illustrations -->
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Países mais Populares</h6>
        </div>
        <div class="card-body">
          
          <div class="d-sm-flex">
           <ul class="list-unstyled">
            <li><a href="http://app.rankby.online/canal/ranking/pais/BR/"><img width="20%" style="padding: 10px" src="http://app.rankby.online/img/svg/br.svg" /> Brasil</a></li>
            <li><a href="http://app.rankby.online/canal/ranking/pais/IN/"><img width="20%" style="padding: 10px" src="http://app.rankby.online/img/svg/in.svg" />Índia</a></li>
            <li><a href="http://app.rankby.online/canal/ranking/pais/US/"><img width="20%" style="padding: 10px" src="http://app.rankby.online/img/svg/us.svg" /> Estados Unidos</a></li>
            <li><a href="http://app.rankby.online/canal/ranking/pais/CA/"><img width="20%" style="padding: 10px" src="http://app.rankby.online/img/svg/ca.svg" /> Canadá</a></li>     
          </ul>
          
          
        </div>
        
      </div>
    </div>
    
    
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">TOP 5 Canais</h6>
      </div>
      <div class="card-body">
        
        <div class="d-sm-flex">
         
         <ul class="list-unstyled">
         <?php foreach($Data['top_canais'] as $canal): ?>
          <li><a href="http://app.rankby.online/canal/ver/<?php echo $canal->canalUsername ?>"><img width="20%" style="padding: 10px" src="<?php echo $canal->canalAvatar ?>" /> <?php echo $canal->canalNome ?></a></li>
          <?php endforeach ?>
        </ul>
        
      </div>
      
    </div>
  </div>


</div>


</div>

</div>
<!-- /.container-fluid -->

<script>
    
    $(document).ready(function(){
       
        $('#submit_rank').click(function(){
            location.href = '/canal/ranking/pais/' + $('#mudar_pais').val() + '/categoria/' + $('#mudar_categoria').val();
        }); 
        
    });
    
</script>


<?php includePartial('footer', 'Shared', array('page' => 'cat')); ?>