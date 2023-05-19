# Canoe App

## Entities

To comply with the entities required, the application must have 5 main models that hold a part of the data model.

Fund, Fund Manager, and Company are the three main entities set by the business requirements. FundAlias is an auxiliary table to complement data from the Fund, since each Fund can have multiple aliases, it's a good practice to separate it into its own table.
FundCompany is a pivot table to hold the relationship between Funds and Companies, since they are a many to many relationship.

## Events

There are events and listeners to react to when the application creates an event, and to deal with duplicate funds. A DuplicateFund model holds the duplicate funds and can be useful for creating reports of duplicates.

## Service

The service holds most of the business logic of the application, serving as the inner most layer, which can be injected using Dependency Injection in any class that requires it.