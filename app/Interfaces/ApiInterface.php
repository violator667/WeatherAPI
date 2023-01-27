<?php


namespace App\Interfaces;

interface ApiInterface {
    public function buildRequestUrl(array $data);
    public function callApi(array $searching);
    public function success();
    public function mapDesiredData(string $body);


}
