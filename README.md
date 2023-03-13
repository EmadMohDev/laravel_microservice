# <p align="center">Laravel10 Microservcies</p>

<p align="center">
    <img src="https://user-content.gitlab-static.net/be4169c092b35b099f62186d45999645b6b6b9b9/68747470733a2f2f7261772e67697468756275736572636f6e74656e742e636f6d2f6c61726176656c2f6172742f6d61737465722f6c6f676f2d6c6f636b75702f352532305356472f32253230434d594b2f3125323046756c6c253230436f6c6f722f6c61726176656c2d6c6f676f6c6f636b75702d636d796b2d7265642e737667" alt="Docker" width="300px">


    
</p>


# Description

- this demo to make microservices with laravel


# Skills

- Laravel10 , php8 , RabbitMq , Docker


# laravel micro services app : 

- the backend : we have two backend : 
    a-Admin (CRUD for products)  
    b-Main (front where we can like products)
- they have the same data sync  but with different database 
- they connect each others by Rabbit MQ
- the two backend apps run by docker
- the operation is : 
    1-like the product on Main app => then this will fire an event through Rabbit MQ  
   and then this you will see this effect on Admin app

   2-also when (  add new product / edit / delete product  )  from the Admin app => So this will fire event to Rabbit MQ 
   and after this event is consumed  => it will appear on Main app


- create new laravel app "Admin" by run this command  :
```
  laravel new admin
```

-to make your ide support auto complete  we will install IDE Helper Generator for Laravel  :
https://github.com/barryvdh/laravel-ide-helper 

by run this command :
```
composer require --dev barryvdh/laravel-ide-helper
```
This package generates helper files that enable your IDE to provide accurate autocompletion. Generation is done based on the files in your project, so they are always up-to-date.

It supports Laravel 8+ and PHP 7.3+

-then run this command : ( // this will generate this new file :   _ide_helper.php   that will help in auto complete  )
```
php artisan ide:generate
```



# edit Database on Admin app :

- create products table and have these column ( title / image / likes) by run  :
```
 php artisan make:migration create_products_table
```

 - make product model :
```
php artisan make:model Product
```

 - make auto complete for all models by ide package :
```
php artisan ide:models
```
- create product factory by this command : 
```
 php artisan make:factory  ProductFactory 
 ```


- make these seeders [UserSeeder  and  ProductSeeder ]  and call faker inside it for each model :
```
 php artisan make:seeder UserSeeder
 php artisan make:seeder ProductSeeder
```
- then run this command to make seed :
```
 php artisan db:seed
```
-create product controller : 
```
 php artisan make:controller  ProductController
```



# after that we create our main app :
- create main app by run  :
```
 laravel new main
 composer require --dev barryvdh/laravel-ide-helper
 php artisan ide:generate
```
- edit main\docker-compose.yaml  to replace admin with main conatiner and change your machine expose ports 
to not conflict with admin container  
THEN run this command :
```
docker-compose up
```
- enter to docker main machine :
```
docker-compose up  --build    // to restart and build (--build make for the first time only)
docker-compose exec main sh
```

#  Database modification:  
- remove all migrations except failed_jobs
- failed jobs   => we need as we will use rabbit MQ   => to catch failed events 

- create products table by run  :
```
 php artisan make:migration create_products_table
 ```
 
- then run :
```
php artisan migrate
```
- make Product Controller :
```
php artisan make controller ProductController 
```


- and make Product model :
```
php artisan make:model Product 
```

- run this to make autoload for models on main app :
```
php artisan ide:models  
```



#  To make event that fire after create new product on Admin app 
and this will be catched on Main app by Rabbit Mq :

- make ProductCreated  job on Admin app : 
```
php artisan make:job ProductCreated
```
- make ProductCreated  job on Main app : 
```
php artisan make:job ProductCreated
```
- then add on Main app on EventServiceProvider  the job   ProductCreated :

 ```php
  public function boot(): void
    {
        \App::bindMethod(ProductCreated::class.'@handle', fn($job) => $job->handle() );
    }
   ```


# to make product create / edit / delete from Admin app  Consist with product data on Main app 

- create product update and delete jobs on Admin app :
 ```
php artisan make:job ProductUpdated 
php artisan make:job ProductDeleted 
   ```
