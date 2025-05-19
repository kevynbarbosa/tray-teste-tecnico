Projeto utiliza Laravel Sail como container de docker
.env.example deve conter as configurações necessárias para rodar o projeto.

Optei por utilizar apenas a fila default para facilitar desenvolvimento, mas cada job deve conter sua propria fila para fins de paralelismos

1. docker run --rm -it -v $(pwd)/.:/app -w /app laravelsail/php83-composer:latest composer install
2. sail up
3. sail artisan migrate
4. sail artisan queue:work
5. Realizar request em http://localhost/api/import-offers
