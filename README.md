skype : tigre4666
phone : +(seven) 9 8 (seven) 2 6 4 8 9 0 3

# Реализация - Биржевой обменник

### Системные требования

* php 7.1+
* mariadb 10+|mysql
* composer

### Объекты

`order-book`

```
    {
        "asks": [],
        "bids": [
            [
                "1.00000000", //amount
                "3.00000000"  //rate
            ]
        ],
        "depth": 5
    }
```

`user`

```
    {
        id : 1,
        email : 'crypto_hamster@gmail.com',
        accounts : []//expand
    }
```

`tools`

```
   {
        id : 1,
        code : 'BTC_BCH',
        baseCurrency : {}//expand
        quoteCurrency : {}//expand
   } 
```

`currency`

```
    {
        name : 'Bitcoin Cash',
        code : 'BCH'
    }
```

`user`

```
    {
        id : 1,
        email : 'crypto_hamster@gmail.com',
        accounts : [] //expand
    }
```

`account`
```
    {
        id : 1,
        balance : 1000,
        hold : 900
        free : 100,
        currency : {} 
    }
```

`order`

```
    {
        id : 1,
        rate : 1.00000001,
        amount : 1000.0,
        type : 'buy'|'sell',
        tools_id : 100,
        tools : {} //expand
    }
````

### Методы

`GET` /users
* filter

* * email_like
 
--- 
 
`POST` /users

---

`POST` /orders

---

`GET` /orders
* filter

* * type

* * user_id

---

`GET` /tools

---

`GET` /tools/[id]/order-book



