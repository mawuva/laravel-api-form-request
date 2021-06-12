# API Form Request

Extending FormRequest for REST API Request Validation

## Installation

You can install the package via composer:

```bash
composer require mawuekom/laravel-api-form-request
```

## Usage

```php
namespace App\Http\Requests;

use Mawwuekom\ApiFormRequest\ApiFormRequest;

class CreateUserRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'          => 'required|string|max:255',
            'first_name'    => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:users',
            'password'      => 'required|string|min:6|confirmed',
        ];
    }
}
```

Once done, it will look like this in your controller

```php
namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;

class UserController extends Controller
{

    public function register(CreateUserRequest $request)
    {
        User::create([
            'name' => request('name'),
            'first_name' => request('first_name'),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
        ]);
    }
}
```
 And the errors will look like this

```json
{
    "errors": [
        {
            "field": "email",
            "message": "The email has already been taken."
        },
        {
            "field": "password",
            "message": "The password confirmation does not match."
        }
    ]
}
```

Hope this package will help you to build great things... 🏙️  Have fun 👍

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

