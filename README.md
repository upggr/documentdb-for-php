Access Azure DocumentDB resources from php!

Usage :
```php
include 'documentdb-for-php.php';
$host = 'https://yourdocumentdbaccount.documents.azure.com'; // see (1) in the screenshots bellow
$master_key = 'yourmasterkey=='; // see (2) in the screenshots bellow
$db = 'yourdbname'; // see (3) in the screenshots bellow (optional)
$db_rid = 'thedbresourceid=='; // see (4) in the screenshots bellow
$coll = 'yourcollectionname'; // see (5) in the screenshots bellow (optional)
$coll_rid = 'yourcollectionresourceid='; // see (6) in the screenshots bellow
$query = "Select * from ..."; // This is your SQL or LINQ code
querycoll($host, $db_rid, $coll_rid, $query,$apptype,$useragent,$cachecontrol,$da_date,$api_version,$master,$token,$master_key,$da_date); //The function that does the magic. All variables are defined above and in the functions file
```

The above code, is a working example, you do not need any other dependencies etc. Just include the file and copy paste the code replacing the variables as above.
You will get back a json response with whatever you asked in the query, that simple!

currently tested for select statements, a work in progress. Sorry for not making it Object Oriented! :)


![Alt text](/docs/vars1.png?raw=true "Optional Title")
![Alt text](/docs/vars2.png?raw=true "Optional Title")
