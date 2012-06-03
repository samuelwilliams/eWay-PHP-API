# eWay PHP API

This class is designed to make eWay payments very easy. Details about the API can be found on the [eWay website](http://eway.com.au/developers/api/stored-\(xml\).html)

## Example usage

The example below utilises the eWay test gateway

    require_once('eway.php');

    $eway = new eway('REAL_TIME_CVN', TRUE);

    $eway
        ->setCustomerID('87654321')
        ->setCardNumber('4444333322221111')
        ->setCardHoldersName('John Smith')
        ->setPaymentAmount(1.00)
        ->setCardExpiry('08', '09')
        ->setCVN('123')
        ->setCustomerFirstName('Firstname')
        ->setCustomerLastName('Lastname')
        ->setCustomerEmail('name@xyz.com.au')
        ->setCustomerAddress('123 Someplace Street, Somewhere ACT')
        ->setCustomerPostcode('2609')
        ->setCustomerInvoiceReference('INV120394')
        ->setCustomerInvoiceDescription('Testing')
        ->setCustomerTransactionReference('4230')
        ->setOption1('Option Number One')
        ->setOption2('Option Number Two')
        ->setOption3('Option Number Three')
        ;

    $eway->pay();

Each setter method will return the eway class allowing for chaining.

## License

This software is free to use and distribute. Please see [the license file](LICENCE).