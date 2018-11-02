<div class="modal-wrapper">

    <!-- Formulário de login -->
    <div class="modal-dialog">
        <div class="modal-content" id="login-modal">
            
            <!-- Hedader --> 
            <div class="modal-header">
                <h3>Prossiga para a sua conta pessoal</h3>
            </div>

            <!-- Body --> 
            <div class="modal-body">

                <!-- Mensagem de erro caso o login não seja bem sucedido -->
                <?php echo $error_message_login; ?>
                
                <!-- Formulário de login -->
                <form action="" method="post" autocomplete="off" role="form"> 
                    <div class="form-group">
                        <label for="username">Nome de utilizador</label>
                        <div class="input-group">
                            <ion-icon name="contact"></ion-icon>
                            <input type="text" name="username" placeholder="Digite aqui o seu nome de utilizador" 
                            class="form-control" id="username" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">Palavra-passe</label>
                        <div class="input-group">
                            <ion-icon name="key"></ion-icon>
                            <input type="password" name="password" placeholder="Digite aqui a sua palavra-passe" 
                            class="form-control" id="password" required>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="modal-footer">
                        <button type="submit" name="login_submit" class="btn btn-primary btn-block">Iniciar sessão!</button>
                    </div>
                </form>
            </div>  
        </div>
    </div>

    <!-- Formulário de registo -->
    <div class="modal-dialog" id="register-modal">
        <div class="modal-content">
            
            <!-- Hedader --> 
            <div class="modal-header">
                <h3>Torna-se já num novo membro</h3>
            </div>

            <!-- Body --> 
            <div class="modal-body">

            <!-- Mensagem de erro caso o registo não seja bem sucedido -->
            <?php echo $message_error_register; ?>

                <!-- Formulário de registo -->
                <form action="" method="post" autocomplete="off" role="form"> 
                    <div class="form-group">
                        <label for="new_user_username">Nome de utilizador</label>
                        <div class="input-group">
                            <ion-icon name="contact"></ion-icon>
                            <input type="text" name="new_user_username" placeholder="Digite aqui o seu nome de utilizador" 
                            class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="new_user_email">Endereço de email</label>
                        <div class="input-group">
                            <ion-icon name="mail"></ion-icon>
                            <input type="email" name="new_user_email" placeholder="Escolha o seu email de preferência" class="form-control input-email" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="new_user_password">Palavra-passe</label>
                        <div class="input-group">
                            <ion-icon name="key"></ion-icon>
                            <input type="password" name="new_user_password" placeholder="Digite aqui a sua palavra-passe" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="new_user_password_rewrite">Confirmação da palavra-passe</label>
                        <div class="input-group">
                            <ion-icon name="key"></ion-icon>
                            <input type="password" name="new_user_password_rewrite" placeholder="Reescreva aqui a sua palavra-passe" class="form-control" required>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="modal-footer">
                        <button type="submit" name="register_submit" class="btn btn-primary btn-block">Registar-se!</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
            
</div>