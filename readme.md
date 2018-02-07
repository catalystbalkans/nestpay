# Omnipay: NestPay 3D_Pay
[thephpleague/omnipay](https://github.com/thephpleague/omnipay) NestPay biblioteka za obradu plaćanja.

### Metodi:
 * **Purchase** (*Auth*: Sale Prodaja)
 * **Authorize** (*PreAuth*: Preautorizacija)
 * **Capture** (*PostAuth*: Zatvaranje autorizacije)
 * **Void** (*Void*: Poništavanje transakcije)
 * **Refund** (*Credit*: Povraćaj)

### NestPay 3D_Pay podržavaju sledeće banke:
 * Banca Intesa Beograd
 * ..
 
## Instalacija
    composer require catalystbalkans/nestpay
	
## Upotreba

	use Omnipay\Omnipay;

	$gateway = Omnipay::create('Nestpay');
	$gateway->setBank('test');
	$gateway->setClientId('clientid');
	$gateway->setStoreKey('storekey');
    
## Dokumentacija
[Wiki](https://github.com/catalystbalkans/nestpay/wiki)

## Drugi Omnipay paketi
 * NestPay (CC5) https://github.com/yasinkuyu/omnipay-nestpay
 * Postnet https://github.com/yasinkuyu/omnipay-posnet
 * Iyzico https://github.com/yasinkuyu/omnipay-iyzico
 * GVP (Granti Sanal Pos) https://github.com/yasinkuyu/omnipay-gvp
 * BKM Express https://github.com/yasinkuyu/omnipay-bkm

## TODO
* Skloniti nepotrebno ubacivanje podataka o kartici za određene transakcije jer se to odrađuje na serveru banke