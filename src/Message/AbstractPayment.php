<?php

namespace Omnipay\Nestpay\Message;

abstract class AbstractPayment extends AbstractRequest
{
    protected $transactionType;

    protected $endpoints = [
        'test' => 'https://testsecurepay.eway2pay.com/fim/est3Dgate',
		'production' => 'https://bib.eway2pay.com/fim/est3Dgate',
    ];

    protected $allowedCardBrands = [
        'visa' => 1,
        'mastercard' => 2
    ];

    public function getData()
    {
        $this->validate('amount', 'card');

        $cardBrand = $this->getCard()->getBrand();
        if (!array_key_exists($cardBrand, $this->allowedCardBrands)) {
            throw new InvalidCreditCardException('Kartica nije dostupna, samo Visa ili MasterCard se mogu koristiti.');
        } 

        $data = array();

        $data['clientid'] = $this->getClientId();
        $data['oid'] = $this->getOrderId();
        $data['amount'] = $this->getAmount();
        $data['currency'] = $this->getCurrency();
        $data['okUrl'] = str_replace("|", "\\|", str_replace("\\", "\\\\", $this->getReturnUrl()));
        $data['failUrl'] = str_replace("|", "\\|", str_replace("\\", "\\\\", $this->getCancelUrl()));
        $data['storetype'] = '3d_pay_hosting';
		$data['lang']='sr';
		$data['hashAlgorithm']='ver2';
		$data['rnd'] = time();
		$data['trantype'] = $this->transactionType;

		$data['BillToName'] = $this->getBillToName();
		$data['BillToStreet1'] = $this->getBillToStreet1();
		$data['BillToCity'] = $this->getBillToCity();
		$data['BillToCountry'] = $this->getBillToCountry();
		$data['tel'] = $this->getCustomerTelephone();
		$data['email'] = $this->getCustomerEmail();
	
		$separator = "|";
        $signature =    $data['clientid'].$separator.
                        $data['oid'].$separator.
                        $data['amount'].$separator.
                        $data['okUrl'].$separator.
                        $data['failUrl'].$separator.
                        $data['trantype'].$separator.
                        $separator.
                        $data['rnd'].$separator.
			$separator.$separator.$separator.
			$data['currency'].$separator.
                        $this->getStoreKey();
		$data['hash'] = base64_encode(pack('H*', hash('sha512',$signature)));
        return $data;
    }

    public function sendData($data)
    {
        return $this->response = new PaymentResponse($this, $data);
    }

}
