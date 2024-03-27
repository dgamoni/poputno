<?php
	/*
	* Template Name: Профиль
	*/


	if ( ! is_user_logged_in() ) {
		wp_redirect( '/' );
	}


	global $current_user;
	get_currentuserinfo();

	$author_id = get_the_author_meta( 'ID', $current_user->id );

	$edit_profile = false;

	if ( $_SERVER['REQUEST_METHOD'] == 'POST' && $_REQUEST['action_profile'] == 'edit' ) {
		$edit_profile = true;
	}

	if ( $_SERVER['REQUEST_METHOD'] == 'POST' && $_REQUEST['action_profile'] == 'save' ) {

		// убираем магические кавычки
		function stripslashes_array( $array ) {

			return is_array( $array ) ? array_map( 'stripslashes_array', $array ) : stripslashes( $array );
		}

		if ( get_magic_quotes_gpc() ) {
			$_POST = stripslashes_array( $_POST );
		}

		require_once( ABSPATH . '/wp-admin/includes/user.php' );
		require_once( ABSPATH . '/wp-includes/registration.php' );

		$error = '';


		global $demo;

		if ( ! $demo ) {
			if ( isset( $_POST['display_name'] ) ) {
				wp_update_user( array( 'ID' => $current_user->ID, 'display_name' => $_POST['display_name'] ) );
			}
		}

		if ( empty( $_POST['user_email'] ) ) {
			$error .= '<div style="color: red;">' . __( '<strong>ОШИБКА</strong>: Пожалуйста, введите адрес e-mail.' ) . '</div>';
		} elseif ( ! is_email( $_POST['user_email'] ) ) {
			$error .= '<div style="color: red;">' . __( '<strong>ОШИБКА></strong>: Адрес e-mail введён неправильно.' ) . '</div>';
		} else {
			if ( ! $demo ) {
				wp_update_user( array( 'ID' => $current_user->ID, 'user_email' => $_POST['user_email'] ) );
			}
		}

		if ( ! $demo ) {
			if ( isset( $_POST['url'] ) ) {
				wp_update_user( array( 'ID' => $current_user->ID, 'user_url' => $_POST['url'] ) );
			}
		}

		if ( ! $demo ) {
			if ( isset( $_POST['profile-twitter'] ) ) {
				wp_update_user( array( 'ID' => $current_user->ID, 'jabber' => $_POST['profile-twitter'] ) );
			}
		}

		if ( ! $demo ) {
			if ( isset( $_POST['profile-fb'] ) ) {
				wp_update_user( array( 'ID' => $current_user->ID, 'aim' => $_POST['profile-fb'] ) );
			}
		}

		if ( ! $demo ) {
			if ( isset( $_POST['description'] ) ) {
				wp_update_user( array(
					                'ID'          => $current_user->ID,
					                'description' => strip_tags( $_POST['description'] )
				                ) );
			}
		}

		if ( empty( $_POST['pass1'] ) && ! empty( $_POST['pass2'] ) or ! empty( $_POST['pass1'] ) && empty( $_POST['pass2'] ) or ! empty( $_POST['pass1'] ) && ! empty( $_POST['pass2'] ) ) {
			if ( $_POST['pass1'] != $_POST['pass2'] ) {
				$error .= '<div style="color: red;"><strong>ОШИБКА</strong>: Пожалуйста, введите одинаковые пароли в обоих полях.</div>';
			} else {
				if ( ! $demo ) {
					wp_update_user( array( 'ID' => $current_user->ID, 'user_pass' => esc_attr( $_POST['pass1'] ) ) );
				}
			}
		}

		if ( ! $error ) {
			wp_redirect( '/profile' );
		}
	}


?>

<?php get_header(); ?>

<section class="main" id="main">

	<div class="wrap cf">

		<?php if (have_posts()) : while (have_posts()) :
			the_post(); ?>

		<div class="calendar-content profile">

			<div class="user-block cf">
				<div class="user">
					<?php /*
					<a href="<?php the_permalink(); ?>" class="img-cont">
						<?php //echo get_avatar($current_user->ID, 50, '', $current_user->display_name); ?>
					</a>
*/
					?>
					<div class="username">
						<a href="<?php the_permalink(); ?>">
							<?php echo esc_attr( $current_user->display_name ); ?>
						</a>
                            <span class="user_time_full">Дата регистрации: <time>
		                            <?php
			                            echo date( 'd', strtotime( $current_user->user_registered ) ) . ' ';
			                            echo month_full_name_ru( date( 'n', strtotime( $current_user->user_registered ) ) ) . ' ';
			                            echo date( 'Y', strtotime( $current_user->user_registered ) ) . ' в ';
			                            echo date( 'h:m', strtotime( $current_user->user_registered ) );
		                            ?>
	                            </time>
                            </span>
							<span class="user_time_short">Регистрация: <time>
									<?php
										echo date( 'd', strtotime( $current_user->user_registered ) ) . '.';
										echo date( 'm', strtotime( $current_user->user_registered ) ) . '.';
										echo date( 'Y', strtotime( $current_user->user_registered ) ) . ' в ';
										echo date( 'h:m', strtotime( $current_user->user_registered ) );
									?>
								</time>
							</span>
					</div>
				</div>

				<a href="<?php echo wp_logout_url( '/' ); ?>" class="red-btn" style="margin-left: 40px;">Выход</a>
				<a href="/cabinet" class="red-btn">Кабинет</a>


			</div>
			<div id="profile-content">
				<?php echo $error; ?>
				<?php
					//if ($edit_profile) {
					wp_enqueue_script( "thickbox" );
					wp_enqueue_style( "thickbox" );
					//}
				?>
				<form action="<?php the_permalink(); ?>" method="post"
				      class="profile-form cf <?php //if (!$edit_profile) echo 'dis'; ?>"
				      enctype="multipart/form-data">
					<?php //if (!$edit_profile) { ?>
					<input type="hidden" name="action_profile" value="edit">
					<?php //} ?>
					<div class="l">
						<label for="name">Отображаемое имя</label>
						<input autocomplete="off" type="text" name="display_name" id="name" class="name"
						       value="<?php echo esc_attr( $current_user->display_name ); ?>"
							<?php //if (!$edit_profile) echo 'disabled'; ?>>
						<label for="login">Логин</label>
						<input autocomplete="off" type="text" id="login" class="login" style="border:0;"
						       value="<?php echo esc_attr( $current_user->user_login ); ?>" disabled>
						<label for="email">Email</label>
						<input autocomplete="off" type="email" id="email" name="user_email" class="email"
						       value="<?php echo esc_attr( $current_user->user_email ); ?>" <?php //if (!$edit_profile) echo 'disabled'; ?>>
						<label for="site">Сайт</label>
						<input autocomplete="off" type="text" id="site" name="url" class="site"
						       value="<?php echo esc_attr( $current_user->user_url ); ?>" <?php //if (!$edit_profile) echo 'disabled'; ?>>

						<label for="fb">Facebook</label>
						<?php //if ($edit_profile) { ?>
						http://facebook.com/
						<input autocomplete="off" style="width:238px;" type="text" id="fb" name="profile-fb" class="fb"
						       value="<?php echo esc_attr( $current_user->aim ) ?>">
						<?php /*} elseif ($current_user->aim) { ?>
                            <a href="http://facebook.com/<?php echo $current_user->aim; ?>">http://facebook.com/<?php echo $current_user->aim; ?></a>
                            <p>&nbsp;</p>
                        <?php } else { ?>
                            <input style="width:238px;" type="text" id="fb" name="profile-fb" class="fb">
                        <?php } */
						?>

						<label for="tw">Твиттер </label>
						<?php //if ($edit_profile) { ?>
						http://twitter.com/
						<input autocomplete="off" style="width:256px;" type="text" id="tw" name="profile-twitter" class="tw"
						       value="<?php echo esc_attr( $current_user->jabber ) ?>">
						<?php /*} elseif ($current_user->jabber) { ?>
                            <a href="http://facebook.com/<?php echo $current_user->jabber; ?>">http://twitter.com/<?php echo $current_user->jabber; ?></a>
                        <?php } else { ?>
                            <input type="text" id="tw" name="profile-twitter" value="" class="tw">
                        <?php } */
						?>


						<?php //if ($edit_profile) { ?>
						<input type="hidden" name="action_profile" value="save">

						<div class="pass">
							<label class="ib" for="new-pass">Новый пароль</label>
							<input type="password" name="pass1" value="" id="new-pass" class="new-pass">
						</div>
						<div class="pass">
							<label class="ib" for="new-pass2">Повторите пароль</label>
							<input type="password" name="pass2" value="" id="new-pass2" class="new-pass">
						</div>
						<p>Подсказка: Пароль должен состоять как минимум из семи символов. Чтобы сделать его
							надёжнее, используйте буквы верхнего и нижнего регистра, числа и символы наподобие ! " ?
							$ % ^ & ).</p>
						<?php //} ?>
						<br><br>
						<?php /*if (!$edit_profile) { ?>
                            <p>
                                <button type="submit" class="red-btn">Изменить</button>
                            </p>
                        <?php } */
						?>
					</div>
					<div class="r">
						<label for="textarea">О себе</label>
						<textarea name="description" id="textarea"
							<?php //if (!$edit_profile) echo 'disabled'; ?>><?php echo esc_html( $current_user->description ); ?></textarea>
						<?php /*
                        <label for="">Фото</label>

                        <div class="ava">
                            <?php echo get_avatar($current_user->ID, 148, '', $current_user->display_name); ?>
                        </div>
                        //if ($edit_profile) { ?>
                        <a id="user-avatar-link" class="grey-btn thickbox"
                           href="<?php echo admin_url('admin-ajax.php'); ?>?action=user_avatar_add_photo&step=1&uid=<?php echo $current_user->ID; ?>&TB_iframe=true&width=720&height=450">
                            Изменить фото</a>
                        <?php //} */
						?>
					</div>
					<br style="clear: both;" />

					<p>
						<button type="submit" class="red-btn">Сохранить</button>
					</p>
				</form>
			</div>
			<?php /* if ($edit_profile) { ?>
            <script type="text/javascript">
                function user_avatar_refresh_image(img) {
                    jQuery('.ava').html(img);
                }
                function add_remove_avatar_link() {
                    if (!jQuery("#user-avatar-remove").is('a')) {
                        jQuery('#user-avatar-link').after(" <a href='<?php echo $remove_url; ?>' class='submitdelete'  id='user-avatar-remove' ><?php _e('Remove','user-avatar'); ?></a>")
                    }
                }
            </script>
            <script type='text/javascript'>
                 <![CDATA[
                var pwsL10n = {
                    empty: "<?php echo esc_js( __( 'Strength indicator' ) ); ?>",
                    short: "<?php echo esc_js( __( 'Very weak' ) ); ?>",
                    bad: "<?php echo esc_js( __( 'Weak' ) ); ?>",
                    good: "<?php echo esc_js( _x( 'Medium', 'password strength' ) ); ?>",
                    strong: "<?php echo esc_js( __( 'Strong' ) ); ?>",
                    mismatch: "<?php echo esc_js( __( 'Mismatch' ) ); ?>"
                };
                try {
                    convertEntities(pwsL10n);
                } catch (e) {
                }
                ;
                 ]]>
            </script>
            <script type="text/javascript"
                    src="<?php echo get_bloginfo('wpurl'); ?>/wp-admin/load-scripts.php?c=1&amp;load=user-profile,password-strength-meter"></script>
            <?php }  */
			?>


			<?php endwhile;
				endif;
			?>
		</div>
		<?php get_sidebar(); ?>
	</div>

</section>
<?php get_footer(); ?>
