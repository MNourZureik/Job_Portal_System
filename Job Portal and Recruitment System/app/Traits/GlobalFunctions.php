<?php

namespace App\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Schema;
trait GlobalFunctions
{
    public static function selectAllExcept($model ,$excludedColumns = []): array
    {
        $columns = Schema::getColumnListing($model->getTable());

        return array_diff($columns, $excludedColumns);
    }

    private function geocodeAddress($address)
    {
        if (empty($address)) {
            dd('address cannot be empty');
        }

        $client = new Client();
        $apiKey = env('GEOCODING_API_KEY');

        $queryParams = [
            'address' => $address,
            'key' => $apiKey,
        ];

        try {
            $response = $client->get('https://maps.googleapis.com/maps/api/geocode/json', [
                'query' => $queryParams,
            ]);

            $data = json_decode($response->getBody(), true);

            if ($data['status'] == 'OK') {
                $location = $data['results'][0]['geometry']['location'];
                return ['lat' => $location['lat'], 'lng' => $location['lng']];
            }

            dd($data);
        } catch (\Exception $e) {
            dd($e->getMessage());
        } catch (GuzzleException $e) {
            dd($e->getMessage());
        }
    }

}
