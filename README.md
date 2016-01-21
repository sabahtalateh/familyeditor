# Family Editor

Тестовое задание для livetex демо как что делать тут https://www.youtube.com/watch?v=T7XRjXnxedY&feature=youtu.be&hd=1

## Как запустить на локальной машине
### Способ запуска с ипользванием Vagrant
- Установите Virtualbox https://www.virtualbox.org/wiki/Downloads
- Установите vagrant https://www.vagrantup.com/downloads.html
- Добавьте образ со всем необходимым для запуска в Vagrant 
```vagrant box add laravel/homestead```
- Клонируйте репозиторий
- Выполните в директории с репозиторием
```composer install``` затем
```php vendor/bin/homestead make```
- Внесите необходимые настройки в файл 
```Homestead.yaml``` https://laravel.com/docs/5.2/homestead#installation-and-setup
- Выполните команду
```vagrant up```
- Сделайте копию файла ```.env.example``` с именем ```.env```, настройте там все что нужно
- Выполните
```php artisan key:generate``` затем
```vagrant ssh``` затем зайдите в папку с вашим проектом и выполните
```php artisan migrate```
- Всё готово, заходите по ip адресу который указали в ```Homestead.yaml``` или по алиасу который для него сделали

# Информация
Для хранени данных испозьзуется подход ClosureTable немного измененный чтобы иметь возможность хранить двух потомков для узла.

Как то я там нашёл баг при построении дерева когда что попало куда попало добавлял, но не запомнил что куда добавлял, если найдёте баг добавьте ишью



