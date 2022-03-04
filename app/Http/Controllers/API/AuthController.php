<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserAuthRequest;
use Laravel\Passport\Client as PasswordGrantClient;
use App\Http\Responses\ErrorMessage;
use App\Http\Responses\SuccessMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\MessageBag;

class AuthController extends Controller
{
    public $successStatus = 200;
    /**
     * @group Authenticaton and Authorization
     *
     * Login
     *
     * @bodyParam username string required email or username of the user
     * @bodyParam password string required
     * @bodyParam timezone string nullable
     *
     * @response 200 {
     *      "token_type": "Bearer",
     *      "expires_in": 35999,
     *      "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.oiMzhiMWM5NTUyMTM2Y2NlODJkZjNhOT",
     *      "refresh_token": "def50200c42edf813ab61ae3619dc3581c5f34ea6aaee04f114599ab6d7386ddfc7",
     *      "first_name": "theophilus",
     *      "middle_name": null,
     *      "last_name": "simeon",
     *      "email": "theophilus@logidots.com",
     *      "user_type": "PATIENT",
     *      "first_login": 0,
     *      "current_user_id": 2,
     *      "currency_code": "EUR",
     *      "is_active": "3",
     *      "profile_photo": "http://localhost/fms-api-laravel/public/storage/uploads/1/1600431373-de7f8a81-97b6-4d68-8d8c-5327c4c4b522.jpeg",
     *      "roles": [
     *        "patient"
     *    ]
     * }
     * @response  401 {
     *      "message": "Invalid Username/Password."
     * }
     * @response 422 {
     *  "message": "The given data was invalid.",
     *      "errors": {
     *          "username": [
     *              "The Email/Username field is required."
     *          ],
     *          "password": [
     *          "   The password field is required."
     *          ]
     *  }
     * }
     * @response 403 {
     *    "message": "The given data was invalid.",
     *    "action": "redirect",
     *    "errors": {
     *        "email_otp": [
     *            "Email not verified"
     *        ],
     *        "mobile_otp": [
     *            "Mobile number not verified"
     *        ]
     *    }
     *}
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "action": "redirect",
     *    "errors": {
     *        "email_otp": [
     *            "Email not verified"
     *        ],
     *        "email": [
     *            "coder7@gmail.com"
     *        ],
     *        "mobile_otp": [
     *            "Mobile number not verified"
     *        ],
     *        "country_code": [
     *            "+91"
     *        ],
     *        "mobile_number": [
     *            "9988776631"
     *        ]
     *    }
     *}
     * @response  403 {
     *      "message": "Waiting for Admin to approve your account."
     * }
     * @response  403 {
     *      "message": "Admin has suspended your account."
     * }
     */
    public function login(UserAuthRequest $request)
    {

        $loginData = $request->validated();
        $fieldType = filter_var($loginData['username'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (!auth()->attempt(array($fieldType => $loginData['username'], 'password' => $loginData['password'])) || strcmp(auth()->user()->$fieldType, $loginData['username'])) {

            return new ErrorMessage("Invalid Username/Password.", 401);
        }

        if (auth()->user()->is_active == 0) {
            // check if admin has suspended the account
            return new ErrorMessage('Waiting for Admin to approve your account.', 403);
        } elseif (auth()->user()->is_active == 2) {
            return new ErrorMessage('Admin has suspended your account.', 403);
        }

        $messageBag = new MessageBag();

        if (auth()->user()->hasVerifiedEmail() == NULL) {
            $messageBag->add('email_otp', 'Email not verified');
            $messageBag->add('email', auth()->user()->email);
        }

        if (auth()->user()->login_type != 'ECOMMERCE') {
            if (auth()->user()->hasVerifiedMobileNumber() == NULL) {
                $messageBag->add('mobile_otp', 'Mobile number not verified');
                $messageBag->add('country_code', auth()->user()->country_code);
                $messageBag->add('mobile_number', auth()->user()->mobile_number);
            }
        }

        if ($messageBag->has('email_otp') || $messageBag->has('mobile_otp')) {
            $error = array();
            $error['message'] = 'The given data was invalid.';
            $error['action'] = 'redirect';
            $error['errors'] = $messageBag;
            return response()->json($error, 403);
        }

        $loginData['username'] = auth()->user()->email;
        if ($request->filled('timezone')) {
            auth()->user()->update(['timezone' => $loginData['timezone']]);
        }
        if (auth()->user()->user_type == 'DOCTOR' && is_null(auth()->user()->approved)) {
            $loginData['username'] = auth()->user()->email;
            return $this->getTokenAndRefreshToken($loginData);
        }
        return $this->getTokenAndRefreshToken($loginData);
    }

    /**
     * getTokenAndRefreshToken
     *
     * @param array $loginData
     * @return access_token,refresh_token
     */
    public function getTokenAndRefreshToken($loginData)
    {
        $client = PasswordGrantClient::where('password_client', 1)->first();
        $http = new \GuzzleHttp\Client;

        try {
            $response = $http->request('POST', url('/') . '/oauth/token', [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => $client->id,
                    'client_secret' => $client->secret,
                    'username' => $loginData['username'],
                    'password' => $loginData['password'],
                    'scope' => '*',
                ],
            ]);
        }catch(\GuzzleHttp\Exception\RequestException $e){
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $result = json_decode((string) $response->getBody(), true);
                $result['first_name'] = auth()->user()->first_name;
                $result['middle_name'] = auth()->user()->middle_name;
                $result['last_name'] = auth()->user()->last_name;
                $result['email'] = auth()->user()->email;
                $result['user_type'] = auth()->user()->user_type;
                $result['first_login'] = auth()->user()->first_login;
                $result['current_user_id'] = auth()->user()->id;
                $result['is_active'] = auth()->user()->is_active;
                $result['currency_code'] = auth()->user()->currency_code;
                $photo =  auth()->user()->profile_photo;
                $result['profile_photo'] = NULL;
                $result['roles'] = auth()->user()->getRoleNames();
        
                $lab_pharma_name = NULL;
                if (auth()->user()->user_type == 'PHARMACIST') {
                    $lab_pharma_name = auth()->user()->pharmacy->pharmacy_name;
                } else if (auth()->user()->user_type == 'LABORATORY') {
                    $lab_pharma_name = auth()->user()->laboratory->laboratory_name;
                }
                $result['lab_pharma_name'] = $lab_pharma_name;
        
        
                if ($photo != NULL) {
        
                    $path = storage_path() . "/app/" . $photo;
                    if (file_exists($path)) {
                        $path = Storage::url($photo);
                        $result['profile_photo'] = asset($path);
                    }
                }
                return response()->json($result, $this->successStatus);
            }
        }
        
    }

    /**
     * @authenticated
     *
     * @group Authenticaton and Authorization
     *
     * Logout
     *
     * Authorization: "Bearer {access_token}"
     *
     * @response 200 {
     * "message": "You have been successfully logged out!"
     * }
     *
     * @response  401 {
     *
     *  "message": "Unauthenticated"
     * }
     */
    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        return new SuccessMessage('You have been successfully logged out!');
    }

    /**
     * @group Authenticaton and Authorization
     *
     * Get Access token using Refresh token
     *
     * @bodyParam refresh_token string required
     *
     * Get Access token using Refresh token
     *
     * @response 200 {
     *      "token_type": "Bearer",
     *      "expires_in": 35999,
     *      "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.oiMzhiMWM5NTUyMTM2Y2NlODJkZjNhOT",
     *      "refresh_token": "def50200c42edf813ab61ae3619dc3581c5f34ea6aaee04f114599ab6d7386ddfc7"
     * }
     *
     * @response 422 {
     * "message": "The given data was invalid.",
     * "errors": {
     * "refresh_token": [
     *      "The refresh token field is required."
     *  ]
     * }
     *}
     *@response 401 {
     * "message": "The refresh token is invalid."
     *}
     *
     */
    public function getAccessTokenUsingRefreshToken(Request $request)
    {
        $validatedData = $request->validate([
            'refresh_token' => 'required',
        ]);

        $http = new \GuzzleHttp\Client;
        $client = PasswordGrantClient::where('password_client', 1)->first();

        try {
            $response = $http->post(url('/') . '/oauth/token', [
                'form_params' => [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $validatedData['refresh_token'],
                    'client_id' => $client->id,
                    'client_secret' => $client->secret,
                    'scope' => '',
                ],
            ]);

            $result = json_decode((string) $response->getBody(), true);
            return response()->json($result, $this->successStatus);
        } catch (\Exception $exception) {
            return new ErrorMessage("The refresh token is invalid.", 401);
        }
    }
}
