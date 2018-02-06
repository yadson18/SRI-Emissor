<div id='page-index'>
    <div class='company text-center col-sm-12'>
        <h1 class='title'>SRI Emissor</h1>
        <p class='col-sm-8 col-sm-offset-2'>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vulputate rhoncus mauris, vel hendrerit nunc commodo ut. Suspendisse quis tortor sem. Vestibulum blandit ipsum vel lacus egestas gravida. Curabitur nisl tortor, elementum non dolor vitae, lobortis maximus elit.
        </p>
    </div>
    <div class='features-content'> 
        <h3 class='title text-center'>Funcionalidades</h3>
        <div class='features'>
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
                            <div id='message-box'></div>
                            <div class='form-group icon-right'>
                                <?= $this->Form->input('', [
                                        'placeholder' => 'Digite seu CNPJ',
                                        'class' => 'cnpjMask form-control',
                                        'autofocus' => true,
                                        'name' => 'cnpj',
                                        'id' => false 
                                    ]) 
                                ?>
                                <i class='fas fa-id-card icon'></i>
                            </div>
                            <div class='form-group icon-right'>
                                <?= $this->Form->input('', [
                                        'placeholder' => 'Digite seu usuário',
                                        'class' => 'form-control',
                                        'name' => 'login',
                                        'id' => false
                                    ]) 
                                ?>
                                <i class='fas fa-user icon'></i>
                            </div>
                            <div class='form-group icon-right'>
                                <?= $this->Form->input('', [
                                        'placeholder' => 'Digite sua senha',
                                        'class' => 'form-control',
                                        'type' => 'password',
                                        'name' => 'senha',
                                        'id' => false
                                    ]) 
                                ?>
                                <i class='fas fa-key icon'></i>
                            </div>
                            <div class='form-group'>
                                <button class='btn btn-success btn-block' type='button' id='enter'>
                                    <span>Entrar</span> <i class='fas fa-sign-in-alt'></i>
                                </button>
                            </div>
                            <button class='btn btn-danger btn-block' type='button' data-dismiss='modal'>
                                <span>Fechar</span> <i class='fas fa-times'></i>
                            </button>
                        <?= $this->Form->end() ?>
                    </div>
                </div>
            </div>
        </div>
    <!-- Modal End -->
</div>