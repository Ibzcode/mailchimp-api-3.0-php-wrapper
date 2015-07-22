MailChimp API 3.0 Wrapper Class
===============================

Uses cURL to connect to the API with basic authorization.

Wrote this for one of my projects. Feel free to use, share and improve.


Usage
-----

Replace values inside `< >` with actual values.

Subscribe a new member to a list.

```php
$MailChimp = new MailChimp(<apikey>);
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
$MailChimp = new MailChimp(<apikey>);
$result = $MailChimp->call('lists/<list_id>/members/'.md5('<subscriber_email_address>'), 'PATCH', array('merge_fields' => array('FNAME'=>'<new first name>')));
print_r($result);
```

Delete subscriber from the list.

```php
$MailChimp = new MailChimp(<apikey>);
$result = $MailChimp->call('lists/<list_id>/members/'.md5('<subscriber_email_address>'), 'DELETE');
print_r($result);
```
Retrieve a particular subscriber's details.
```php
$MailChimp = new MailChimp(<apikey>);
$result = $MailChimp->call('lists/<list_id>/members/'.md5('<subscriber_email_address>'), 'GET');
print_r($result);
```

Retrieve list details.

```php
$MailChimp = new MailChimp(<apikey>);
$result = $MailChimp->call('lists/', 'GET');
print_r($result);
```

Retrieve subscriber list using offset and count.

```php
$MailChimp = new MailChimp(<apikey>);
$result = $MailChimp->call('lists/<list_id>/members', 'GET', array(
            'offset'=>10,
				    'count'=>10
		      ));
print_r($result);
```
