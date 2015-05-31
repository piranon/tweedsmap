<?php

class CookiesLibrary
{
    private $cookie;

    public function setCookie(Phalcon\Http\Response\Cookies $cookie)
    {
        $this->cookies = $cookie;
    }

    public function save($cityName)
    {
        $cookieKey = 'cityName';
        $cookieValue = $this->get();
        if(($key = array_search($cityName, $cookieValue)) !== false) {
            unset($cookieValue[$key]);
        }
        array_unshift($cookieValue, $cityName);
        $this->cookies->set($cookieKey, serialize($cookieValue), time() + 15 * 86400);
    }

    public function get()
    {
        $cookieKey = 'cityName';
        $cookieValue = array();
        if ($this->cookies->has($cookieKey)) {
            $cityNameCookie = $this->cookies->get($cookieKey);
            $value = $cityNameCookie->getValue();
            $cookieValue = unserialize($value);
        }
        return $cookieValue;
    }
}
