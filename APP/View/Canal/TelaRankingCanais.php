<?php includePartial('header', 'Shared') ?>
<?php includePartial('menu', 'Shared');
$url = "/canal/ranking/pais/" . $Data["form_pais"] . "/categoria/" . $Data["form_categoria"];
?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div class="col-md-6">
            <h1 class="h3 mb-2 text-gray-800">Ranking</h1>
            </div>
            
            <div class="col-md-2">
                  <!-- Dropdown Arrow -->
               <div class="dropdown mb-4">
                <select id="mudar_categoria" class="form-control">
                    <option value="">Todas categorias</option>
                    <?php foreach($Data['categorias'] as $categoria) { ?>
                    <option value="<?php echo $categoria->categoriaId ?>"><?php echo $categoria->categoriaNome ?></option>
                    <?php } ?>
                </select>
                </div>
            </div>
            
            <div class="col-md-2">
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
            
            <div class="col-md-2">
                <!-- Dropdown Arrow -->
               <div class="dropdown mb-4">
                    <button class="btn btn-primary btn-block dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Filtros
                    </button>
                    <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="<?php echo $url?>/ordem/seguidores">Mais inscritos</a>
                      <a class="dropdown-item" href="<?php echo $url?>/ordem/views">Mais visualizações em vídeos</a>
                    </div>
                  </div>
            </div>
            
             
                  
            </div>
            
          <!-- DataTales Example -->
          <div class="card shadow mb-4">

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th colspan="2">Canal</th>
                      <th>Inscritos</th>
                      <th>Média de Views</th>
                      <th>País</th>
                      <th></th>
                    </tr>
                  </thead>
                 
                  <tbody>
                      
                    <?php if(@$Data["canais"]): ?>
                    
                        <?php foreach($Data["canais"] as $canal): ?>
                        
                        <tr>
                          <td><img class="rounded"width="50px" src="<?php echo $canal->canalAvatar ?>"></td>
                          <td><strong><a href="/canal/ver/<?php echo $canal->canalUsername ?>"style="text-decoration:none; color:gray"><?php echo $canal->canalNome ?></a></strong></td>
                          <td><p class="text-center"><?php echo number_format($canal->canalInscritos, 0, "", ".") ?></p></td>
                          <td><p class="text-center"><?php echo number_format($canal->canalMediaVisualizacoes, 0, "", ".") ?></p></td>
                          <td><p class="text-center"><a href="/canal/ranking/pais/<?php echo $canal->paisCode ?>"><img width="20" src="/img/svg/<?php echo strtolower($canal->paisCode) ?>.svg"> <?php echo $canal->paisNome ?></a></p></td>
                          <td><a href="/canal/ver/<?php echo $canal->canalUsername ?>" class="btn btn-success btn-block" >Ver canal</a></td>
                        </tr>
                    
                    <?php endforeach ?>
                    <?php else: ?>
                    <?php endif ?>
                      
                
                  </tbody>
                </table>
                <br /><br />
                <center>
                <?php echo $Data['paginator'] ?>
                </center>
                
                
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->
        
  
  <script>
      
      $(document).ready(function(){
          
          <?php if($Data['form_pais']) { ?>
          $('#mudar_pais').val("<?php echo $Data['form_pais'] ?>");
          <?php } ?>
          
          <?php if($Data['form_categoria']) { ?>
          $('#mudar_categoria').val("<?php echo $Data['form_categoria'] ?>");
          <?php } ?>
          
          $('#mudar_pais').change(function(){
             location.href = '/canal/ranking/pais/' + $('#mudar_pais').val() + '/categoria/' + $('#mudar_categoria').val();
          });
          
          $('#mudar_categoria').change(function(){
             location.href = '/canal/ranking/pais/' + $('#mudar_pais').val() + '/categoria/' + $('#mudar_categoria').val();
          });
          
      })
      
  </script>
  
<?php includePartial('footer', 'Shared'); ?>     