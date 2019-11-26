simple todo app  using Symfony 4 and FormType. 

pakages used:

 1- doctrine
  
 2- maker
  
 3- asset 
 
 4- twig 
 
 5- annotations
 
 6- profiler

usage:

1- clone the project into your machine
2- make the database: 
    php bin/console doctrine:database:create
3- run:  
    php bin/console make:migration
4- then:  
    php bin/console doctrine:migration:migrate

NOTE: 

    This project is very simple and lack of lots of feature like:
    
    delete todo not working properly
    
NOTE: 

    this will be update simultaneously