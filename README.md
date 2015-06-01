# tweetsmap

Demo application: http://tweetsmap.siam4friend.com
Code coverage : http://tweetsmap.siam4friend.com/coverage/
Unit test : http://tweetsmap.siam4friend.com/report.html

## Requirements

- Phalcon PHP framework
- mongodb


## Getting started

```
$ git clone git@github.com:piranon/tweetsmap.git
$ cd tweetsmap
$ composer install
$ mkdir app/views/compiled
$ chmod 775 app/views/compiled
```

#### MongoDB

```
mongo
$ use tweetsmap
$ db.tweets.createIndex( { city: 1 } )
$ db.tweets.createIndex( { "expireAt": 1 }, { expireAfterSeconds: 0 } )
```

## Test & QA Tools

- Codeception
- PHP_CodeSniffer
- PHP Mess Detector
- PHP Copy/Paste Detector


#### Unit test
```
./vendor/bin/codecept run unit
```

#### Code coverage
```
./vendor/bin/codecept run unit --coverage --coverage-html
```

#### PHP_CodeSniffer
```
./vendor/bin/phpcs --standard=codesniffer.xml app
```

#### PHP Mess Detector
```
./vendor/bin/phpmd app text phpmd.xml
```

#### PHP Copy/Paste Detector
```
./vendor/bin/phpcpd app
```