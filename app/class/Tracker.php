<?php

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Tracker
{
    /** @var array */
    protected $config;

    /**
     * Tracker constructor.
     */
    public function __construct()
    {
        $this->config = [
            'base_uri' => 'https://api.maerskline.com/',
            'headers' => [
                'Accept' => 'application/json, text/javascript, */*; q=0.01',
                'Authorization' => 'Atmosphere atmosphere_app_id="rcewucoc-3eohkPuKoLI4TPGr3MJnh77l"'
            ]
        ];
    }

    /**
     * @param string $number
     * @return array
     */
    public function getByNumber(string $number) : array
    {
        /** @var Client $client */
        $client = new Client($this->config);

        try {
            $response = $client->request('GET', "track/$number?operator=maeu");
            $content = $response->getBody()->getContents();

            $container = $this->parsData($content);
        } catch (ClientException $exception) {
            $container['error'] = $exception->getCode();
        }

        return $container;
    }

    /**
     * @param $content
     * @return array
     */
    protected function parsData($content) : array
    {
        $content = json_decode($content);

        $container = [];
        foreach ($content->containers as $containerData) {
            $container['container_type']    = "$containerData->container_size $containerData->container_type";
            $container['final_delivery']    = $this->convertDateTime($containerData->eta_final_delivery);

            foreach ($containerData->locations as $location) {
                foreach ($location->events as $activity) {
                    $event['location']      = "$location->terminal - $location->city";
                    $event['country']       = $location->country;
                    $event['expected_time'] = $this->convertDateTime($activity->expected_time);
                    $event['actual_time']   = $this->convertDateTime($activity->actual_time);
                    $event['activity']      = $activity->activity;
                    $event['is_current']    = $activity->is_current;
                    $event['is_cancelled']  = $activity->is_cancelled;

                    $container['events'][] = $event;
                }
            }
        }

        return $container;
    }

    /**
     * @param string|null $dateTime
     * @return string|null
     */
    protected function convertDateTime(string $dateTime = null) : ?string
    {
        if (is_null($dateTime)) {
           return $dateTime;
        }

        return Carbon::createFromFormat('Y-m-d\TH:m:s.u', $dateTime)->format('d M Y H:m');
    }
}
