# Что такое? #

Отключение сайт при помощи адмики

# Установка #
В composer.json:

```
#!json
"repositories": [
   { "type": "vcs", "url": "git@bitbucket.org:prodhub/config-bundle.git" }
]
```
Выполнить:

```
#!bash
composer require adw/config-bundle

```

## Конфигурация
```
#!yaml

adw_config:
    rules:
        - {rule: '+', firewalls: ['main']} 
        # "+" на какие firewall распростронять в виде массива
        - {rule: '-', firewalls: ['admin',"dev"]} 
        # "-" на какие не распространять

AppKernel.php:
```


##!php
$bundles = [
   new ADW\ConfigBundle\ADWConfigBundle()
];

###or


return [
    \ADW\ConfigBundle\ADWConfigBundle::class => ['all' => true],
]; 

