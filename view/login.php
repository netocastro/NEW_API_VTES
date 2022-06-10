<?php $v->layout('_template'); ?>

<div id="background-login">
      <div class="container">
            <div class="row pt-5">
                  <div class="col-md-4 offset-md-4">
                        <div class="login-form bg-success text-light mt-4 p-4">
                              <form id="form-login" action="<?= $route->route('user.login') ?>" method="POST" data-type="JSON" class="row g-3">
                                    <h4>Login</h4>
                                    <div class="col-12">
                                          <label>Email</label>
                                          <input type="email" name="email" class="form-control" placeholder="email">
                                    </div>
                                    <div class="col-12">
                                          <label>Password</label>
                                          <input type="password" name="password" class="form-control" placeholder="Password">
                                    </div>
                                    <!--<div class="col-12">
                                    <div class="form-check">
                                          <input class="form-check-input" type="checkbox" id="rememberMe">
                                          <label class="form-check-label" for="rememberMe">Lembrar-me</label>
                                    </div>
                              </div>-->
                                    <div class="col-12">
                                          <div class="d-grid gap-2 col-12 mx-auto">
                                                <button type="submit" class="btn btn-dark float-end">Login</button>
                                                <div class="d-none justify-content-center mt-3 load">
                                                      <div class="spinner-border text-primary" role="status">
                                                            <span class="visually-hidden">Loading...</span>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                              </form>
                              <hr class="mt-4">
                              <div class="col-12">
                                    <p class="text-center mb-0">Recuperar senha <a href="#" class="text-info">Signup</a></p>
                              </div>
                        </div>
                  </div>
            </div>
      </div>
</div>

<?php $v->start('js'); ?>
<script>
      let userPanel = '<?= $route->route('web.home') ?>';
</script>

<script src="view/js/login.js"></script>

<?php $v->end(); ?>