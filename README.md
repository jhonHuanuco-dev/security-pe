
## Installation

1. To install the package use the following command:

```bash
  composer require jhonhuanuco-dev/security-pe
```

2. Register the service provider in the `config/app.php` file:

```php
return [
  'providers' => [
    /*
      * Package Service Providers...
      */

    Jhonhdev\SecurityPe\SecurityPeServiceProvider::class,
  ]
];
```

3. Publish the configuration file `config/securitype.php` with the following command:

```bash
  php artisan vendor:publish --provider="Jhonhdev\SecurityPe\SecurityPeServiceProvider"
```

4. Remove the following migrations to avoid conflicts, as Security.pe migrations will be used by default:

- `users`
- `personal_access_tokens`

5. Modify your `app/Models/User.php` model.

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Jhonhdev\SecurityPe\Models\Schemas\Security\Users;

class User extends Users
{
  use HasFactory, Notifiable;
}
```

6. Add a default connection string for your database in `config/database.php` called **default**.:

```php
return [
  'connections' => [
    //...

    'default' => [
      //...
    ]
  ]
];
```

7. Register the middleware of `ActivityUserRequest` in the `App\Http\Kernel.php`.:

```php
protected $middleware = [

  //...
  \Jhonhdev\SecurityPe\Http\Middleware\ActivityUserRequest::class,

];
```

8. Update your configuration file `config/securitype.php` according to your needs before running the migrations..

9. Execute the following command to run the migrations:

```bash
  php artisan migrate
```


## Usage

#### Log-in
Authenticate your application users and register the encrypted token in the database.

```http
  POST /securitype/auth/login
```

| Parameter  | Type     | Description                                                    |
| :--------- | :------- | :------------------------------------------------------------- |
| `username` | `string` | **Required**. User name registered in the database.            |
| `password` | `string` | **Required**. Password of the user registered in the database. |

```json
{
  "status": true,
  "message": "Bienvenido John Smith",
  "user": {
    "branch_id": 1,
    "username": "jhsm",
    "name": "John",
    "last_name": "Smith",
    "email": "example@company.com",
    "extension": 102,
    "state": true
  },
  "token": {
    "key": "1|iplxuLz78Ff9nS1ECDalNv2wJUFJMFVLemBOQJvz",
    "expired": "2024-05-16 22:30:09"
  }
}
```

#### Log-out
Removes the session token of the authenticated user.

```http
  GET /securitype/auth/logout
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `Bearer`  | `string` | **Automatic**. Bearer token       |

```json
{
  "status": true,
  "message": "Hasta pronto.",
}
```


#### Validate Token.
Validate if the token is valid and/or has not expired. The user must be authenticated and the bearer token must be included in the request header.

```http
  POST /securitype/auth/validatetoken
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `Bearer`  | `string` | **Automatic**. Bearer token       |

```json
{
  "status": true,
  "message": "Ok.",
}
```


## Authors

- [@jhonHuanuco-dev](https://github.com/jhonHuanuco-dev)


## License

Security.pe is open-sourced software licensed under the [MIT license](LICENSE.md).