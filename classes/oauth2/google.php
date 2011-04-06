<?php

include_once Kohana::find_file('vendor', 'OAuth2Client');
include_once Kohana::find_file('vendor', 'OAuth2Exception');

class OAuth2_Google extends OAuth2Client {
	protected $config = array(
		'base_uri' => 'https://www.google.com/m8/feeds',
		'authorize_uri' => 'https://accounts.google.com/o/oauth2/auth',
		'access_token_uri' => 'https://accounts.google.com/o/oauth2/token',
		'client_id' => '744765340221.apps.googleusercontent.com',
		'client_secret' => 'tpRiq5/xeXbD3l3gxpPRi/ko',
		'cookie_support' => TRUE,
//		'services_uri' => 'o',
	);

	public function __construct($config = array())
	{
		$config = $this->config + $config;

		parent::__construct($config);
	}

	public function getAuthorizeUrl($scope, $response_type = 'code')
	{
		return $this->getVariable('authorize_uri').'?client_id='.$this->getVariable('client_id').'&redirect_uri=http://wk01-lmst.managedit.ie/phostr-api/oauth2/return&response_type='.$response_type.'&scope='.$scope;
	}

	/**
	 * Get a Login URL for use with redirects. By default, full page redirect is
	 * assumed. If you are using the generated URL with a window.open() call in
	 * JavaScript, you can pass in display = popup as part of the $params.
	 *
	 * @param $params
	 *   Provide custom parameters.
	 *
	 * @return
	 *   The URL for the login flow.
	 */
	public function getLoginUri($params = array())
	{
		return $this->getUri(
			$this->getVariable('authorize_uri'),
			array_merge(array(
				'response_type' => 'code',
				'client_id' => $this->getVariable('client_id'),
				'redirect_uri' => $this->getCurrentUri(),
				), $params)
		);
	}

	/**
	 * Get a Logout URL suitable for use with redirects.
	 *
	 * @param $params
	 *   Provide custom parameters.
	 *
	 * @return
	 *   The URL for the logout flow.
	 */
	public function getLogoutUri($params = array())
	{
		return $this->getUri(
			$this->getVariable('base_uri').'logout',
			array_merge(array(
				'oauth_token' => $this->getAccessToken(),
				'redirect_uri' => $this->getCurrentUri(),
				), $params)
		);
	}

}