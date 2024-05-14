# flodesk-wrapper-php
Simple (unofficial) wrapper around the Flodesk API for PHP.

I have tested this wrapper only on PHP7 and PHP8 ~ but should work on other versions of PHP 5.4 and above.
It requires CURL extension to work.

## Usage

To add a user to segment, you need to ensure that the user exists. If user doesnt exist, it can not be added to segment.
Here is the simple steps:
- check if user exists,
- add user if it doesnt exist, and
- finally add user to segment(s)

Flodesk API is graceful and only updates user if it exists, for this reason, instead of making 3 requests (as above), I make 2 requests
- create user (does nothing if user exists, updates when name changes)
- add user to segment(s)

```
<?php
require_once "Flodesk.php";
$apikey = "******";
$email = "customer_name@gmail.com"
$fname = "John";
$lname = "Doe";
$segmentId = "***"; // list Id

$flodesk = new Flowdesk($apikey);
$flodesk->create($email, $fname, $lname);
$flodesk->subscribe($segmentId, $email);
```

I have tried to keep things really simple, and have not covered all endpoints, but the other endpoints follow the same convention.

If you experience any difficulty with the implementation in a LIVE project, then ask question with the issue and I would look into it.

Kind regards.
