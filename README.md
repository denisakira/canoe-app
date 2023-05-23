# Canoe App

## Entities

To comply with the entities required, the application must have 5 main models that hold a part of the data model.

Fund, Fund Manager, and Company are the three main entities set by the business requirements. FundAlias is an auxiliary table to complement data from the Fund, since each Fund can have multiple aliases, it's a good practice to separate it into its own table.
FundCompany is a pivot table to hold the relationship between Funds and Companies, since they are a many to many relationship.

## Events

There are events and listeners to react to when the application creates an event, and to deal with duplicate funds. A DuplicateFund model holds the duplicate funds and can be useful for creating reports of duplicates.

## Service

The service holds most of the business logic of the application, serving as the inner most layer, which can be injected using Dependency Injection in any class that requires it.

# Running the application

1. Clone this repo

2. Run the following command to run a minimal Docker application that installs Laravel Sail:

```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```

3. Run the command `./vendor/bin/sail up`

4. In a separate Terminal, run the command `./vendor/bin/sail php artisan migrate` to run the migrations.

5. (Optional) Run the command `./vendor/bin/sail php artisan db:seed` to run seeders.

# Testing the application

The basic entities of the application can be seen in a minimal UI interface in localhost/funds

When a duplicate is created it will be logged in the laravel.logs file