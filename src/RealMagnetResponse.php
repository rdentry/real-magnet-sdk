<?php

namespace RealMagnet;

class RealMagnetResponse
{
    protected $status = 'success';

    protected $message;

    protected $error;

    protected $data;

    /**
     * Create a new collection.
     *
     * @param mixed $items
     */
    public function __construct($status, $data, $message = null, $error = null)
    {
        $this->status = $status;
        $this->data = $data;
        $this->error = $error;
        $this->message = $message;
    }

    public static function respond($status, $data, $message = null, $error = null)
    {
        return new static($status, $data, $message, $error);
    }

    public static function success($data, $message = null)
    {
        return self::respond('success', $data, $message);
    }

    public static function error($data, $message = null, $error = 1)
    {
        return self::respond('error', $data, $message, $error);
    }

    public function __get($var)
    {
        if (isset($this->$var)) {
            return $this->$var;
        }

        if (property_exists($this->data, $var)) {
            return $this->data->$var;
        }

        if (is_callable([$this->data, $var])) {
            return $this->data->$var();
        }
    }

    /**
     * Convert the response to string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }

    public function isSuccessful()
    {
        return !$this->error;
    }

    /**
     * Get the collection of items as JSON.
     *
     * @param int $options
     *
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->data, $options);
    }
}
/* End of file Response.php */
/* Location: ./system/expressionengine/third_party/motive/libraries/Response.php */
