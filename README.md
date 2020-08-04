# work5
### PHP

:white_check_mark:     
> time left: 4.5 hour
  
-----

Создать страницу с авторизацией пользователя: логин и пароль и реализовать в ней:
возможность регистрации пользователя (email, логин, пароль, ФИО),
при входе в "личный кабинет" возможность сменить пароль и ФИО.
использовать "чистый" PHP 5.6 и выше (без фреймворков) и MySQL 5.5 и выше, дизайн не важен, верстка тоже простая. Наворотов не нужно, хотим посмотреть просто Ваш код.

-----

### SQL

:white_check_mark:     
> time left: 15 min

-----
Есть 2 таблицы

таблица пользователей:

#### users

```
`id` int(11)
`email` varchar(55)
`login` varchar(55)
```

и таблица заказов

#### orders

```
`id` int(11)
`user_id` int(11)
`price` int(11)
```

#### Необходимо:

составить запрос, который выведет список email'лов встречающихся более чем у одного пользователя
вывести список логинов пользователей, которые не сделали ни одного заказа
вывести список логинов пользователей которые сделали более двух заказов

### Docker
:white_check_mark: 
> time left: 15 min