<?php includePartial('header', 'Shared') ?>
<?php includePartial('menu', 'Shared', array('page' => 'cat')); ?>

<!-- Begin Page Content -->


<div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="container">
                    <div class="col-12 d-flex justify-content-center">
                        <img src="<?php echo $Data->canalAvatar ?>" style="width:210px;height:210px;" class="shadow p-1 mb-1 bg-white rounded">
                    </div>
                    <div class="col-12  d-flex justify-content-start">
                        <h3 class="text-secondary">
                            <?php echo $Data->canalNome ?>
                        </h3>
                    </div>
                    <div class="col-12  d-flex justify-content-start">
                        <p class="text-secondary">
                            <?php echo $Data->canalUsername ?>
                        </p>
                    </div>
                    <div class="col-12 d-flex">
                        <a class="btn btn-danger mr-4" href="<?php echo $Data->canalURL ?>"><i class="fab fa-youtube"></i> Canal</a>
                        <div class="float-right">
                            <?php if($Data->following): ?>
                        <a href="#" id="follow_channel" data-id="<?php echo $Data->idCanal ?>" data-following="true" class="btn btn-success btn-icon-split float-right">
                            <span class="icon text-white-50">
                                <i class="fas fa-check"></i>
                            </span>
                            <span class="text">Seguindo</span>
                        </a>
                        <?else: ?>
                            <a href="#" id="follow_channel" data-id="<?php echo $Data->idCanal ?>" data-following="false" class="btn btn-primary btn-icon-split float-right">
                                <span class="icon text-white-50">
                             <i class="fas fa-plus"></i>
                                    </span>
                                <span class="text">Seguir</span>
                            </a>
                            <?endif ?>
                        </div>

                    </div>
                    <hr>
                    <div class="col-12">
                        <h1 class="text-secondary">#<?php echo $Data->ranking_global ?> Global</h1>
                        <h1 class="text-secondary">#<?php echo $Data->ranking_local ?> Em <?php echo ($Data->paisId) ? "<a href=\"/canal/ranking/pais/".$Data->paisId."\"><img width=\"45px\" src=\"/img/svg/" . strtolower($Data->paisId) . ".svg\"></a>" : "Sem país" ?>
                        
                        </h1>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <p class="text-secondary float-left"><strong>Inscritos:</strong></p>
                            <p class="text-secondary float-right">
                                <?php echo number_format($Data->canalInscritos, 0, "", ".") ?>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <p class="text-secondary float-left"><strong>Visualizações:</strong></p>
                            <p class="text-secondary float-right">
                                <?php echo number_format($Data->canalVisualizacoes, 0, "", ".") ?>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <p class="text-secondary float-left"><strong>Número de vídeos:</strong></p>
                            <p class="text-secondary float-right">
                                <?php echo number_format($Data->canalVideos, 0, "", ".") ?>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <p class="text-secondary float-left"><strong>Média de visualizações:</strong></p>
                            <p class="text-secondary float-right">
                                <?php echo number_format($Data->canalMediaVisualizacoes, 0, "", ".") ?>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <p class="text-secondary float-left"><strong>Desde:</strong></p>
                            <p class="text-secondary float-right">
                                <?php 
                                $s = $Data->canalCriacao;
                               $date = strtotime($s);
                              echo date('d/m/Y', $date);
                              ?>
                            </p>
                        </div>
                    </div>

                </div>


            </div>
            <div class="col-12 col-lg-8 border-left">
                <div class="container">
                    <!--<div class="row">-->
                    <!--    <div class="col-lg-4">-->
                    <!--        <h3><a style="cursor:pointer;color:#6c757d" id="videosBtn">Vídeos</a></h3>-->
                    <!--    </div>-->
                    <!--     <div class="col-lg-4">-->
                    <!--        <h3><a style="cursor:pointer;color:#6c757d" id="historicoBtn">Histórico</a></h3>-->
                    <!--    </div>-->
                    <!--</div>-->
                    <div class="row ml-5" id="videos">
                      
                            <iframe width="100%" height="315" src="https://www.youtube.com/embed/?list=<?php echo $Data->canalPlaylistEnvios ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    
                    </div>
                    <div class="row ml-5" id="sobre">
                        <pre class="mt-5" style=" font-family: Arial, Helvetica, sans-serif;"><strong>Descrição:</strong>
                                <p><?php echo $Data->canalDescricao ?></p>
                            </pre>
                        <div class="col-12 d-flex justify-content-start my-2">
                            <p><strong>Categoria:</strong> <?php echo (@$Data->categories) ? implode(', ', $Data->categories) : "Sem categorias" ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- /.container-fluid -->


<?php includePartial('footer', 'Shared', array('page' => 'cat')); ?>

<script>
 jQuery(function($) {
            
             $("#videosBtn").css("color", "#2a2c2e");
            // Códigos jQuery a serem executados quando a página carregar usando o pseudônimo (alias) $ de forma a não conflitar com outras bibliotecas JavaScript.
        });
        $(document).ready(function() {
            $("#sobreBtn").click(function() {
                $("#videosBtn").css("color", "#6c757d");
                $("#sobreBtn").css("color", "#2a2c2e");

                
            });
        });
        $(document).ready(function() {
            $("#videosBtn").click(function() {
                $("#videosBtn").css("color", "#2a2c2e");
                $("#sobreBtn").css("color", "#6c757d");
             
                $("#videos").css("display", "block");
            });
        });
  
  $(document).ready(function() {
   
   $('#follow_channel').click(function(){
    
    var id = $(this).attr("data-id"); 
    var following = $(this).attr("data-following"); 
    var self = this;
    
    if (following == "true") {
      $.post("/Canal/unfollow/", {"idCanal": id}, function(data) {
        
        if (data.success) {
          $(self).html('<span class="icon text-white-50"><i class="fas fa-plus"></i></span><span class="text">Seguir</span>').addClass("btn-primary").removeClass("btn-success");
          $(self).attr("data-following", "false");
        } else {
          alert(data.error);
        }
        
      }, "json");
    } else {
     $.post("/Canal/follow/", {"idCanal": id}, function(data) {
      
      if (data.success) {
        $(self).html('<span class="icon text-white-50"><i class="fas fa-plus"></i></span><span class="text">Seguindo</span>').addClass("btn-success").removeClass("btn-primary");
        $(self).attr("data-following", "true");
      } else {
        alert(data.error);
      }
      
    }, "json"); 
   }
   
   
   
 });
   
   
   
 });
  
</script>
