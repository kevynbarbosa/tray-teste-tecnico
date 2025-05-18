Projeto utiliza Laravel Sail como container de docker
.env.example deve conter as configurações necessárias para rodar o projeto.

Optei por utilizar apenas a fila default para facilitar desenvolvimento, mas cada job deve conter sua propria fila para fins de paralelismos

Existe uma branch chamada StatePattern que não está funcional, porém uma tentative de implementar o State Pattern de maneira total!

1. sail up
2. sail composer install
3. sail artisan queue:work
