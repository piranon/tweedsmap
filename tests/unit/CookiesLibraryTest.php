<?php

class CookiesLibraryTest extends BaseUnitTest
{
    private $cookiesLibrary;
    private $responseCookie;
    private $httpCookie;

    protected function setUp()
    {
        parent::setUp();
        $this->cookiesLibrary = new CookiesLibrary();
        $this->responseCookie = $this->getMockBuilder('Phalcon\Http\Response\Cookies')->disableOriginalConstructor()->getMock();
        $this->httpCookie = $this->getMockBuilder('Phalcon\Http\Cookie')->disableOriginalConstructor()->getMock();
        $this->cookiesLibrary->setCookie($this->responseCookie);
    }

    protected function tearDown()
    {
    }

    public function testSaveHistorySearchCityCookie()
    {
        $expected = array(
            'รังสิต', 'นนทบุรี', 'บางเขน'
        );
        $cityName = 'นนทบุรี';
        $cookieValueGet = 'a:3:{i:0;s:18:"รังสิต";i:1;s:21:"นนทบุรี";i:2;s:18:"บางเขน";}';
        $cookieValueSet = 'a:3:{i:0;s:21:"นนทบุรี";i:1;s:18:"รังสิต";i:2;s:18:"บางเขน";}';
        $this->responseCookie->expects($this->once())->method('has')->with('cityName')->will($this->returnValue(true));
        $this->responseCookie->expects($this->once())->method('get')->with('cityName')->will($this->returnValue($this->httpCookie));
        $this->httpCookie->expects($this->once())->method('getValue')->will($this->returnValue($cookieValueGet));
        $this->responseCookie->expects($this->once())->method('set')->with('cityName', $cookieValueSet, time() + 15 * 86400);
        $this->cookiesLibrary->save($cityName);
    }
}
