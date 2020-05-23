<?php includePartial('header', 'Shared') ?>
<?php includePartial('menu', 'Shared'); ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Cadastrar Canal</h1>
          </div>

          <!-- Content Row -->
          <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-8 mx-auto">
              <div class="card card-signin my-8">
                <div class="card-body">
                        <?php if (@$Data['result']['error']): ?>
							<div id="erroUrl" class="alert alert-danger" role="alert">
								<?php echo $Data['result']['error'] ?>
							</div>
				    		<?php endif ?>
				    		<div id="erro"></div>
                   <form name="cadastrarCanalForm" class="form-signin" method="post" action="/canal/crawl" > 
                    <div class="form-group">
                      <input type="text" class="form-control" id="urlRegister" name="urlRegister" placeholder="Cole o link aqui" required>
                      <small id="emailHelp" class="form-text text-muted">Formato do link: https://www.youtube.com/user/justliatv</small>
                     </div>
                    <button class="btn btn-md btn-primary btn-block text-uppercase" type="submit">Cadastrar</button>
                  </form>
                </div>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

        
<?php includePartial('footer', 'Shared'); ?>