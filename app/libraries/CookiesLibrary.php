<?php
/**
 * CookiesLibrary is responsible for store and fetch the user's search history from cookies
 *
 */
class CookiesLibrary
{

    /**
     * @var \Phalcon\Http\Response\Cookies $cookies
     *          An instance of \Phalcon\Http\Response\Cookies
     */
    private $cookies;

    /**
     * Sets the cookies
     *
     * @param \Phalcon\Http\Response\Cookies $cookie
     *          OO wrappers a HTTP cookie
     */
    public function setCookie(Phalcon\Http\Response\Cookies $cookie)
    {
        $this->cookies = $cookie;
    }

    /**
     * Store user's search history
     *
     * @param string $cityName  Location given by the user.
     */
    public function save($cityName)
    {
        $cookieKey = 'cityName';
        $cookieValue = $this->get();
        if (($key = array_search($cityName, $cookieValue)) !== false) {
            unset($cookieValue[$key]);
        }
        array_unshift($cookieValue, $cityName);
        $this->cookies->set($cookieKey, serialize($cookieValue), time() + 15 * 86400);
    }

    /**
     * Fetch the user's search history
     *
     * @param array List of location
     */
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
