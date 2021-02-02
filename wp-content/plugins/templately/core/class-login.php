<?php

namespace Templately;

class Login {

	/**
	 * Save global sign in flag based on user choice.
	 *
	 * @param $choice
	 *
	 * @return bool true|false
	 */
	public static function set_user_login_choice( $user, $choice ) {
		return update_option( '_templately_user_login_choice', array (
			'id'      => $user,
			'choice' => $choice
		) );
	}

	public static function get_user_login_choice() {
		return get_option( '_templately_user_login_choice', array () );
	}

	public static function user_can_logout( $user = null ) {
		$userdata = self::get_user_login_choice();
		if( ! empty( $userdata ) ) {
			if( isset( $userdata['choice'] ) ) {
				return isset( $userdata['id'] ) ? $userdata['id'] === get_current_user_id() : false;
			}
		}
		return false;
	}

	public static function already_signedin_globally() {
		$userdata = self::get_user_login_choice();
		if( isset( $userdata['choice'] ) ) {
			return $userdata['choice'];
		}else {
			return false;
		}
	}

	public static function set_link_my_account() {
		return update_user_meta( get_current_user_id(), '_templately_link_my_account', true );
	}

	public static function get_link_my_account() {
		return get_user_meta( get_current_user_id(), '_templately_link_my_account', true );
	}

	public static function delete_link_my_account() {
		return delete_user_meta( get_current_user_id(), '_templately_link_my_account' );
	}

}