<?php if ( ! is_user_logged_in() ) { ?>
	<div class="modal disp-none" id="modal-auth">
		<div class="flipper">

			<div class="loader-box">
				<div class="loader-inner">
					<div></div>
				</div>
			</div>

			<div class="main-box front">
				<h3>Вход / регистрация</h3>

				<div id="modal-auth-popup-body-login">
					<?php echo deco_wsl_custom_soc_login(); ?>
					<p class="separator">или</p>

					<p class="modal-error"></p>

					<div class="login-path-modal">
						<div class="login-left">
							<form action="<?php echo site_url(); ?>/wp-login.php" method="post" role="form" id="modal-reg">
								<?php if ( function_exists( 'ct_register_form' ) ) {
									ct_register_form();
								} ?>
								<input type="hidden" name="redirect_to" value="<?php echo site_url() . '/' . $_SERVER['REQUEST_URI']; ?>">
								<input type="hidden" name="testcookie" value="1">

								<input type="email" id="user-name-log" name="log" placeholder="E-mail" class='required text form-control' aria-required="true" />
								<input type="password" id="user-pass-log" name="pwd" placeholder="Пароль" class='required text form-control' aria-required="true" />
								<br>
								<label for="rememberme"><input name="rememberme" type="checkbox" id="rememberme" value="forever"> Запомнить меня</label>

								<button data-hover="Войти / Зарегистрироваться" type="submit" data-action="contactFormSbmt" class="btn btn-primary contact-button" id="comment_auth_button" role="button">
									<span>Войти / Зарегистрироваться</span>
								</button>
								<a href="#" data-hover="Забыли пароль?" class="remember-pass flip_rotate">
									<span>Забыли пароль?</span>
								</a>
								<br>
							</form>
						</div>
					</div>
				</div>
				<span class="close"><i class="fa fa-close"></i></span>
			</div>
			<div class="main-box back">
				<h3>Восстановление пароля</h3>

				<div id="modal-auth-popup-body-reset-pass">
					<p class="modal-error"></p>

					<div class="login-path-modal">
						<div class="login-left">
							<form action="<?php echo site_url(); ?>/wp-login.php?action=lostpassword" method="post" role="form" id="deco-form-reset-pass">
								<?php if ( function_exists( 'ct_register_form' ) ) {
									ct_register_form();
								} ?>
								<input type="hidden" name="redirect_to" value="<?php echo site_url() . '/' . $_SERVER['REQUEST_URI']; ?>">
								<input type="hidden" name="testcookie" value="1">

								<input type="email" id="reset_user_login" name="log" placeholder="E-mail" class='required text form-control' aria-required="true" />

								<button data-hover="Войти / Зарегистрироваться" type="submit" data-action="contactFormSbmt" class="btn btn-primary contact-button" id="comment_reset_button" role="button">
									<span>Сбросить пароль</span>
								</button>
								<p>Пожалуйста, введите ваш e-mail. Вы получите письмо со ссылкой для создания нового пароля.</p>

								<a href="#" class="remember-pass flip_rotate">
									<span>Назад</span>
								</a>
								<br>
							</form>

							<p id="deco-auth-modal-reset-message" style="display:none;"></p>

						</div>
					</div>
				</div>
				<span class="close"><i class="fa fa-close"></i></span>
			</div>
		</div>
	</div>
<?php } ?>