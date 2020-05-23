<?php includePartial('header', 'Shared') ?>
<?php includePartial('menu', 'Shared', array('page' => 'cat')); ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Canais encontrados:</h1>
          </div>
         
            
                 <?php if(@$Data): ?>
                 <?php foreach($Data as $canal): ?>
            
            <!-- Content Row -->
                <div class="container">
                    <div class="row d-flex justify-content-center mb-5">
                        <div class="col-12 col-md-12 col-lg-10">
                            <div class="card border-left-primary">
                                 <div class="card-body">
                                <div class="row">
                                    <div class="py-3 col-12 col-lg-2 col-md-12">
                                            <img class=" rounded float-left shadow p-1" src="<?php echo $canal->canalAvatar ?>" alt="Imagem do canal" style="max-width: 100px; height: auto;">
                                    </div>
                                    <div class="col-12 col-md-12 col-lg-10">
                                        <div class="card-block">
                                            <h4 class="card-title ml-3"><?php echo $canal->canalNome ?></h4>
                                            
                                            <p class="card-text ml-3"><?php echo number_format($canal->canalInscritos, 0, "", ".") ?> inscritos</p>
                                            <hr class="">
                                            <a href="/canal/ver/<?php echo $canal->canalUsername ?>" class="btn btn-success btn-block ml-3" >Ver canal</a>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                      </div>
                      
                    <?php endforeach ?>
                    <?php else: ?>
                    <?php endif ?>
              
        </div>
        <!-- /.container-fluid -->
        
<?php includePartial('footer', 'Shared', array('page' => 'cat')); ?>