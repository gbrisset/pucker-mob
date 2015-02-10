
<?php
/**
   * List
   * 
   * This Class manage the google analytics api functions
   * 
   * @author     Flor Guzman <fguzman@sequelmediagroup.com.com>
   */

require_once dirname(__FILE__).'/Connector.php';

require_once ('../vendor/autoload.php');

class GoogleAnalyticsApi{

	protected $config;
	protected $con;
	protected $serviceClientId;
	protected $serviceAccountName;
	protected $scopes;
	protected $p12FilePath;
	protected $client;


	public function __construct($c){
		$this->config = $c;
		$this->con = new Connector($this->config);
		$this->serviceClientId = '381980412538-c1qc3h4dh2chs14fu639pkfptppkvjd1.apps.googleusercontent.com';
		$this->serviceAccountName = '381980412538-c1qc3h4dh2chs14fu639pkfptppkvjd1@developer.gserviceaccount.com';
		$this->scopes = array('https://www.googleapis.com/auth/analytics.readonly');
		$this->p12FilePath = '../vendor/puckermob-c7106c003a34.p12';
	}

	public function getViewId(){
		return $this->viewId;
	}

	public function connect_to_client(){
		$this->$client = new Google_Client();

		$this->client->setClientId($this->serviceClientId);
		$this->client->setApplicationName("puckermob");
		$this->client->setAccessType('offline');

		if (isset($_SESSION['service_token'])) {
		  $this->client->setAccessToken($_SESSION['service_token']);
		}

		$key = file_get_contents($this->p12FilePath);

		$googleAssertionCredentials = new Google_Auth_AssertionCredentials( $this->serviceAccountName,  $this->scopes, $key );

		$client->setAssertionCredentials($this->googleAssertionCredentials);

	}

}


?>