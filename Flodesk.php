<?php

class Flodesk {

    protected $baseUrl;
    protected $apikey;
    protected $data = [];
    protected $method = "POST";
    protected $userAgent = "";

    public function __construct($apikey) {
        $this->apikey = $apikey;
        $this->baseUrl = "https://api.flodesk.com/v1";
        $this->userAgent = "ThrivingSmart (www.thrivingsmart.com)";
    }

    public function create($email, $fname = '', $lname = '') {
        $endpoint = $this->baseUrl . "/subscribers";
        $this->data = [
            'email' => $email,
            'first_name' => $fname,
            'last_name' => $lname
        ];
        return $this->post($endpoint);
    }

    public function subscribe($segmentId, $email) {
        $endpoint = $this->baseUrl . "/subscribers/$email/segments";
        $this->data = ["segment_ids" => [$segmentId, ],];
        return $this->post($endpoint);
    }

    public function unsubscribe($segmentId, $email) {
        $endpoint = $this->baseUrl . "/subscribers/{$email}/segments";
        $this->data = ["segment_ids" => [$segmentId, ],];
        return $this->delete($endpoint);
    }

    public function list() {
        $endpoint = $this->baseUrl . "/subscribers";
        $this->data = [];
        return $this->get($endpoint);
    }

    protected function send($endpoint) {
        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            "User-Agent: " . $this->userAgent,
            "Authorization: Basic " . base64_encode($this->apikey),
        ]);

        if (! empty($this->data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->data));
        }

        $response = curl_exec($ch);

        if (!$response) {
            $error = curl_errno($ch);
            curl_close($ch);
            // in a live project, you should throw exception and handle the exceptions in your code
            var_dump($error);
            die();
        }

        curl_close($ch);

        return $response;

    }

    protected function post($url) {
        $this->method = "POST";
        $reponse = $this->send($url);
        $this->data = [];
        return $reponse;
    }

    protected function get($url) {
        $this->method = "GET";
        $reponse = $this->send($url);
        $this->data = [];
        return $reponse;
    }

    protected function delete($url) {
        $this->method = "DELETE";
        $reponse = $this->send($url);
        $this->data = [];
        return $reponse;
    }
    
}
    
    
    
