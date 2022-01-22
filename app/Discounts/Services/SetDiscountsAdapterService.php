<?php


namespace App\Discounts\Services;


use App\Discounts\Interfaces\SetDiscountsAdapter;
use App\Facades\Message;
use App\Models\CityModel;
use Illuminate\Support\Facades\Log;

class SetDiscountsAdapterService extends SetDiscountsAdapter
{

    private const NOT_FOUND = Message::NOT_FOUND;
    private const SERVER_ERROR = Message::SERVER_ERROR;
    private const SUCCESS = Message::SUCCESS;
    private const LOG = 'set_discounts_fail';

    public function __construct()
    {
        $this->city_ids = [1,2,3,4,5,6,7,8,9,10,11,12];
        $this->message = [];
        $this->error = [];

        //$this->setAdapter();
    }

    /**
     * @param array $city_ids
     */
    public function setCityIds(array $city_ids): void
    {
        $this->city_ids = $city_ids;
    }

    /**
     * @return array
     */
    public function getCityIds(): array
    {
        return $this->city_ids;
    }


    /**
     * @return string
     */
    public function getSetCityIds(): string
    {
        $set = implode(',', $this->getCityIds());


        return $set;
    }

    /**
     * @param array|string $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }

    /**
     * @return array
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param $error
     */
    public function setError($error): void
    {
        $this->error = $error;
    }

    /**
     * @return array
     */
    public function getError()
    {
        return $this->error;
    }


    /**
     * @param array|string
     */
    public function setMessageNotFound() {

        $this->setMessage(self::NOT_FOUND);

    }

    /**
     * @param array|string
     */
    public function setMessageServerError() {

        $this->setMessage(self::SERVER_ERROR);

    }


    /**
     * @param array|string
     */
    public function setMessageSuccess() {

        $this->setMessage(self::SUCCESS);

    }


    public function hasError() {

        $e = $this->getError();
        $m = $this->getMessage();

        if (!empty($e) || $m === self::SERVER_ERROR) {
            return true;
        }
        return false;
    }

    public function hasNotFound() {

        if ($this->getMessage() === self::NOT_FOUND) {
            return true;
        }
        return false;
    }


    public function writeLog($e) {

        $this->setMessageServerError();
        $this->setError($e);
        $e = $this->getError();

        $e = json_encode([
            'city_ids' => $this->getCityIds(),
            //'sql' => $e->getSql(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'message' => $e->getMessage(),
            'code' => $e->getCode()
        ]);

        Log::channel(self::LOG)->error($e);

    }


    private function setAdapter()
    {
        try {

            $cities = CityModel::from('cities as c')
                ->select('c.id as id')
                ->join('timezones as t', 't.id', '=', 'c.timezone_id')
                ->whereRaw("HOUR(CONVERT_TZ(NOW(), '+00:00', t.utc)) >= 3 and HOUR(CONVERT_TZ(NOW(), '+00:00', t.utc)) <= 4")
                ->get()->toArray();

            if(empty($cities)) {

                $this->setMessageNotFound();
            }
            else {
                $city_ids = array_column($cities, 'id');

                $this->setCityIds($city_ids);
                $this->setMessageSuccess();
            }
        }
        catch (\Exception $e) {

            $this->writeLog($e);

        }

    }

}
