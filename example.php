<?php
/**
* Copyright (C) 2012 Sam Williams <sam@swilliams.com.au>
*
* Permission is hereby granted, free of charge, to any person obtaining a copy of
* this software and associated documentation files (the "Software"), to deal in
* the Software without restriction, including without limitation the rights to
* use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
* of the Software, and to permit persons to whom the Software is furnished to do
* so, subject to the following conditions:
*
* The above copyright notice and this permission notice shall be included in all
* copies or substantial portions of the Software.
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
* SOFTWARE.
*/

require_once('eway.php');

$eway = new eway('REAL_TIME_CVN', TRUE);

$eway
    ->setCustomerID('87654321')
    ->setCardNumber('4444333322221111')
    ->setCardHoldersName('John Smith')
    ->setTotalAmount(1.00)
    ->setCardExpiry('08', '09')
    ->setCVN('123')
    ->setCustomerFirstName('Firstname')
    ->setCustomerLastName('Lastname')
    ->setCustomerEmail('name@xyz.com.au')
    ->setCustomerAddress('123 Someplace Street, Somewhere ACT')
    ->setCustomerPostcode('2609')
    ->setCustomerInvoiceReference('INV120394')
    ->setCustomerInvoiceDescription('Testing')
    ->setCustomerTransactionNumber('4230')
    ->setOption1('')
    ->setOption2('')
    ->setOption3('')
    ;

$eway->pay();

header('Content-type: text/xml');
echo $eway->getTransactionResponse();