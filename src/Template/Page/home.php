<div id='home' class='col-md-12 col-sm-12 col-xs-12'>
    <div class='banner'>
        <h1 class='title'>SRI Emissor</h1>
        <h3>Emissão de NFe e muito mais.</h3>
    </div>
    <div class='features' id='features'>
        <h1 class='title'>Funcionalidades</h1>
        <div class='row'>
            <div class='col-sm-4'>
                <div class='thumbnail'>
                    <div class='icon'>
                        <i class='fas fa-chart-bar'></i>
                    </div>
                    <div class='caption'>
                        <h3>Example 1</h3>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent placerat felis est, et sollicitudin nibh sollicitudin ac. Mauris non porttitor massa. Quisque ut lobortis augue, sit amet malesuada lacus. Etiam a dapibus elit.
                        </p>
                        <p>
                            <a href='#' class='btn btn-primary' role='button'>Button</a> 
                            <a href='#' class='btn btn-default' role='button'>Button</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class='col-sm-4'>
                <div class='thumbnail'>
                    <div class='icon'>
                        <i class='fas fa-chart-line'></i>
                    </div>
                    <div class='caption'>
                        <h3>Example 2</h3>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent placerat felis est, et sollicitudin nibh sollicitudin ac. Mauris non porttitor massa. Quisque ut lobortis augue, sit amet malesuada lacus. Etiam a dapibus elit.
                        </p>
                        <p>
                            <a href='#' class='btn btn-primary' role='button'>Button</a> 
                            <a href='#' class='btn btn-default' role='button'>Button</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class='col-sm-4'>
                <div class='thumbnail'>
                    <div class='icon'>
                        <i class='fas fa-chart-area'></i>
                    </div>
                    <div class='caption'>
                        <h3>Example 3</h3>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent placerat felis est, et sollicitudin nibh sollicitudin ac. Mauris non porttitor massa. Quisque ut lobortis augue, sit amet malesuada lacus. Etiam a dapibus elit.
                        </p>
                        <p>
                            <a href='#' class='btn btn-primary' role='button'>Button</a> 
                            <a href='#' class='btn btn-default' role='button'>Button</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Login -->
        <div class='modal fade' id='login' role='dialog'>
            <div class='col-sm-4 col-sm-offset-4 modal-top'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <button type='button' class='close' data-dismiss='modal'>
                            <i class='fas fa-times'></i>
                        </button>
                        <h4 class='modal-title text-center'>Login</h4>
                    </div>
                    <div class='modal-body'>
                        <?= $this->Form->start([]) ?>
                            <div>
                                <?= $this->Flash->showMessage() ?>
                            </div>
                            <div class='icon-right'>
                                <?= $this->Form->input('', [
                                        'placeholder' => 'Digite seu CNPJ',
                                        'required' => true,
                                        'name' => 'cnpj' 
                                    ]) 
                                ?>
                                <i class="fas fa-id-card"></i>
                            </div>
                            <div class='icon-right'>
                                <?= $this->Form->input('', [
                                        'placeholder' => 'Digite seu usuário',
                                        'required' => true,
                                        'name' => 'login'
                                    ]) 
                                ?>
                                <i class="fas fa-user"></i>
                            </div>
                            <div class='form-group icon-right'>
                                <?= $this->Form->input('', [
                                        'placeholder' => 'Digite sua senha',
                                        'type' => 'password',
                                        'required' => true,
                                        'name' => 'senha'
                                    ]) 
                                ?>
                                <i class="fas fa-key"></i>
                            </div>
                            <div class='form-group'>
                                <?= $this->Form->button("Entrar <i class='fas fa-sign-in-alt'></i>", [
                                        'class' => 'btn btn-success btn-block',
                                        'type' => 'button'
                                    ]) 
                                ?>
                            </div>
                            <div class='form-group'>
                                <?= $this->Form->button("Fechar <i class='fas fa-times'></i>", [
                                        'class' => 'btn btn-danger btn-block',
                                        'data-dismiss' => 'modal',
                                        'type' => 'button'
                                    ]) 
                                ?>
                            </div>
                        <?= $this->Form->end() ?>
                    </div>
                </div>
            </div>
        </div>
    <!-- Modal End -->
</div>