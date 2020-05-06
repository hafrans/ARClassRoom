<?php


namespace App\Api;


use Exception;

class EasyARClient
{


    const ERROR_OK = 0;
    const ERROR_API_SECRET = 1;
    const ERROR_BAD_SIGNATURE = 2;
    const ERROR_BAD_DATETIME = 3;


    const ERROR_NOT_FOUND = 404;
    const ERRPR_SIMILAR_FOUND = 419;

    private $clientSdk;


    public function __construct(EasyARClientSdkCRS $clientSdk)
    {
        $this->clientSdk = $clientSdk;
    }

    /**
     * @param $image
     * @param $name
     * @param string $meta
     * @param string $active
     * @param string $size
     * @return mixed
     * @throws Exception
     */
    public function createObject($image, $name, $meta = "None", $active = "1", $size = "20"){

        /**
         * returns
         *
         * {#343 ▼
        +"targetId": "cd9580ff-2ff6-449b-a8e6-120f516c31b8"
        +"detectableDistinctiveness": 0
        +"apiKey": "5ba58778ec2cb9c7ab74bfe0f8cbc5dd"
        +"detectableFeatureCount": 3
        +"type": "ImageTarget"
        +"trackableDistinctiveness": 0
        +"detectableFeatureDistribution": 1
        +"trackableFeatureCount": 3
        +"detectableRate": 1
        +"trackableFeatureDistribution": 2
        +"size": "20"
        +"trackablePatchContrast": 0
        +"meta": "None"
        +"appId": "7ca300cedb49c43b8b42952ed05255c3"
        +"trackablePatchAmbiguity": 0
        +"name": "helloworld"
        +"appKey": "7ca300cedb49c43b8b42952ed05255c3"
        +"trackableRate": 1
        +"active": "1"
        +"date": "1588766680587"
        +"trackingImage": """/9j/EAwMEBQgFBQQEBQoHBwYIDAoMDAsK
        """
        +"modified": 1588766680587
        }
         *
         */

        $reqBody = compact("image","name","meta","active", "size");
        return $this->getBody($this->clientSdk->targetAdd($reqBody));
    }

    public function checkStatus($targetId){

        try {
            return $this->getInfo($targetId);;
        } catch (Exception $e) {
            return $e->getCode();
        }
    }

    /**
     * @param $targetId
     * @return mixed
     * @throws Exception
     */
    public function getInfo($targetId){
        return $this->getBody($this->clientSdk->info($targetId));
    }


    /**
     * @param \stdClass $response
     * @return mixed
     * @throws Exception
     */
    private function getBody(\stdClass $response){

        if ($response->statusCode != 0) {
            dump($response);
            die();
            throw new Exception("StatusCode ".$response->statusCode, $response->statusCode);
        }
        return $response->result;
    }

}
