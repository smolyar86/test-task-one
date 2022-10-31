## Тестовое задание №1
Для хранения учетных записей пользователей, в проекте была создана следующая таблица в БД:

```sql
create table users
(
    id int auto_increment,
    name varchar(64) not null,
    email varchar(256) not null,
    created DATETIME not null,
    deleted DATETIME null,
    notes TEXT null,
    constraint users_pk
        primary key (id)
);

create unique index users_email_uindex
    on users (email);
 
create unique index users_name_uindex
    on users (name);
 ```

Необходимо реализовать класс/классы для чтения, создания и изменения записей в таблице users. Необходимо учесть ряд дополнительных бизнес-требований к работе с пользователями:
- значение поля 'name' (имя пользователя):
  - может состоять только из символов a-z и 0-9;
  - не может быть короче 8 символов;
  - не должно содержать слов из списка запрещенных слов;
  - должно быть уникальным;
- значение поля 'email':
  - должно иметь корректный для e-mail адреса формат;
  - не должно принадлежать домену из списка "ненадежных" доменов;
  - должно быть уникальным;
- значение поля 'deleted':
  - отражает факт "удаления" пользователя (т. н. "soft-delete");
  - не может быть меньше значения поля 'created';
  - для неудаленного, активного пользователя равно NULL;
  - каждое изменение существующей учетной записи пользователя должно журналироваться.

## Установка
- docker compose up -d
- docker exec -it test-task-one composer install
- docker exec -it test-task-one php artisan migrate

## Требования
- PHP >= 8.0.2 with `json` and `pdo` extensions enabled.

## Тестирование
- docker exec -it test-task-one php artisan test

## Классы

Для решения задачи использовался laravel 9

Класс | Описание                                                                                      |
--- |-----------------------------------------------------------------------------------------------|
\App\Models\User | Модель для таблицы users                                                                      |
\App\Repository\UserRepository | Рипозитарий для получения данных из таблицы users                                             |
\App\Commands\Command | Абстрактный класс для создания команды                                                        |
\App\Commands\CommandHandler | Абстрактный класс для обработчика команды                                                     |
\App\Commands\CommandBus | Класс для отправки команд на выполнение                                                       |
\App\Commands\User\CreateUser| Команда для создания новой записи пользователя                                                |
\App\Commands\User\CreateUserHandler | Обработчик команды создания нового пользователя                                               |
\App\Commands\User\UpdateUser| Команда для изменения записи пользователя                                                     |
\App\Commands\User\UpdateUserHandler | Обработчик команды изменения пользователя                                                     |
\App\Commands\User\DeleteUser| Команда для удаления записи пользователя                                                      |
\App\Commands\User\DeleteUserHandler | Обработчик команды удаления пользователя                                                      |
\App\Validation\User | Правила валидации полей таблицы users                                                         |
\App\Validation\Rules\NotBadWord | Валидация на запрещенные слова, список хранится в config/validation.php                       |
\App\Validation\Rules\NotIllegalDomain | Валидация на запрещенные домены, список хранится в config/validation.php                      |
\App\Observers\UserObserver | Слушатель событий изменения модели User, ведет лог изменений в storage/logs/changes-Y-m-d.log |

## Использование

Примеры использования можно посмотреть в контроллере \App\Http\Controllers\UserController

### Разрешение зависимотестей (см. App\Providers\CommandBusServiceProvider)
```php
app()->bind(App\Contracts\Command\Inflector::class, App\Commands\NameInflector::class);
app()->bind(App\Contracts\Command\CommandBus::class, App\Commands\CommandBus::class);
```

### Создание нового пользователя

```php
$user = app(CommandBus::class)->execute(
    new App\Commands\User\CreateUser(
        'username',
        'mail@test.com'
    )
);
```

### Измение email пользователя

```php
$command = new App\Commands\User\UpdateUser($userId);
$command->setEmail('newmail@test.com');

$changedUser = app(CommandBus::class)->execute($command);
```

### Удаление пользователя

```php
app(CommandBus::class)->execute( new App\Commands\User\DeleteUser($userId));
```

### Получение данных о пользователе по id

```php
$repository = new \App\Repository\UserRepository();
$user = $repository->getUserById($userId)
```

### Получение списка пользователей разбитых на страницы по 25 пользователей

```php
$repository = new \App\Repository\UserRepository();
$page1 = $repository->getUsers(1, 25); //страница 1
$page2 = $repository->getUsers(2, 25); //страница 1
```
