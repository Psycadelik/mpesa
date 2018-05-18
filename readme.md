## Technologies used:
- laravel 5.6
- GuzzleHttp

## APIs
- Safaricom Daraja Api

## Change Guide:
- Git clone
- Git checkout to your branch
- Make changes and create a pull request

## For use
- Git clone
- Composer install
- create .env file and generate key

- Run php artisan Mpesa:generateToken to create a token
- open postman and test endpoints

## Point to Note
- register to developer.safaricom.co.ke
- create consumer key and secret to populate .env with credentials

## env structure
- SAFARICOM_BASE_URL={https://sandbox.safaricom.co.ke/ - testing, production urls provided by safaricom on going live}
- SAFARICOM_KEY={your key}
- SAFARICOM_SECRET={your secret}
- SAFARICOM_PAYBILL={your paybill no}
- SAFARICOM_CALLBACK_URL={your callback url - MUST BE HTTPS}
- SAFARICOM_CONFIRMATION_URL={your confirmation url - MUST BE HTTPS}
- SAFARICOM_VALIDATION_URL={your validation url - MUST BE HTTPS}

set up ssl for domain urls
