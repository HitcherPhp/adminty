<?php


namespace App\Basket\Services;


use App\Basket\Interfaces\BasketAdapterInterface;
use App\Basket\Rules\BasketCheckProducts;
use App\Facades\Message;
use Illuminate\Support\Facades\Validator;
use mysql_xdevapi\Exception;

class BasketAdapterService
{

    private const NOT_FOUND = Message::NOT_FOUND;
    private const SERVER_ERROR = Message::SERVER_ERROR;
    private const SUCCESS = Message::SUCCESS;
    private const VALIDATION_ERROR = Message::VALIDATION_ERROR;
    private const LOG = 'basket_fail';



    protected $validator;
    protected $validation_errors = [];
    protected $products = [];
    protected $message = [];
    protected $basket;
    private $validation_rules = [];
    private $validation_messages = [];


    /**
     * @param array $products
     */
    public function setProducts($products): void
    {
        $this->products = $products;
    }

    /**
     * @return array
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * @return array
     */
    public function getProductIds(): array
    {
        return array_column($this->products, 'id');
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }


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

    /**
     * @param array|string
     */
    public function setMessageValidationError() {

        $this->setMessage(self::VALIDATION_ERROR);

    }

    /**
     * @param array $input
     */
    public function setValidation(&$input): void
    {
        $this->validation_rules = ['products' => ['required', new BasketCheckProducts($input)] ];
        $this->validation_messages = ['products.required' => 'fill_able'];
    }
    /**
     * @return string[]
     */
    private function getValidationRules(): array
    {
        return $this->validation_rules;
    }

    /**
     * @return string[]
     */
    private function getValidationMessages(): array
    {
        return $this->validation_messages;
    }

    /**
     * @param array $validation_errors
     */
    public function setValidationErrors($validation_errors): void
    {
        $this->validation_errors = $validation_errors;
    }



    public function validate($input)
    {

        $this->setValidation($input);

        $this->setValidator($input);
        if ($this->getValidator()->fails()) {

            $this->setMessageValidationError();
            $this->setValidationErrors($this->getValidator()->errors());
        }
        else {

            $this->setProducts($input['products']);
            $this->setMessageSuccess();
        }

        return $this->getValidator();
    }

    /**
     * @param mixed $validator
     */
    private function setValidator(&$input): void
    {
        $this->validator = Validator::make($input, $this->getValidationRules(), $this->getValidationMessages());
    }

    /**
     * @return mixed
     */
    private function getValidator()
    {
        return $this->validator;
    }


    /**
     * @return array
     */
    public function getBasketProducts()
    {
        if (isset($this->basket['products'])) {
            return $this->basket['products'];
        }
        return [];
    }


    /**
     * @return string
     */
    public function getBasketPrice()
    {
        if (isset($this->basket['full_price'])) {
            return $this->basket['full_price'];
        }
        return '';
    }

    /**
     * @param array $basket
     */
    public function setBasket(array $basket): void
    {
        $this->basket = $basket;
    }

    /**
     * @param array $basket
     */
    public function calculateBasket(array &$products): void
    {
        if(empty($products)) {
            $this->setMessageNotFound();
        }

        $product_ids_counts = $this->getProducts();

        $merge = array_merge($products, $product_ids_counts);

        $collection = collect($merge);

        $collection = $collection->mapToGroups(function ($item, $key) {
            return [$item['id'] => $item];
        });


        $products = $collection->all();
        $full_price = '0';

        foreach ($products as $value) {

            $product = collect();

            foreach ($value as $params) {
                $product = $product->union($params);

            }

            if (($product->get('new_price')) === 0) {
                $price = bcmul((string)$product->get('new_price'), (string)$product->get('count'), 2);
            }

            $price = bcmul((string)$product->get('price'), (string)$product->get('count'), 2);

            $full_price = bcadd($full_price, $price, 2);

            $product = $product->merge(['full_price' => $price]);
            $product = $product->all();
            $basket['products'][] = $product;
        }

        $basket['full_price'] = $full_price;

        $this->setBasket($basket);

    }

    /**
     * @return array
     */
    public function getValidationErrors()
    {
        return $this->validation_errors;
    }

    public function response() {

        return [
            'validation_error' => $this->getValidationErrors(),
            'message' => $this->getMessage(),
            'products' => $this->getBasketProducts(),
            'full_price' => $this->getBasketPrice(),
        ];

    }

}
