# Language Bloom — дневник изучения иностранных языков

Учебный проект на Yii2 Basic + MySQL. Интерфейс помогает вести словарь, занятия и избранные слова.

## Технологии
- PHP / Yii2 Basic
- MySQL (OpenServer) и phpMyAdmin
- ActiveRecord, миграции Yii2, Gii
- Bootstrap 4 и JavaScript

## Запуск через OpenServer
1. Скопируйте папку `basic1` в каталог доменов OpenServer.
2. Запустите Apache и MySQL.
3. В phpMyAdmin создайте базу данных `dnevnik` с кодировкой `utf8mb4`.
4. Проверьте `config/db.php`: имя базы, пользователя и пароль должны совпадать с настройками MySQL OpenServer.
5. Откройте терминал OpenServer в корне проекта (рядом с файлом `yii`) и выполните:
   ```bash
   php yii migrate
   ```
   Подтвердите применение миграций.
6. Откройте адрес проекта, настроенный в OpenServer. Если используется стандартный document root, укажите каталог `web`.

## Структура базы данных
- `account`: имя, email, хеш пароля, роль (`user` или `admin`).
- `language`: справочник языков.
- `words`: слово, транскрипция, перевод, часть речи; внешний ключ на `language`.
- `history`: история занятий; внешние ключи на `account` и `language`.
- `favorite_word`: избранные слова; внешние ключи на `account` и `words`, уникальная пара пользователя и слова.

## Функциональность
- Регистрация пользователя, вход и выход.
- Пароли хранятся в виде password hash.
- Роли: гость (неавторизованный посетитель), пользователь (`user`), администратор (`admin`).
- `AccessControl` закрывает личный кабинет и CRUD-разделы для гостей; административные контроллеры доступны только администратору.
- Yii2 CSRF validation включена; формы Yii2 автоматически передают CSRF-токен.
- Поиск, фильтрация и сортировка слов на клиентской странице.
- Добавление слов через серверный API в MySQL.
- Личный раздел «Избранные слова».
- Админ-панель со статистикой и CRUD для пользователей, языков, слов и истории.
- Вывод пользовательских данных в PHP-представлениях выполняется через `Html::encode()`.

## Администратор
После применения миграции `m261112_081000_fix_account_and_seed_admin` создаётся тестовый аккаунт:
- Email: `admin@languagebloom.local`
- Пароль: `Admin123!`

Смените пароль после первого входа. Не используйте тестовый пароль на опубликованном сайте.
<img width="1437" height="950" alt="image" src="https://github.com/user-attachments/assets/f0533896-e08c-4046-a56e-bddd10bf4e3b" />
<img width="1440" height="935" alt="image" src="https://github.com/user-attachments/assets/fac36962-51d2-4eb0-924f-6d940718e6e0" />
<img width="1431" height="931" alt="image" src="https://github.com/user-attachments/assets/71b8911a-3737-4fef-bcea-fe05469f61cd" />
<img width="1434" height="933" alt="image" src="https://github.com/user-attachments/assets/01e18040-9906-42c0-be34-b69621a1298a" />
<img width="1423" height="954" alt="image" src="https://github.com/user-attachments/assets/ab1d0df7-b0ff-46dd-8220-5a7202446983" />


