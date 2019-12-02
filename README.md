# Laracatch Server

This is the server component for the [Laracatch Client](https://github.com/laracatch/client), which allows you to publicly share your Laravel errors.

### Quick Start

* Clone the repository 
* Clone the UI from https://github.com/laracatch/ui into `ui`
* Install the dependencies `npm install`
* Run the command `composer ui` from the root of the project

### Storage

The application supports Eloquent storage (default) and AWS DynamoDB.

* Prerequisites for using Eloquent

    * Run `php artisan migrate` to migrate the database
    * Use the Eloquent adapter `STORAGE_ADAPTER=eloquent`
    
* Prerequisites for using DynamoDB

    * Fill the required environment variables (`DYNAMODB_`)
    * Use the DynamoDB adapter `STORAGE_ADAPTER=dynamodb`
    * Create the `shares` table using the artisan command `dynamodb:create-tables` 
