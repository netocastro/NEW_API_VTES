<?php $v->layout('_template'); ?>

<div class="container">
      <div class="row mt-5">
            <div class="col-md-5 offset-md-3">
                  <div class="login-form bg-success text-light mt-4 p-4">
                        <form id="form-register" action="<?= $route->route('user.store'); ?>" method="POST" data-type="JSON" class="row g-3">
                              <h4>Registrar-se</h4>
                              <div class="col-12">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="name">
                              </div>
                              <div class="col-12">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="email">
                              </div>
                              <div class="col-12">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="Password">
                              </div>
                              <div class="col-12">
                                    <label>Repeat password</label>
                                    <input type="password" name="repeat_password" class="form-control" placeholder="Repeat repeat_password">
                              </div>
                              <div class="col-12">
                                    <div class="d-grid gap-2 col-12 mx-auto">
                                          <button type="submit" class="btn btn-dark float-end">Registrar</button>
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

<?php $v->start('js'); ?>

<script src="view/js/register.js"></script>

<?php $v->end(); ?>