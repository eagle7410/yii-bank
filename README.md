# yii-bank

##Установка

Выполняем команды в нужной папке.  
```bash
git clone https://github.com/eagle7410/yii-bank.git
cd yii-bank
composer install
php init
```
Надо отредактировать файл ./common/config/main-local.php
```text 
'db' => [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=ХОСТ;dbname=ИМЯ_БАЗЫ_ДАННЫХ',
    'username' => 'ПОЛЬЗОВАТЕЛЬ_БАЗЫ_ДАННЫХ',
    'password' => 'ПАРОЛЬ_БАЗЫ_ДАННЫХ',
    'charset' => 'utf8',
],
```
Выполняем команду
```bash
php yii migrate
```
Все заходим в админку. Адресс URL/admin/  
Пользователь для входа
login    : admin  
password : admin1234  

Запуск корона через следущую комманду:  
 
```bash 
php yii cron/income-commissions
```
