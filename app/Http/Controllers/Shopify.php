<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Shopify extends Controller
{
	/*
	 * @param string $key API Key
	 * @param string $password API Passowrd
	 * @param string $url Store Url
	 */
	function __construct(string $key, string $password, string $url) {
		$this->api = "https://$key:$password@$url";
	}

	/*
	 * Pauses API requests for 5 seconds if we are gettig close to the limit
	 *
	 * @param string $header Curl header
	 */
	private function process_header($header) {
		$header_split = preg_split ('/$\R?^/m', $header);

		foreach ($header_split as $k => $v) {
			$temp = explode(': ', $v);

			if ($temp[0] == 'X-Shopify-Shop-Api-Call-Limit') {
				$api_call = explode('/', $temp[1]);

				if(((int) $api_call[1] - (int) $api_call[0]) < 5) {
					// time_nanosleep(0, 500000000);
					time_nanosleep(0, 200000000);
				}
			}
		}
	}

	/*
	 * @param string $endpoint Api endpoint with leading slash
	 * @param array $data Parameters to send to Shopify endpoint
	 *
	 * @return Data from Shopify endpoint as PHP array
	 */
	public function get($endpoint, $data=[]): array {
		$parameters = "";

		foreach($data as $k => $v) {
			$parameters .= $k . '=' . $v . '&';
		}

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->api . $endpoint . '?' . $parameters);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_VERBOSE, false);
		curl_setopt($ch, CURLOPT_HEADER, true);

		$response = curl_exec($ch);

		if (curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200) {
			return [];
		}

		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($response, 0, $header_size);
		$body = substr($response, $header_size);

		$this->process_header($header);

		$errors = json_decode($body, true);

		if (isset($errors['errors'])) {
			return $errors;
		}

		return json_decode($body, true);
	}

	/*
	 * @param $endpoint Api endpoint with leading slash
	 * @param $data Parameters to send to Shopify endpoint
	 *
	 * @return Data from Shopify endpoint as PHP array
	 */
	public function put(string $endpoint, array $data=[]): array {
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $this->api . $endpoint);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_VERBOSE, false);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

		$response = curl_exec($ch);

		if (curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200) {
			return [];
		}

		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($response, 0, $header_size);
		$body = substr($response, $header_size);

		$this->process_header($header);

		$errors = json_decode($body, true);

		if (isset($errors['errors'])) {
			return $errors;
		}

		return json_decode($body, true);
	}
}
