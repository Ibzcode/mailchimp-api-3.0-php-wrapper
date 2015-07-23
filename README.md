MailChimp API 3.0 Wrapper Class
===============================

Uses cURL to connect to the API with basic authorization.

Wrote this for one of my projects. Feel free to use, share and improve.


Usage
-----

Replace values inside `< >` with actual values. For example:

```php
$MailChimp = new MailChimp('abcd89500596');
```

You can set SSL verification to false when creating an instance of the class. You may find this useful when developing on your localhost.

```php
$MailChimp = new MailChimp('abcd89500596', false);
```

Subscribe a new member to a list.

```php
$MailChimp = new MailChimp('<apikey>');
$result = $MailChimp->call('lists/<list_id>/members/', 'POST', array(
            'email_address'     => '<email>',
            'status'            => 'subscribed',
            'merge_fields'      => array('FNAME'=>'<first name>', 
            'LNAME'=>'<last name>')
          ));
print_r($result);
```

Update subscriber's details.

```php
$MailChimp = new MailChimp('<apikey>');
$result = $MailChimp->call('lists/<list_id>/members/'.md5('<subscriber_email_address>'), 'PATCH', array('merge_fields' => array('FNAME'=>'<new first name>')));
print_r($result);
```

Delete subscriber from the list.

```php
$MailChimp = new MailChimp('<apikey>');
$result = $MailChimp->call('lists/<list_id>/members/'.md5('<subscriber_email_address>'), 'DELETE');
print_r($result);
```
Retrieve a particular subscriber's details.
```php
$MailChimp = new MailChimp('<apikey>');
$result = $MailChimp->call('lists/<list_id>/members/'.md5('<subscriber_email_address>'), 'GET');
print_r($result);
```

Retrieve list details.

```php
$MailChimp = new MailChimp('<apikey>');
$result = $MailChimp->call('lists/', 'GET');
print_r($result);
```

Retrieve subscriber list using offset and count.

```php
$MailChimp = new MailChimp('<apikey>');
$result = $MailChimp->call('lists/<list_id>/members', 'GET', array(
            'offset'=>10,
	    'count'=>10
		      ));
print_r($result);
```

Test error handling by sending 'X-Trigger-Error' in the headers inside the Wrapper. You can use these error codes: http://kb.mailchimp.com/api/error-docs/#Error_Docs

```php
$headers = array(
	'Accept: application/json',
	'Content-Type: application/json',
	'X-Trigger-Error: APIKeyInvalid',
	'Authorization: Basic '.$auth
);
```
