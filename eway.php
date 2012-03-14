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

class eway
{
    /**
     * @var $customerID string eWay customer ID
     */
    protected $customerID;

    /**
     * @var $totalAmount int Transaction amount in cents
     */
    protected $totalAmount;

    /**
     * @var $customerFirstName string Customer's first name
     */
    protected $customerFirstName;

    /**
     * @var $customerLastName string Customer's last name
     */
    protected $customerLastName;

    /**
     * @var $cutomerEmail string Customer's email address
     */
    protected $customerEmail;

    /**
     * @var $customerAddress string Customer's address
     */
    protected $customerAddress;

    /**
     * @var $customerPostcode string Customer's postcode
     */
    protected $customerPostcode;

    /**
     * @var $customerInvoiceDescription string Invoice description
     */
    protected $customerInvoiceDescription;

    /**
     * @var $customerInvoiceRef string Invoice reference
     */
    protected $customerInvoiceRef;

    /**
     * @var $cardHoldersName string The name on the credit card
     */
    protected $cardHoldersName;

    /**
     * @var $cardNumber string The credit card number
     */
    protected $cardNumber;

    /**
     * @var $cvn string The credit card CVN/CSV
     */
    protected $cvn;

    /**
     * @var $cardExpiryMonth string The credit card expiry month
     */
    protected $cardExpiryMonth;

    /**
     * @var $cardExpiryYear string The credit card expiry year
     */
    protected $cardExpiryYear;

    /**
     * @var $transactionNumber string The transaction number for the sale
     */
    protected $customerTransactionNumber;

    /**
     * @var $option1 string eWay option 1
     */
    protected $option1;

    /**
     * @var $option2 string eWay option 2
     */
    protected $option2;

    /**
     * @var $apiURL string API URL
     */
    protected $apiURL;

    /**
     * @var $option3 string eWay option 3
     */
    protected $option3;

    /**
     * @var $transactionResponse string
     */
    protected $transactionResponse;

    /**
     * @var $transactionError string
     */
    protected $transactionError;

    /**
     * @var $transactionStatus string
     */
    protected $transactionStatus;

    /**
     * @var $transactionNumber string
     */
    protected $transactionNumber;

    /**
     * @var $transactionReference string
     */
    protected $transactionReference;

    /**
     * @var $transactionAmount string
     */
    protected $transactionAmount;

    /**
     * @var $transactionAuthCode string
     */
    protected $transactionAuthCode;

    /**
     * @var $transactionOption1 string
     */
    protected $transactionOption1;

    /**
     * @var $transactionOption2 string
     */
    protected $transactionOption2;

    /**
     * @var $transactionOption3 string
     */
    protected $transactionOption3;

    /**
     * @var $responseCode string
     */
    protected $responseCode;

    /**
     * Response codes returned by the gateway
     *
     * The list of codes is complete according to the
     * {@link http://www.eway.com.au/Developer/payment-code/transaction-results-response-codes.aspx eWAY Payment Gateway Bank Response Codes}
     *
     * @var $responseCodes array
     */
    public static $responseCodes = array(
        '00' => array('text' => 'Transaction Approved', 'approved' => TRUE),
        '01' => array('text' => 'Refer to Issuer', 'approved' => FALSE),
        '02' => array('text' => 'Refer to Issuer, special', 'approved' => FALSE),
        '03' => array('text' => 'No Merchant', 'approved' => FALSE),
        '04' => array('text' => 'Pick Up Card', 'approved' => FALSE),
        '05' => array('text' => 'Do Not Honour', 'approved' => FALSE),
        '06' => array('text' => 'Error', 'approved' => FALSE),
        '07' => array('text' => 'Pick Up Card, Special', 'approved' => FALSE),
        '08' => array('text' => 'Honour With Identification', 'approved' => TRUE),
        '09' => array('text' => 'Request In Progress', 'approved' => FALSE),
        '10' => array('text' => 'Approved For Partial Amount', 'approved' => TRUE),
        '11' => array('text' => 'Approved, VIP', 'approved' => TRUE),
        '12' => array('text' => 'Invalid Transaction', 'approved' => FALSE),
        '13' => array('text' => 'Invalid Amount', 'approved' => FALSE),
        '14' => array('text' => 'Invalid Card Number', 'approved' => FALSE),
        '15' => array('text' => 'No Issuer', 'approved' => FALSE),
        '16' => array('text' => 'Approved, Update Track 3', 'approved' => TRUE),
        '19' => array('text' => 'Re-enter Last Transaction', 'approved' => FALSE),
        '21' => array('text' => 'No Action Taken', 'approved' => FALSE),
        '22' => array('text' => 'Suspected Malfunction', 'approved' => FALSE),
        '23' => array('text' => 'Unacceptable Transaction Fee', 'approved' => FALSE),
        '25' => array('text' => 'Unable to Locate Record On File', 'approved' => FALSE),
        '30' => array('text' => 'Format Error', 'approved' => FALSE),
        '31' => array('text' => 'Bank Not Supported By Switch', 'approved' => FALSE),
        '33' => array('text' => 'Expired Card, Capture', 'approved' => FALSE),
        '34' => array('text' => 'Suspected Fraud, Retain Card', 'approved' => FALSE),
        '35' => array('text' => 'Card Acceptor, Contact Acquirer, Retain Card', 'approved' => FALSE),
        '36' => array('text' => 'Restricted Card, Retain Card', 'approved' => FALSE),
        '37' => array('text' => 'Contact Acquirer Security Department, Retain Card', 'approved' => FALSE),
        '38' => array('text' => 'PIN Tries Exceeded, Capture', 'approved' => FALSE),
        '39' => array('text' => 'No Credit Account', 'approved' => FALSE),
        '40' => array('text' => 'Function Not Supported', 'approved' => FALSE),
        '41' => array('text' => 'Lost Card', 'approved' => FALSE),
        '42' => array('text' => 'No Universal Account', 'approved' => FALSE),
        '43' => array('text' => 'Stolen Card', 'approved' => FALSE),
        '44' => array('text' => 'No Investment Account', 'approved' => FALSE),
        '51' => array('text' => 'Insufficient Funds', 'approved' => FALSE),
        '52' => array('text' => 'No Cheque Account', 'approved' => FALSE),
        '53' => array('text' => 'No Savings Account', 'approved' => FALSE),
        '54' => array('text' => 'Expired Card', 'approved' => FALSE),
        '55' => array('text' => 'Incorrect PIN', 'approved' => FALSE),
        '56' => array('text' => 'No Card Record', 'approved' => FALSE),
        '57' => array('text' => 'Function Not Permitted to Cardholder', 'approved' => FALSE),
        '58' => array('text' => 'Function Not Permitted to Terminal', 'approved' => FALSE),
        '59' => array('text' => 'Suspected Fraud', 'approved' => FALSE),
        '60' => array('text' => 'Acceptor Contact Acquirer', 'approved' => FALSE),
        '61' => array('text' => 'Exceeds Withdrawal Limit', 'approved' => FALSE),
        '62' => array('text' => 'Restricted Card', 'approved' => FALSE),
        '63' => array('text' => 'Security Violation', 'approved' => FALSE),
        '64' => array('text' => 'Original Amount Incorrect', 'approved' => FALSE),
        '66' => array('text' => 'Acceptor Contact Acquirer, Security', 'approved' => FALSE),
        '67' => array('text' => 'Capture Card', 'approved' => FALSE),
        '75' => array('text' => 'PIN Tries Exceeded', 'approved' => FALSE),
        '82' => array('text' => 'CVV Validation Error', 'approved' => FALSE),
        '90' => array('text' => 'Cutoff In Progress', 'approved' => FALSE),
        '91' => array('text' => 'Card Issuer Unavailable', 'approved' => FALSE),
        '92' => array('text' => 'Unable To Route Transaction', 'approved' => FALSE),
        '93' => array('text' => 'Cannot Complete, Violation Of The Law', 'approved' => FALSE),
        '94' => array('text' => 'Duplicate Transaction', 'approved' => FALSE),
        '96' => array('text' => 'System Error', 'approved' => FALSE)
    );

    /**
     * @param bool $test_gateway
     */
    public function __construct($test_gateway = FALSE)
    {
        if($test_gateway)
        {
            $this->apiURL = 'https://www.eway.com.au/gateway_cvn/xmltest/testpage.asp';
        }
        else
        {
            $this->apiURL = 'https://www.eway.com.au/gateway_cvn/xmlpayment.asp';
        }
    }

    /**
     * Sets the unique eWay customer ID
     * @param $id string
     * @return eway
     * @throws ErrorException
     */
    public function setCustomerID($id)
    {
        if(strlen($id) > 8)
        {
            throw new ErrorException('Customer ID cannot be longer than eight (8) characters');
        }

        $this->customerID = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerID()
    {
        return $this->customerID;
    }

    /**
     * Sets the payment amount
     * @param $amount float Payment amount in whole dollars
     * @return eway
     */
    public function setTotalAmount($amount)
    {
        $this->totalAmount = floatval($amount)*100;

        return $this;
    }

    /**
     * @return int The total amount in cents
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * Sets the card holder's name
     * @param $name string
     * @return eway
     * @throws ErrorException
     */
    public function setCardHoldersName($name)
    {
        $escaped_name = preg_replace('/[^A-Za-z\s\'-]/', '', $name);

        if(strlen($escaped_name) > 50)
        {
            throw new ErrorException('Card holder name longer than fifty (50) characters');
        }

        $this->cardHoldersName = $escaped_name;

        return $this;
    }

    /**
     * @return string
     */
    public function getCardHoldersName()
    {
        return $this->cardHoldersName;
    }

    /**
     * Sets the card number
     * @param $number string
     * @return eway
     * @throws ErrorException
     */
    public function setCardNumber($number)
    {
        $escaped_number = preg_replace('/[^\d]/', '', $number);

        if(strlen($escaped_number) > 20)
        {
            throw new ErrorException('Card number longer than twenty (20) digits');
        }

        $this->cardNumber = $escaped_number;

        return $this;
    }

    /**
     * @return string
     */
    public function getCardNumber()
    {
        return $this->cardNumber;
    }

    /**
     * Sets the card expiry
     * @param $month string|int
     * @param $year string|int
     * @return eway
     * @throws ErrorException
     */
    public function setCardExpiry($month, $year)
    {
        if((intval($month) < 1) OR (intval($month) > 12) OR (intval($year) > 99))
        {
            throw new ErrorException('Card expiry is invalid type');
        }

        $this->cardExpiryMonth = sprintf('%02d', intval($month));
        $this->cardExpiryYear = sprintf('%02d', intval($year));

        return $this;
    }

    /**
     * @return string
     */
    public function getCardExpiryMonth()
    {
        return $this->cardExpiryMonth;
    }

    /**
     * @return string
     */
    public function getCardExpiryYear()
    {
        return $this->cardExpiryYear;
    }

    /**
     * Sets the card's CSV/CVN
     * @param $cvn string|int
     * @return eway
     * @throws ErrorException
     */
    public function setCVN($cvn)
    {
        $escaped_cvn = preg_replace('/[^\d]/', '', $cvn);

        if(strlen($escaped_cvn) > 4)
        {
            throw new ErrorException('CVN is longer than four (4) digits');
        }

        $this->cvn = $escaped_cvn;

        return $this;
    }

    /**
     * @return string
     */
    public function getCVN()
    {
        return $this->cvn;
    }

    /**
     * Sets the customer's first name
     * @param $name string
     * @return eway
     * @throws ErrorException
     */
    public function setCustomerFirstName($name)
    {
        $escaped_name = preg_replace('/[^A-Za-z\s\'-]/', '', $name);

        if(strlen($escaped_name) > 50)
        {
            throw new ErrorException('Customer name longer than fifty (50) characters');
        }

        $this->customerFirstName = $escaped_name;

        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerFirstName()
    {
        return $this->customerFirstName;
    }

    /**
     * Set's the customer's last name
     * @param $name string
     * @return eway
     * @throws ErrorException
     */
    public function setCustomerLastName($name)
    {
        $escaped_name = preg_replace('/[^A-Za-z\s\'-]/', '', $name);

        if(strlen($escaped_name) > 50)
        {
            throw new ErrorException('Customer name longer than fifty (50) characters');
        }

        $this->customerLastName = $escaped_name;

        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerLastName()
    {
        return $this->customerLastName;
    }

    /**
     * Set's the customer's email
     * @param $email string
     * @return eway
     */
    public function setCustomerEmail($email)
    {
        if(preg_match('/[\w-\.]+@(?:[\w]+\.)+[a-zA-Z]{2,4}/', $email))
        {
            $this->customerEmail = $email;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerEmail()
    {
        return $this->customerEmail;
    }

    /**
     * Set's the customer's postal/residential address
     * @param $address string
     * @return eway
     */
    public function setCustomerAddress($address)
    {
        if(strlen($address) > 255)
        {
            $this->customerAddress = substr($address, 0, 254);
        }
        else
        {
            $this->customerAddress = $address;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerAddress()
    {
        return $this->customerAddress;
    }

    /**
     * Sets the customer's postcode
     * @param $postcode string|int
     * @return eway
     */
    public function setCustomerPostcode($postcode)
    {
        $this->customerPostcode = sprintf('%04d', intval($postcode));

        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerPostcode()
    {
        return $this->customerPostcode;
    }

    /**
     * Sets the invoice description
     * @param $description string
     * @return eway
     */
    public function setCustomerInvoiceDescription($description)
    {
        if(strlen($description) > 255)
        {
            $this->customerInvoiceDescription = substr($description, 0, 244);
        }
        else
        {
            $this->customerInvoiceDescription = $description;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerInvoiceDescription()
    {
        return $this->customerInvoiceDescription;
    }

    /**
     * Sets the invoice reference
     * @param $reference string
     * @return eway
     */
    public function setCustomerInvoiceReference($reference)
    {
        if(strlen($reference) > 50)
        {
            $this->customerInvoiceRef = substr($reference, 0, 49);
        }
        else
        {
            $this->customerInvoiceRef = $reference;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerInvoiceReference()
    {
        return $this->customerInvoiceRef;
    }

    /**
     * Sets the transaction number
     * @param $number string
     * @return eway
     * @throws ErrorException
     */
    public function setCustomerTransactionNumber($number)
    {
        if(strlen($number) > 16)
        {
            throw new ErrorException('Transaction number must not exceed sixteen (16) characters in length');
        }

        $this->customerTransactionNumber = $number;

        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerTransactionNumber()
    {
        return $this->customerTransactionNumber;
    }

    /**
     * Sets the eWay option 1
     * @param $text string
     * @return eway
     */
    public function setOption1($text)
    {
        if(strlen($text) > 255)
        {
            $this->option1 = substr($text, 0, 244);
        }
        else
        {
            $this->option1 = $text;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getOption1()
    {
        return $this->option1;
    }

    /**
     * Sets the eWay option 2
     * @param $text string
     * @return eway
     */
    public function setOption2($text)
    {
        if(strlen($text) > 255)
        {
            $this->option2 = substr($text, 0, 244);
        }
        else
        {
            $this->option2 = $text;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getOption2()
    {
        return $this->option2;
    }

    /**
     * Sets the eWay option 3
     * @param $text string
     * @return eway
     */
    public function setOption3($text)
    {
        if(strlen($text) > 255)
        {
            $this->option3 = substr($text, 0, 244);
        }
        else
        {
            $this->option3 = $text;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getOption3()
    {
        return $this->option3;
    }

    /**
     * @return string
     */
    public function getTransactionResponse()
    {
        return $this->transactionResponse;
    }

    /**
     * Sets the XML packet used to make a payment
     * @return string
     */
    public function setPaymentXML()
    {
        $xml = new SimpleXMLElement('<ewaygateway/>');

        if(isset($this->customerID)) $xml->addChild('ewayCustomerID', $this->customerID);
        if(isset($this->totalAmount)) $xml->addChild('ewayTotalAmount', $this->totalAmount);
        if(isset($this->cardHoldersName)) $xml->addChild('ewayCardHoldersName', $this->cardHoldersName);
        if(isset($this->cardNumber)) $xml->addChild('ewayCardNumber', $this->cardNumber);
        if(isset($this->cardExpiryMonth)) $xml->addChild('ewayCardExpiryMonth', $this->cardExpiryMonth);
        if(isset($this->cardExpiryYear)) $xml->addChild('ewayCardExpiryYear', $this->cardExpiryYear);
        if(isset($this->cvn)) $xml->addChild('ewayCVN', $this->cvn);
        if(isset($this->customerFirstName)) $xml->addChild('ewayCustomerFirstName', $this->customerFirstName);
        if(isset($this->customerLastName)) $xml->addChild('ewayCustomerLastName', $this->customerLastName);
        if(isset($this->customerEmail)) $xml->addChild('ewayCustomerEmail', $this->customerEmail);
        if(isset($this->customerAddress)) $xml->addChild('ewayCustomerAddress', $this->customerAddress);
        if(isset($this->customerPostcode)) $xml->addChild('ewayCustomerPostcode', $this->customerPostcode);
        if(isset($this->customerInvoiceDescription)) $xml->addChild('ewayCustomerInvoiceDescription', $this->customerInvoiceDescription);
        if(isset($this->customerInvoiceRef)) $xml->addChild('ewayCustomerInvoiceRef', $this->customerInvoiceRef);
        if(isset($this->customerTransactionNumber)) $xml->addChild('ewayTrxnNumber', $this->customerTransactionNumber);
        if(isset($this->option1)) $xml->addChild('ewayOption1', $this->option1);
        if(isset($this->option2)) $xml->addChild('ewayOption2', $this->option2);
        if(isset($this->option3)) $xml->addChild('ewayOption3', $this->option3);

        return $xml->asXML();
    }

    /**
     * Sends an XML packet to the gateway
     * and returns the gateway response
     * @param $xml string
     * @return string
     */
    protected function sendXML($xml)
    {
        $ch = curl_init($this->apiURL);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        return curl_exec($ch);
    }

    /**
     * Runs the payment and returns 'True'
     * upon successful payment
     * @return bool
     * @throws ErrorException
     */
    public function pay()
    {
        if( !isset($this->customerID) OR
            !isset($this->totalAmount) OR
            !isset($this->cardHoldersName) OR
            !isset($this->cardNumber) OR
            !isset($this->cardExpiryMonth) OR
            !isset($this->cardExpiryYear) OR
            !isset($this->cvn))
        {
            throw new ErrorException('Not all mandatory fields have been set.');
        }

        $xml = $this->setPaymentXML();

        $this->transactionResponse = $this->sendXML($xml);

        $this->loadPaymentResponse($this->transactionResponse);

        if($this->transactionStatus == 'True')
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Takes XML from the payment response and loads
     * into the variables
     * @param $response_string string
     */
    public function loadPaymentResponse($response_string)
    {
        $response = simplexml_load_string($response_string);

        $this->transactionError = (string) $response->{'ewayTrxnError'};
        $this->transactionStatus = (string) $response->{'ewayTrxnStatus'};
        $this->transactionNumber = (string) $response->{'ewayTrxnNumber'};
        $this->transactionReference = (string) $response->{'ewayTrxnReference'};
        $this->transactionAmount = (string) $response->{'ewayReturnAmount'};
        $this->transactionAuthCode = (string) $response->{'ewayAuthCode'};
        $this->transactionOption1 = (string) $response->{'ewayTrxnOption1'};
        $this->transactionOption2 = (string) $response->{'ewayTrxnOption2'};
        $this->transactionOption3 = (string) $response->{'ewayTrxnOption3'};

        if(preg_match('/^\d{2}/', $this->transactionError, $code))
        {
            $this->responseCode = $code[0];
        }
    }

    /**
     * @return string
     */
    public function getTransactionError()
    {
        return $this->transactionError;
    }

    /**
     * @return string
     */
    public function getTransactionStatus()
    {
        return $this->transactionStatus;
    }

    /**
     * @return string
     */
    public function getTransactionNumber()
    {
        return $this->transactionNumber;
    }

    /**
     * @return string
     */
    public function getTransactionReference()
    {
        return $this->transactionReference;
    }

    /**
     * @return string
     */
    public function getTransactionAmount()
    {
        return $this->transactionAmount;
    }

    /**
     * @return string
     */
    public function getTransactionAuthCode()
    {
        return $this->transactionAuthCode;
    }

    /**
     * @return string
     */
    public function getTransactionOption1()
    {
        return $this->transactionOption1;
    }

    /**
     * @return string
     */
    public function getTransactionOption2()
    {
        return $this->transactionOption2;
    }

    /**
     * @return string
     */
    public function getTransactionOption3()
    {
        return $this->transactionOption3;
    }

    /**
     * Get the response code
     *
     * @return string
     */
    public function getResponseCode()
    {
        return $this->responseCode;
    }

    /**
     * Get the text corresponding to the response code
     *
     * @return bool|string
     */
    public function getResponseText()
    {
        if(!isset($this->responseCode))
        {
            return FALSE;
        }
        elseif(array_key_exists($this->responseCode, self::$responseCodes))
        {
            return self::$responseCodes[$this->responseCode]['text'];
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Check if the transaction was approved
     *
     * @return bool
     */
    public function getTransactionApproved()
    {
        if($this->transactionStatus != 'True')
        {
            return FALSE;
        }
        if(!isset($this->responseCode))
        {
            return FALSE;
        }
        elseif(array_key_exists($this->responseCode, self::$responseCodes))
        {
            return self::$responseCodes[$this->responseCode]['approved'];
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Check if a card number is compliant with international standards
     *
     * This is based on ISO/IEC 7812-1:2006
     * {@link http://en.wikipedia.org/wiki/ISO/IEC_7812 ISO/IEC 7812}
     *
     * @param $cardNumber string
     * @return bool
     */
    public static function checkCardNumber($cardNumber)
    {
        $cardNumber = preg_replace('/[^\d]/', '', $cardNumber);

        if((strlen($cardNumber) < 16) OR (strlen($cardNumber) > 20))
        {
            return FALSE;
        }

        $cardNumber = str_split($cardNumber);
        $checkDigit = intval(end($cardNumber));
        $sum = 0;

        for($i = 1; $i < count($cardNumber); $i++)
        {
            if($i&1)
            {
                $digit = $cardNumber[$i-1];
            }
            else
            {
                $number = sprintf('%02d', 2*$cardNumber[$i-1]);
                $digit = $number[0] + $number[1];
            }

            $sum += $digit;
        }

        return $checkDigit == $sum % 10;
    }
}