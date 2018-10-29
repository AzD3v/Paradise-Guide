<div class="modal-wrapper">

    <!-- Modal de login -->
    <div class="modal-dialog">
        <div class="modal-content" id="login-modal">
            
            <!-- Hedader of the modal --> 
            <div class="modal-header">
                <h3>Prossiga para a sua conta pessoal</h3>
            </div>

            <!-- Body of the modal --> 
            <div class="modal-body">
                <?php echo $message; ?>
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
                    <!-- Footer of the modal -->
                    <div class="modal-footer">
                        <button type="submit" name="login_submit" class="btn btn-primary btn-block">Iniciar sessão!</button>
                    </div>
                </form>
            </div>  
        </div>
    </div>

    <!-- Modal de registo -->
    <div class="modal-dialog" id="register-modal">
        <div class="modal-content">
            
            <!-- Hedader of the modal --> 
            <div class="modal-header">
                <h3>Torna-se já num novo membro</h3>
            </div>

            <!-- Body of the modal --> 
            <div class="modal-body">
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
                            <input type="password" name="new_user_email" placeholder="Escolha o seu email de preferência" class="form-control input-email" required>
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
                    <!-- Footer of the modal -->
                    <div class="modal-footer">
                        <button type="submit" name="register_submit" class="btn btn-primary btn-block">Registar-se!</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
            
</div>