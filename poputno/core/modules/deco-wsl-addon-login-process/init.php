<?php
define( 'DECO_WSL_ADDON_LOGIN_PROCESS_VER', '0.3' );
define( 'DECO_WSL_ADDON_LOGIN_PROCESS_PATH', dirname( __FILE__ ) . '/' );
define( 'DECO_WSL_ADDON_LOGIN_PROCESS_URL', str_replace( ABSPATH, site_url() . '/', dirname( __FILE__ ) ) . '/' );

require_once DECO_WSL_ADDON_LOGIN_PROCESS_PATH . 'deco-wsl-addon-login-process.php';