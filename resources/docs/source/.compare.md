---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://localhost/fms-api-laravel/public/docs/collection.json)

<!-- END_INFO -->

#Admin


<!-- START_61d9d2d442ab6775b100c99174308e53 -->
## Admin get specialization by id

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/admin/specialization/1?id=in" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/specialization/1"
);

let params = {
    "id": "in",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "id": 2,
    "name": "Dermatologist"
}
```
> Example response (404):

```json
{
    "message": "Specialization not found"
}
```

### HTTP Request
`GET api/admin/specialization/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of record

<!-- END_61d9d2d442ab6775b100c99174308e53 -->

<!-- START_f3037fbd0b99431116c3be685ced15e0 -->
## Admin add specialization

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/admin/specialization" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"explicabo","image":"deserunt"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/specialization"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "explicabo",
    "image": "deserunt"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "Specialization added successfully"
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "name": [
            "The name has already been taken."
        ]
    }
}
```

### HTTP Request
`POST api/admin/specialization`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `name` | string |  required  | unique
        `image` | file |  optional  | nullable format-> jpg,jpeg,png max:2048
    
<!-- END_f3037fbd0b99431116c3be685ced15e0 -->

<!-- START_6c3ace1554b48e06eac8939c5ee192d2 -->
## Admin edit specialization by id

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/admin/specialization/1?id=similique" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"voluptas","image":"doloremque"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/specialization/1"
);

let params = {
    "id": "similique",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "voluptas",
    "image": "doloremque"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (404):

```json
{
    "message": "Specialization not found"
}
```
> Example response (200):

```json
{
    "message": "Specialization updated successfully"
}
```

### HTTP Request
`POST api/admin/specialization/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of record
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `name` | string |  required  | unique
        `image` | file |  optional  | nullable format-> jpg,jpeg,png max:2048
    
<!-- END_6c3ace1554b48e06eac8939c5ee192d2 -->

<!-- START_0ba99034cbf59ce2e5017573c918cb3d -->
## Admin delete specialization by id

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X DELETE \
    "http://localhost/fms-api-laravel/public/api/admin/specialization/1?id=quia" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/specialization/1"
);

let params = {
    "id": "quia",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (404):

```json
{
    "message": "Specialization not found"
}
```
> Example response (200):

```json
{
    "message": "Specialization deleted successfully"
}
```

### HTTP Request
`DELETE api/admin/specialization/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of record

<!-- END_0ba99034cbf59ce2e5017573c918cb3d -->

<!-- START_45b1fbfe7fde59d606ab32c0a1e07ee7 -->
## List UserCommissions

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/admin/user/commission?search=ut" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/user/commission"
);

let params = {
    "search": "ut",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "search": [
            "The search field must be present."
        ]
    }
}
```
> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 34,
            "unique_id": "CO0000033",
            "online": 0,
            "in_clinic": 0,
            "emergency": 0,
            "doctorinfo": {
                "user_id": 302,
                "doctor_unique_id": "D0000065",
                "doctor_profile_photo": null,
                "average_rating": null
            },
            "user": {
                "id": 302,
                "first_name": "Martin",
                "middle_name": null,
                "last_name": "KIng",
                "profile_photo_url": null
            }
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/admin\/user\/commission?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/admin\/user\/commission?page=1",
    "next_page_url": null,
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/admin\/user\/commission",
    "per_page": 10,
    "prev_page_url": null,
    "to": 1,
    "total": 1
}
```
> Example response (404):

```json
{
    "message": "No records found."
}
```

### HTTP Request
`GET api/admin/user/commission`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `search` |  optional  | nullable present

<!-- END_45b1fbfe7fde59d606ab32c0a1e07ee7 -->

<!-- START_d2c6566a82670c6b73d786106fed8c91 -->
## Get UserCommissions by id

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/admin/user/commission/1?id=est" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/user/commission/1"
);

let params = {
    "id": "est",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "id": 34,
    "unique_id": "CO0000033",
    "online": 0,
    "in_clinic": 0,
    "emergency": 0,
    "doctorinfo": {
        "user_id": 302,
        "doctor_unique_id": "D0000065",
        "doctor_profile_photo": null,
        "average_rating": null
    },
    "user": {
        "id": 302,
        "first_name": "Martin",
        "middle_name": null,
        "last_name": "KIng",
        "profile_photo_url": null
    }
}
```
> Example response (404):

```json
{
    "message": "UserCommissions not found."
}
```

### HTTP Request
`GET api/admin/user/commission/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of record

<!-- END_d2c6566a82670c6b73d786106fed8c91 -->

<!-- START_572ffe979df8b1462823ca19231da326 -->
## Edit UserCommissions by id

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/admin/user/commission" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"commission_id":"quasi","online":"omnis","in_clinic":"voluptatum","emergency":"error"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/user/commission"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "commission_id": "quasi",
    "online": "omnis",
    "in_clinic": "voluptatum",
    "emergency": "error"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (404):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "commission_id": [
            "The commission id field is required."
        ],
        "online": [
            "The online field is required."
        ],
        "in_clinic": [
            "The in clinic field is required."
        ],
        "emergency": [
            "The emergency field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "User Commissions updated successfully."
}
```

### HTTP Request
`POST api/admin/user/commission`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `commission_id` | id |  required  | 
        `online` | numeric |  required  | 
        `in_clinic` | numeric |  required  | 
        `emergency` | numeric |  required  | 
    
<!-- END_572ffe979df8b1462823ca19231da326 -->

<!-- START_b2e091cf4acc04fa664b5a606faa002c -->
## Admin get Tax by id

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/admin/tax/1?id=non" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/tax/1"
);

let params = {
    "id": "non",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "id": 1,
    "name": "GST",
    "percent": 9
}
```
> Example response (404):

```json
{
    "message": "Tax not found."
}
```

### HTTP Request
`GET api/admin/tax/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of record

<!-- END_b2e091cf4acc04fa664b5a606faa002c -->

<!-- START_60cbde547d759a0c543922c9144ee83b -->
## Admin add Tax

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/admin/tax" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"sint","percent":"velit"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/tax"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "sint",
    "percent": "velit"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "Tax added successfully."
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "name": [
            "The name field is required."
        ],
        "percent": [
            "The percent must be a number."
        ]
    }
}
```

### HTTP Request
`POST api/admin/tax`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `name` | string |  required  | unique
        `percent` | numeric |  required  | 
    
<!-- END_60cbde547d759a0c543922c9144ee83b -->

<!-- START_3e743bfcb29da44a61bc11cb36cc5179 -->
## Admin edit Tax by id

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/admin/tax/1?id=dolorum" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"aperiam","percent":"et"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/tax/1"
);

let params = {
    "id": "dolorum",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "aperiam",
    "percent": "et"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (404):

```json
{
    "message": "Tax not found."
}
```
> Example response (200):

```json
{
    "message": "Tax updated successfully."
}
```

### HTTP Request
`POST api/admin/tax/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of record
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `name` | string |  required  | unique
        `percent` | numeric |  required  | 
    
<!-- END_3e743bfcb29da44a61bc11cb36cc5179 -->

<!-- START_bb4452c720f0a6de974497f02ca25ba9 -->
## Admin delete Tax by id

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X DELETE \
    "http://localhost/fms-api-laravel/public/api/admin/tax/1?id=et" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/tax/1"
);

let params = {
    "id": "et",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (404):

```json
{
    "message": "Tax not found."
}
```
> Example response (200):

```json
{
    "message": "Tax deleted successfully."
}
```
> Example response (403):

```json
{
    "message": "Tax can't be deleted."
}
```

### HTTP Request
`DELETE api/admin/tax/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of record

<!-- END_bb4452c720f0a6de974497f02ca25ba9 -->

<!-- START_d13983a203213f46bad7a284a143d8c0 -->
## Admin edit Tax Service

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/admin/taxservice/1?id=commodi" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"id","taxes":["non"]}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/taxservice/1"
);

let params = {
    "id": "commodi",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "id",
    "taxes": [
        "non"
    ]
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "Tax service updated successfully"
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "name": [
            "The name field is required."
        ],
        "taxes": [
            "The taxes must be an array."
        ]
    }
}
```
> Example response (404):

```json
{
    "message": "Tax service not found"
}
```

### HTTP Request
`POST api/admin/taxservice/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of record
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `name` | string |  required  | unique
        `taxes` | array |  optional  | nullable
        `taxes.*` | id |  required  | id of tax
    
<!-- END_d13983a203213f46bad7a284a143d8c0 -->

<!-- START_0613740687e938eea12205b134423f32 -->
## Admin edit Commission

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/admin/taxservice/1/commission?id=est" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"commission":"et"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/taxservice/1/commission"
);

let params = {
    "id": "est",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "commission": "et"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "Commission updated successfully"
}
```
> Example response (404):

```json
{
    "message": "Tax service not found"
}
```

### HTTP Request
`POST api/admin/taxservice/{id}/commission`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of Tax Service id
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `commission` | numeric |  required  | 
    
<!-- END_0613740687e938eea12205b134423f32 -->

<!-- START_5bda90b1cb1bb2b366aebd8b47be8369 -->
## Admin list Roles

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/admin/list/roles" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/list/roles"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
[
    {
        "id": 2,
        "title": "Admin",
        "name": "admin",
        "unique_id": "RL02",
        "guard_name": "web"
    },
    {
        "id": 3,
        "title": "Patient",
        "name": "patient",
        "unique_id": "RL03",
        "guard_name": "web"
    }
]
```

### HTTP Request
`GET api/admin/list/roles`


<!-- END_5bda90b1cb1bb2b366aebd8b47be8369 -->

<!-- START_51b371955950f29a8d3e9e8b3bb0ba21 -->
## Admin list Employee

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/admin/list/employee?filter[active]=id&user_type=molestiae&report=rerum" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/list/employee"
);

let params = {
    "filter[active]": "id",
    "user_type": "molestiae",
    "report": "rerum",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 3,
            "unique_id": "EMP0000003",
            "father_first_name": "dad",
            "father_middle_name": "dad midle",
            "father_last_name": "dad last",
            "date_of_birth": "1995-10-10",
            "age": 25,
            "date_of_joining": "2020-10-10",
            "gender": "MALE",
            "user": {
                "id": 33,
                "first_name": "Employee",
                "middle_name": "middle",
                "last_name": "last",
                "email": "employee@logidots",
                "username": "Emp5f9c0972bf270",
                "country_code": "+91",
                "mobile_number": "9876543288",
                "user_type": "EMPLOYEE",
                "is_active": "0",
                "profile_photo_url": null,
                "approved_by": "Jon"
            },
            "address": [
                {
                    "id": 75,
                    "street_name": "Lane",
                    "city_village": "land",
                    "district": "CA",
                    "state": "KL",
                    "country": "IN",
                    "pincode": "654321",
                    "country_code": null,
                    "contact_number": null,
                    "latitude": null,
                    "longitude": null,
                    "clinic_name": null
                }
            ]
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/admin\/list\/employee?page=1",
    "from": 1,
    "last_page": 2,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/admin\/list\/employee?page=2",
    "next_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/admin\/list\/employee?page=2",
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/admin\/list\/employee",
    "per_page": 1,
    "prev_page_url": null,
    "to": 1,
    "total": 2
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "user_type": [
            "The selected user type is invalid."
        ]
    }
}
```
> Example response (404):

```json
{
    "message": "No records found."
}
```

### HTTP Request
`GET api/admin/list/employee`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `filter` |  optional  | nullable array filter[name]='text'
    `filter.active` |  optional  | nullable filter[active]=1,0,2
    `user_type` |  required  | user_type -> HEALTHASSOCIATE or EMPLOYEE
    `report` |  optional  | nullable send 1 to download as excel

<!-- END_51b371955950f29a8d3e9e8b3bb0ba21 -->

<!-- START_ec830bb743cff5e6379faa6a9ea967c6 -->
## Admin Confirm Doctor,Pharmacy,Laboratory,Health Associate Registration

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/admin/action/approveorreject?id=amet" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"user_id":2,"action":"quis","user_type":"soluta","comment":"provident"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/action/approveorreject"
);

let params = {
    "id": "amet",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "user_id": 2,
    "action": "quis",
    "user_type": "soluta",
    "comment": "provident"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "Confirmation mail sent successfully"
}
```
> Example response (404):

```json
{
    "message": "Pharmacy not found"
}
```
> Example response (403):

```json
{
    "message": "Confirmation mail already been sent"
}
```
> Example response (403):

```json
{
    "message": "Email is not verified."
}
```
> Example response (403):

```json
{
    "message": "Mobile number is not verified."
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "action": [
            "The selected action is invalid."
        ],
        "user_id": [
            "The selected user id is invalid."
        ],
        "user_type": [
            "The user type field is required."
        ]
    }
}
```

### HTTP Request
`POST api/admin/action/approveorreject`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of user
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `user_id` | integer |  required  | id of user
        `action` | string |  required  | any one of APPROVE , REJECT
        `user_type` | string |  required  | any one of PHARMACIST,LABORATORY,DOCTOR,HEALTHASSOCIATE
        `comment` | string |  optional  | nullable
    
<!-- END_ec830bb743cff5e6379faa6a9ea967c6 -->

<!-- START_27d10afc1e5927b0d5ade2eb1bc6832d -->
## Admin add employee - BasicInfo

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/admin/employee/basicinfo" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"first_name":"molestiae","middle_name":"qui","last_name":"consequuntur","father_first_name":"error","father_middle_name":"in","father_last_name":"perspiciatis","gender":"est","date_of_birth":"odit","age":11,"country_code":"sequi","mobile_number":"deleniti","email":"tempora","date_of_joining":"labore","role":["libero"]}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/employee/basicinfo"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "first_name": "molestiae",
    "middle_name": "qui",
    "last_name": "consequuntur",
    "father_first_name": "error",
    "father_middle_name": "in",
    "father_last_name": "perspiciatis",
    "gender": "est",
    "date_of_birth": "odit",
    "age": 11,
    "country_code": "sequi",
    "mobile_number": "deleniti",
    "email": "tempora",
    "date_of_joining": "labore",
    "role": [
        "libero"
    ]
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "first_name": [
            "The first name field is required."
        ],
        "last_name": [
            "The last name field is required."
        ],
        "father_first_name": [
            "The father first name field is required."
        ],
        "father_last_name": [
            "The father last name field is required."
        ],
        "gender": [
            "The gender field is required."
        ],
        "date_of_birth": [
            "The date of birth field is required."
        ],
        "age": [
            "The age field is required."
        ],
        "country_code": [
            "The country code field is required."
        ],
        "mobile_number": [
            "The mobile number field is required."
        ],
        "email": [
            "The email field is required."
        ],
        "role": [
            "The role must be a array."
        ]
    }
}
```
> Example response (200):

```json
{
    "user_id": 1
}
```
> Example response (422):

```json
{
    "message": "Something went wrong."
}
```

### HTTP Request
`POST api/admin/employee/basicinfo`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `first_name` | string |  required  | 
        `middle_name` | string |  optional  | nullable
        `last_name` | string |  required  | 
        `father_first_name` | string |  required  | 
        `father_middle_name` | string |  optional  | nullable
        `father_last_name` | string |  required  | 
        `gender` | string |  required  | any one of ['MALE', 'FEMALE', 'OTHERS']
        `date_of_birth` | string |  required  | format -> Y-m-d
        `age` | integer |  required  | 
        `country_code` | string |  required  | 
        `mobile_number` | string |  required  | 
        `email` | string |  required  | 
        `date_of_joining` | string |  optional  | nullable format -> Y-m-d
        `role` | array |  required  | 
        `role.*` | interger |  required  | id of role
    
<!-- END_27d10afc1e5927b0d5ade2eb1bc6832d -->

<!-- START_1f67d02a81e6982da52372de078b5e06 -->
## Admin edit employee BasicInfo

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/admin/employee/basicinfo/1?id=deserunt" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"first_name":"nam","middle_name":"qui","last_name":"rem","father_first_name":"distinctio","father_middle_name":"ratione","father_last_name":"fugiat","gender":"reprehenderit","date_of_birth":"excepturi","age":19,"country_code":"hic","mobile_number":"dolorem","email":"hic","date_of_joining":"vitae","role":["error"]}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/employee/basicinfo/1"
);

let params = {
    "id": "deserunt",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "first_name": "nam",
    "middle_name": "qui",
    "last_name": "rem",
    "father_first_name": "distinctio",
    "father_middle_name": "ratione",
    "father_last_name": "fugiat",
    "gender": "reprehenderit",
    "date_of_birth": "excepturi",
    "age": 19,
    "country_code": "hic",
    "mobile_number": "dolorem",
    "email": "hic",
    "date_of_joining": "vitae",
    "role": [
        "error"
    ]
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "first_name": [
            "The first name field is required."
        ],
        "last_name": [
            "The last name field is required."
        ],
        "father_first_name": [
            "The father first name field is required."
        ],
        "father_last_name": [
            "The father last name field is required."
        ],
        "gender": [
            "The gender field is required."
        ],
        "date_of_birth": [
            "The date of birth field is required."
        ],
        "age": [
            "The age field is required."
        ],
        "country_code": [
            "The country code field is required."
        ],
        "mobile_number": [
            "The mobile number field is required."
        ],
        "email": [
            "The email field is required."
        ],
        "role": [
            "The role must be a array."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Details saved successfully."
}
```

### HTTP Request
`POST api/admin/employee/basicinfo/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  optional  | integer required id in user object
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `first_name` | string |  required  | 
        `middle_name` | string |  optional  | nullable
        `last_name` | string |  required  | 
        `father_first_name` | string |  required  | 
        `father_middle_name` | string |  optional  | nullable
        `father_last_name` | string |  required  | 
        `gender` | string |  required  | any one of ['MALE', 'FEMALE', 'OTHERS']
        `date_of_birth` | string |  required  | format -> Y-m-d
        `age` | integer |  required  | 
        `country_code` | string |  required  | 
        `mobile_number` | string |  required  | 
        `email` | string |  required  | 
        `date_of_joining` | string |  optional  | nullable format -> Y-m-d
        `role` | array |  required  | 
        `role.*` | interger |  required  | id of role
    
<!-- END_1f67d02a81e6982da52372de078b5e06 -->

<!-- START_ec4107d8123e7d19ec097c8fd5deeb5f -->
## Admin add employee - Address

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/admin/employee/address" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"user_id":17,"pincode":19,"street_name":"autem","city_village":"voluptas","district":"id","state":"optio","country":"enim"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/employee/address"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "user_id": 17,
    "pincode": 19,
    "street_name": "autem",
    "city_village": "voluptas",
    "district": "id",
    "state": "optio",
    "country": "enim"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "user_id": [
            "The user id field is required."
        ],
        "pincode": [
            "The pincode field is required."
        ],
        "street_name": [
            "The street name field is required."
        ],
        "city_village": [
            "The city village field is required."
        ],
        "district": [
            "The district field is required."
        ],
        "state": [
            "The state field is required."
        ],
        "country": [
            "The country field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Address added successfully."
}
```
> Example response (403):

```json
{
    "message": "Employee not found."
}
```

### HTTP Request
`POST api/admin/employee/address`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `user_id` | integer |  required  | 
        `pincode` | integer |  required  | length 6
        `street_name` | string |  required  | Street Name/ House No./ Area
        `city_village` | string |  required  | City/Village
        `district` | string |  required  | 
        `state` | string |  required  | 
        `country` | string |  required  | 
    
<!-- END_ec4107d8123e7d19ec097c8fd5deeb5f -->

<!-- START_c016954e0acfaf5311ba738f30c13dd0 -->
## Admin edit employee - Address

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/admin/employee/address/1?id=adipisci" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"pincode":12,"street_name":"consectetur","city_village":"quos","district":"aut","state":"et","country":"vero"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/employee/address/1"
);

let params = {
    "id": "adipisci",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "pincode": 12,
    "street_name": "consectetur",
    "city_village": "quos",
    "district": "aut",
    "state": "et",
    "country": "vero"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "pincode": [
            "The pincode field is required."
        ],
        "street_name": [
            "The street name field is required."
        ],
        "city_village": [
            "The city village field is required."
        ],
        "district": [
            "The district field is required."
        ],
        "state": [
            "The state field is required."
        ],
        "country": [
            "The country field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Address updated successfully."
}
```
> Example response (403):

```json
{
    "message": "Employee not found."
}
```

### HTTP Request
`POST api/admin/employee/address/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  optional  | integer required id in user object
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `pincode` | integer |  required  | length 6
        `street_name` | string |  required  | Street Name/ House No./ Area
        `city_village` | string |  required  | City/Village
        `district` | string |  required  | 
        `state` | string |  required  | 
        `country` | string |  required  | 
    
<!-- END_c016954e0acfaf5311ba738f30c13dd0 -->

<!-- START_5afabff257d8396019330ad8a995877f -->
## Admin get employee details by id

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/admin/employee/1?id=maiores" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/employee/1"
);

let params = {
    "id": "maiores",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "id": 3,
    "unique_id": "EMP0000003",
    "father_first_name": "dad",
    "father_middle_name": "dad midle",
    "father_last_name": "dad last",
    "date_of_birth": "1995-10-10",
    "age": 25,
    "date_of_joining": "2020-10-10",
    "gender": "MALE",
    "user": {
        "id": 33,
        "first_name": "Employee",
        "middle_name": "middle",
        "last_name": "last",
        "email": "employee@logidots",
        "username": "Emp5f9c0972bf270",
        "country_code": "+91",
        "mobile_number": "9876543288",
        "user_type": "EMPLOYEE",
        "is_active": "0",
        "profile_photo_url": null
    },
    "address": [
        {
            "id": 75,
            "street_name": "Lane",
            "city_village": "land",
            "district": "CA",
            "state": "KL",
            "country": "IN",
            "pincode": "654321",
            "country_code": null,
            "contact_number": null,
            "latitude": null,
            "longitude": null,
            "clinic_name": null
        }
    ]
}
```
> Example response (404):

```json
{
    "message": "Employee not found."
}
```

### HTTP Request
`GET api/admin/employee/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  optional  | integer required id in user object

<!-- END_5afabff257d8396019330ad8a995877f -->

<!-- START_cf7a6fd3b0971b95e006b9458592e168 -->
## Admin deactivate employee

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X DELETE \
    "http://localhost/fms-api-laravel/public/api/admin/employee/1?id=porro" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/employee/1"
);

let params = {
    "id": "porro",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "Employee deactivated."
}
```
> Example response (404):

```json
{
    "message": "Employee not found."
}
```

### HTTP Request
`DELETE api/admin/employee/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  optional  | integer required id in user object

<!-- END_cf7a6fd3b0971b95e006b9458592e168 -->

<!-- START_2f78ffac7816ccf9db5b5c8e130e43da -->
## Admin add category

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/admin/category" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"parent_id":3,"name":"repellat","image":"consequuntur"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/category"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "parent_id": 3,
    "name": "repellat",
    "image": "consequuntur"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "Category added successfully."
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "parent_id": [
            "The selected parent id is invalid."
        ],
        "name": [
            "The name field is required."
        ]
    }
}
```

### HTTP Request
`POST api/admin/category`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `parent_id` | integer |  optional  | nullable id of category
        `name` | string |  required  | unique
        `image` | file |  optional  | nullable mimes:jpg,jpeg,png max:2mb
    
<!-- END_2f78ffac7816ccf9db5b5c8e130e43da -->

<!-- START_f5242ca4c2cdced271c907d6dcd86383 -->
## Admin edit Category by id

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/admin/category/1?id=laudantium" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"incidunt","image":"ut"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/category/1"
);

let params = {
    "id": "laudantium",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "incidunt",
    "image": "ut"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (404):

```json
{
    "message": "Category not found."
}
```
> Example response (200):

```json
{
    "message": "Category updated successfully."
}
```

### HTTP Request
`POST api/admin/category/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of record
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `name` | string |  required  | unique
        `image` | file |  optional  | nullable mimes:jpg,jpeg,png max:2mb
    
<!-- END_f5242ca4c2cdced271c907d6dcd86383 -->

<!-- START_ff903613c48c5599bb75a780751259c3 -->
## Admin delete Category by id

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X DELETE \
    "http://localhost/fms-api-laravel/public/api/admin/category/1?id=qui" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/category/1"
);

let params = {
    "id": "qui",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (403):

```json
{
    "message": "This category has several medicines. You must make sure this category is empty before deleting it."
}
```
> Example response (200):

```json
{
    "message": "Category deleted successfully."
}
```
> Example response (404):

```json
{
    "message": "Category not found."
}
```

### HTTP Request
`DELETE api/admin/category/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of record

<!-- END_ff903613c48c5599bb75a780751259c3 -->

<!-- START_5c2098eae210972a01c578e530d4c8ac -->
## Admin search Category by name

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/admin/category/search?name=qui" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/category/search"
);

let params = {
    "name": "qui",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "name": [
            "The name field is required."
        ]
    }
}
```
> Example response (200):

```json
[
    {
        "id": 1,
        "name": "Para"
    },
    {
        "id": 3,
        "name": "Dolo"
    }
]
```
> Example response (404):

```json
{
    "message": "Category not found."
}
```

### HTTP Request
`GET api/admin/category/search`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `name` |  required  | string

<!-- END_5c2098eae210972a01c578e530d4c8ac -->

<!-- START_c21bb613e0c40e5cadc5ac615ea19e05 -->
## Admin add Medicine

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/admin/medicine" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"category_id":15,"composition":"quia","weight":331436.880207521,"weight_unit":"dolores","name":"omnis","manufacturer":"voluptatem","medicine_type":"sit","drug_type":"ratione","currency_code":"sit","price_per_strip":3,"qty_per_strip":11,"rate_per_unit":9115.61747,"rx_required":false,"short_desc":"vel","long_desc":"aut","cart_desc":"totam","image":"minus"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/medicine"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "category_id": 15,
    "composition": "quia",
    "weight": 331436.880207521,
    "weight_unit": "dolores",
    "name": "omnis",
    "manufacturer": "voluptatem",
    "medicine_type": "sit",
    "drug_type": "ratione",
    "currency_code": "sit",
    "price_per_strip": 3,
    "qty_per_strip": 11,
    "rate_per_unit": 9115.61747,
    "rx_required": false,
    "short_desc": "vel",
    "long_desc": "aut",
    "cart_desc": "totam",
    "image": "minus"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "Medicine added successfully."
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "category_id": [
            "The category id field is required."
        ],
        "composition": [
            "The composition field is required."
        ],
        "weight": [
            "The weight field is required."
        ],
        "weight_unit": [
            "The weight unit field is required."
        ],
        "name": [
            "The name field is required."
        ],
        "manufacturer": [
            "The manufacturer field is required."
        ],
        "medicine_type": [
            "The medicine type field is required."
        ],
        "drug_type": [
            "The drug type field is required."
        ],
        "price_per_strip": [
            "The price per strip field is required."
        ],
        "qty_per_strip": [
            "The qty per strip field is required."
        ],
        "rate_per_unit": [
            "The rate per unit field is required."
        ],
        "rx_required": [
            "The rx required field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Medicine added successfully.."
}
```

### HTTP Request
`POST api/admin/medicine`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `category_id` | integer |  required  | id of category
        `composition` | string |  required  | 
        `weight` | float |  required  | 
        `weight_unit` | string |  required  | 
        `name` | string |  required  | unique
        `manufacturer` | string |  required  | 
        `medicine_type` | string |  required  | 
        `drug_type` | string |  required  | Generic/Branded
        `currency_code` | string |  required  | 
        `price_per_strip` | integer |  required  | 
        `qty_per_strip` | integer |  required  | 
        `rate_per_unit` | float |  required  | 
        `rx_required` | boolean |  required  | 0 or 1
        `short_desc` | string |  optional  | nullable
        `long_desc` | string |  optional  | nullable
        `cart_desc` | string |  optional  | nullable
        `image` | file |  optional  | nullable mimes:jpg,jpeg,png max:2mb
    
<!-- END_c21bb613e0c40e5cadc5ac615ea19e05 -->

<!-- START_9264235e0ac29ccd8bbf1749913406ca -->
## Admin list Medicine

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/admin/medicine?paginate=velit" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/medicine"
);

let params = {
    "paginate": "velit",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "category_id": 1,
            "sku": "MED0000001",
            "composition": "paracet",
            "weight": 0.5,
            "weight_unit": "mg",
            "name": "Dolo",
            "manufacturer": "Inc",
            "medicine_type": "Tablet",
            "drug_type": "Generic",
            "qty_per_strip": 10,
            "price_per_strip": 200,
            "rate_per_unit": 10,
            "rx_required": 1,
            "short_desc": "Take for fever",
            "long_desc": null,
            "cart_desc": null,
            "image_name": "tiger.jpg",
            "image_url": "http:\/\/localhost\/fms-api-laravel\/public\/storage\/uploads\/medicine\/1608041755tiger.jpg"
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/admin\/medicine?page=1",
    "from": 1,
    "last_page": 3,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/admin\/medicine?page=3",
    "next_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/admin\/medicine?page=2",
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/admin\/medicine",
    "per_page": 1,
    "prev_page_url": null,
    "to": 1,
    "total": 3
}
```
> Example response (200):

```json
[
    {
        "id": 1,
        "category_id": 1,
        "sku": "MED0000001",
        "composition": "paracet",
        "weight": 0.5,
        "weight_unit": "mg",
        "name": "Dolo",
        "manufacturer": "Inc",
        "medicine_type": "Tablet",
        "drug_type": "Generic",
        "qty_per_strip": 10,
        "price_per_strip": 200,
        "rate_per_unit": 10,
        "rx_required": 1,
        "short_desc": "Take for fever",
        "long_desc": null,
        "cart_desc": null,
        "image_name": "tiger.jpg",
        "image_url": "http:\/\/localhost\/fms-api-laravel\/public\/storage\/uploads\/medicine\/1608041755tiger.jpg"
    }
]
```
> Example response (404):

```json
{
    "message": "Medicine not found."
}
```

### HTTP Request
`GET api/admin/medicine`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `paginate` |  optional  | nullable integer nullable paginate = 0

<!-- END_9264235e0ac29ccd8bbf1749913406ca -->

<!-- START_716223ed0a1863bc3a27342304c8d63a -->
## Admin update Medicine

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/admin/medicine/1?id=quo" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"category_id":11,"composition":"perferendis","weight":92320,"weight_unit":"adipisci","name":"consequuntur","manufacturer":"itaque","medicine_type":"debitis","drug_type":"rerum","currency_code":"dolorem","price_per_strip":10,"qty_per_strip":3,"rate_per_unit":3856.888823,"rx_required":false,"short_desc":"aut","long_desc":"corporis","cart_desc":"et","image":"tempora"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/medicine/1"
);

let params = {
    "id": "quo",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "category_id": 11,
    "composition": "perferendis",
    "weight": 92320,
    "weight_unit": "adipisci",
    "name": "consequuntur",
    "manufacturer": "itaque",
    "medicine_type": "debitis",
    "drug_type": "rerum",
    "currency_code": "dolorem",
    "price_per_strip": 10,
    "qty_per_strip": 3,
    "rate_per_unit": 3856.888823,
    "rx_required": false,
    "short_desc": "aut",
    "long_desc": "corporis",
    "cart_desc": "et",
    "image": "tempora"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "category_id": [
            "The category id field is required."
        ],
        "composition": [
            "The composition field is required."
        ],
        "weight": [
            "The weight field is required."
        ],
        "weight_unit": [
            "The weight unit field is required."
        ],
        "name": [
            "The name field is required."
        ],
        "manufacturer": [
            "The manufacturer field is required."
        ],
        "medicine_type": [
            "The medicine type field is required."
        ],
        "drug_type": [
            "The drug type field is required."
        ],
        "price_per_strip": [
            "The price per strip field is required."
        ],
        "qty_per_strip": [
            "The qty per strip field is required."
        ],
        "rate_per_unit": [
            "The rate per unit field is required."
        ],
        "rx_required": [
            "The rx required field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Medicine updated successfully.."
}
```
> Example response (404):

```json
{
    "message": "Medicine not found."
}
```

### HTTP Request
`POST api/admin/medicine/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of record
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `category_id` | integer |  required  | id of category
        `composition` | string |  required  | 
        `weight` | float |  required  | 
        `weight_unit` | string |  required  | 
        `name` | string |  required  | unique
        `manufacturer` | string |  required  | 
        `medicine_type` | string |  required  | 
        `drug_type` | string |  required  | Generic/Branded
        `currency_code` | string |  required  | 
        `price_per_strip` | integer |  required  | 
        `qty_per_strip` | integer |  required  | 
        `rate_per_unit` | float |  required  | 
        `rx_required` | boolean |  required  | 0 or 1
        `short_desc` | string |  optional  | nullable
        `long_desc` | string |  optional  | nullable
        `cart_desc` | string |  optional  | nullable
        `image` | file |  optional  | nullable mimes:jpg,jpeg,png max:2mb
    
<!-- END_716223ed0a1863bc3a27342304c8d63a -->

<!-- START_f6f19c3b0e87e5f564f6703c74a2bc4d -->
## Admin delete Medicine by id

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X DELETE \
    "http://localhost/fms-api-laravel/public/api/admin/medicine/1?id=esse" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/medicine/1"
);

let params = {
    "id": "esse",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "Medicine deleted successfully."
}
```
> Example response (404):

```json
{
    "message": "Medicine not found."
}
```

### HTTP Request
`DELETE api/admin/medicine/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of record

<!-- END_f6f19c3b0e87e5f564f6703c74a2bc4d -->

<!-- START_a900d9245583ffaa3989b2d2e48856c2 -->
## Admin update PNS

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/administrator/appointments/updatepns" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"appointment_id":12332.8084509,"is_valid_pns":true,"is_refunded":false,"refund_amount":"maxime","admin_pns_comment":"perferendis"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/administrator/appointments/updatepns"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "appointment_id": 12332.8084509,
    "is_valid_pns": true,
    "is_refunded": false,
    "refund_amount": "maxime",
    "admin_pns_comment": "perferendis"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "appointment_id": [
            "The appointment id field is required."
        ],
        "is_valid_pns": [
            "The is valid pns field is required."
        ],
        "is_refunded": [
            "The is refunded field must be present."
        ],
        "refund_amount": [
            "The refund amount field must be present."
        ],
        "admin_pns_comment": [
            "The admin pns comment field must be present."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Appointment updated successfully."
}
```
> Example response (403):

```json
{
    "message": "PNS has been already updated."
}
```

### HTTP Request
`POST api/administrator/appointments/updatepns`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `appointment_id` | number |  required  | 
        `is_valid_pns` | boolean |  required  | send 0 or 1
        `is_refunded` | boolean |  optional  | present send 0 or 1
        `refund_amount` | amount |  optional  | present
        `admin_pns_comment` | string |  optional  | present
    
<!-- END_a900d9245583ffaa3989b2d2e48856c2 -->

#Admin Edit


<!-- START_5f84e0c5e6271f3a266104c5591f6735 -->
## Admin edit laboratory basicinfo

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/admin/laboratory/basicinfo/1?id=ad" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"laboratory_name":"sint","country_code":"totam","mobile_number":"enim","alt_mobile_number":"eum","alt_country_code":"similique","email":"ex","gstin":"itaque","lab_reg_number":"maiores","lab_issuing_authority":"in","lab_date_of_issue":"et","lab_valid_upto":"nostrum","lab_file":"omnis"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/laboratory/basicinfo/1"
);

let params = {
    "id": "ad",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "laboratory_name": "sint",
    "country_code": "totam",
    "mobile_number": "enim",
    "alt_mobile_number": "eum",
    "alt_country_code": "similique",
    "email": "ex",
    "gstin": "itaque",
    "lab_reg_number": "maiores",
    "lab_issuing_authority": "in",
    "lab_date_of_issue": "et",
    "lab_valid_upto": "nostrum",
    "lab_file": "omnis"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "id": [
            "The id field is required."
        ],
        "laboratory_name": [
            "The laboratory name field is required."
        ],
        "country_code": [
            "The country code field is required."
        ],
        "email": [
            "The email field is required."
        ],
        "mobile_number": [
            "The mobile number field is required."
        ],
        "gstin": [
            "GSTIN (Goods and Services Tax Identification Number) is required."
        ],
        "lab_reg_number": [
            "Laboratory Registraton number is required."
        ],
        "lab_issuing_authority": [
            "Laboratory Registraton Issuing Authority is required."
        ],
        "lab_date_of_issue": [
            "Laboratory Registraton date of issue is required."
        ],
        "lab_valid_upto": [
            "Laboratory Registraton valid upto is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "id": 1,
    "sample_collection": 1,
    "order_amount": "4.00",
    "currency_code": "INR",
    "address": {
        "id": 73,
        "street_name": "street",
        "city_village": "village",
        "district": "district",
        "state": "state",
        "country": "country",
        "pincode": "678555",
        "country_code": "+91",
        "contact_number": null,
        "latitude": "8.74122200",
        "longitude": "77.69462600",
        "clinic_name": null
    }
}
```
> Example response (404):

```json
{
    "message": "Laboratory not found"
}
```

### HTTP Request
`POST api/admin/laboratory/basicinfo/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of record
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `laboratory_name` | string |  required  | 
        `country_code` | string |  required  | 
        `mobile_number` | string |  required  | 
        `alt_mobile_number` | string |  optional  | nullable
        `alt_country_code` | string |  required  | when alt_mobile_number is present
        `email` | string |  required  | 
        `gstin` | string |  required  | 
        `lab_reg_number` | string |  required  | 
        `lab_issuing_authority` | string |  required  | 
        `lab_date_of_issue` | date |  required  | format:Y-m-d
        `lab_valid_upto` | date |  required  | format:Y-m-d
        `lab_file` | image |  optional  | nullable mime:jpg,jpeg,png size max 2mb
    
<!-- END_5f84e0c5e6271f3a266104c5591f6735 -->

<!-- START_f1fe3eb6dbfcb2f6c37869f551c407c7 -->
## Admin edit laboratory address

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/admin/laboratory/address/1?id=expedita" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"pincode":13,"street_name":"accusantium","city_village":"earum","district":"quos","state":"et","country":"esse","sample_collection":true,"order_amount":"perspiciatis","currency_code":"deleniti","latitude":526.83930361,"longitude":4679.2}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/laboratory/address/1"
);

let params = {
    "id": "expedita",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "pincode": 13,
    "street_name": "accusantium",
    "city_village": "earum",
    "district": "quos",
    "state": "et",
    "country": "esse",
    "sample_collection": true,
    "order_amount": "perspiciatis",
    "currency_code": "deleniti",
    "latitude": 526.83930361,
    "longitude": 4679.2
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "pincode": [
            "The pincode field is required."
        ],
        "street_name": [
            "The street name field is required."
        ],
        "city_village": [
            "The city village field is required."
        ],
        "district": [
            "The district field is required."
        ],
        "state": [
            "The state field is required."
        ],
        "country": [
            "The country field is required."
        ],
        "sample_collection": [
            "Sample collection from home field is required."
        ],
        "order_amount": [
            "Order amount is required when Sample collection from home field is yes."
        ],
        "latitude": [
            "The latitude field is required."
        ],
        "longitude": [
            "The longitude field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "id": 1,
    "row": [
        {
            "id": 1,
            "sample_collect": 1
        }
    ]
}
```
> Example response (404):

```json
{
    "message": "Laboratory not found"
}
```

### HTTP Request
`POST api/admin/laboratory/address/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of record
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `pincode` | integer |  required  | length 6
        `street_name` | string |  required  | Street Name/ House No./ Area
        `city_village` | string |  required  | City/Village
        `district` | string |  required  | 
        `state` | string |  required  | 
        `country` | string |  required  | 
        `sample_collection` | boolean |  required  | 0 or 1
        `order_amount` | decimal |  optional  | nullable required if home_delivery is filled
        `currency_code` | string |  required  | 
        `latitude` | float |  required  | 
        `longitude` | float |  required  | 
    
<!-- END_f1fe3eb6dbfcb2f6c37869f551c407c7 -->

<!-- START_ffefcb7d4e17feeeaec5fb6a23d05c34 -->
## Admin edit laboratory test list

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/admin/laboratory/testlist/1?id=dignissimos" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"row":[{"id":9,"sample_collect":true}]}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/laboratory/testlist/1"
);

let params = {
    "id": "dignissimos",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "row": [
        {
            "id": 9,
            "sample_collect": true
        }
    ]
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "data_id": [
            "The data id field is required."
        ],
        "row.0.id": [
            "The row.0.id field is required."
        ],
        "row.1.id": [
            "The row.1.id field is required."
        ],
        "row.0.sample_collect": [
            "The row.0.sample_collect field is required."
        ],
        "row.1.sample_collect": [
            "The row.1.sample_collect field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "id": 1,
    "bank_account_number": "BANK12345",
    "bank_account_holder": "BANKER",
    "bank_name": "BANK",
    "bank_city": "India",
    "bank_ifsc": "IFSC45098",
    "bank_account_type": "SAVINGS"
}
```
> Example response (404):

```json
{
    "message": "Laboratory not found"
}
```

### HTTP Request
`POST api/admin/laboratory/testlist/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of record
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `row` | array |  optional  | nullable
        `row[0][id]` | integer |  required  | id of LaboratoryTestList
        `row[0][sample_collect]` | boolean |  required  | 1 0r 0
    
<!-- END_ffefcb7d4e17feeeaec5fb6a23d05c34 -->

<!-- START_5c3862a75f76140e42cef81722c00669 -->
## Admin edit laboratory bank details

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/admin/laboratory/bankdetails/1?id=dolores" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"bank_account_number":"velit","bank_account_holder":"beatae","bank_name":"qui","bank_city":"placeat","bank_ifsc":"consequatur","bank_account_type":"dolores"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/laboratory/bankdetails/1"
);

let params = {
    "id": "dolores",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "bank_account_number": "velit",
    "bank_account_holder": "beatae",
    "bank_name": "qui",
    "bank_city": "placeat",
    "bank_ifsc": "consequatur",
    "bank_account_type": "dolores"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "bank_account_number": [
            "The bank account number field is required."
        ],
        "bank_account_holder": [
            "The bank account holder field is required."
        ],
        "bank_name": [
            "The bank name field is required."
        ],
        "bank_city": [
            "The bank city field is required."
        ],
        "bank_ifsc": [
            "The bank ifsc field is required."
        ],
        "bank_account_type": [
            "The bank account type field is required."
        ]
    }
}
```
> Example response (404):

```json
{
    "message": "Bank Account Details not found"
}
```
> Example response (200):

```json
{
    "message": "Bank Account Details updated successfully"
}
```

### HTTP Request
`POST api/admin/laboratory/bankdetails/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  optional  | integer required id of bank record from previous response
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `bank_account_number` | string |  required  | 
        `bank_account_holder` | string |  required  | 
        `bank_name` | string |  required  | 
        `bank_city` | string |  required  | 
        `bank_ifsc` | string |  required  | 
        `bank_account_type` | string |  required  | 
    
<!-- END_5c3862a75f76140e42cef81722c00669 -->

<!-- START_058cb3ce3a7a39f241b28c57df7a130e -->
## Admin edit pharmacy basicinfo

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/admin/pharmacy/basicinfo/1?id=eligendi" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"pharmacy_name":"nemo","country_code":"facere","mobile_number":"quae","email":"illum","gstin":"et","dl_number":"voluptatem","dl_issuing_authority":"eius","dl_date_of_issue":"maxime","dl_valid_upto":"quisquam","dl_file":"natus"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/pharmacy/basicinfo/1"
);

let params = {
    "id": "eligendi",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "pharmacy_name": "nemo",
    "country_code": "facere",
    "mobile_number": "quae",
    "email": "illum",
    "gstin": "et",
    "dl_number": "voluptatem",
    "dl_issuing_authority": "eius",
    "dl_date_of_issue": "maxime",
    "dl_valid_upto": "quisquam",
    "dl_file": "natus"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "pharmacy_name": [
            "The pharmacy name field is required."
        ],
        "country_code": [
            "The country code field is required."
        ],
        "gstin": [
            "GSTIN (Goods and Services Tax Identification Number) is required."
        ],
        "dl_number": [
            "Drug licence number is required."
        ],
        "dl_issuing_authority": [
            "Drug licence Issuing Authority is required."
        ],
        "dl_date_of_issue": [
            "Drug licence date of issue is required."
        ],
        "dl_valid_upto": [
            "Drug licence valid upto is required."
        ],
        "dl_file": [
            "Drug licence image file is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "id": 1,
    "home_delivery": 1,
    "order_amount": "4.00",
    "currency_code": "INR",
    "address": {
        "id": 73,
        "street_name": "street",
        "city_village": "village",
        "district": "district",
        "state": "state",
        "country": "country",
        "pincode": "678555",
        "country_code": "+91",
        "contact_number": null,
        "latitude": "8.74122200",
        "longitude": "77.69462600",
        "clinic_name": null
    }
}
```
> Example response (404):

```json
{
    "message": "Pharmacy not found"
}
```

### HTTP Request
`POST api/admin/pharmacy/basicinfo/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of record
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `pharmacy_name` | string |  required  | 
        `country_code` | string |  required  | 
        `mobile_number` | string |  required  | 
        `email` | string |  required  | 
        `gstin` | string |  required  | 
        `dl_number` | string |  required  | 
        `dl_issuing_authority` | string |  required  | 
        `dl_date_of_issue` | date |  required  | format:Y-m-d
        `dl_valid_upto` | date |  required  | format:Y-m-d
        `dl_file` | image |  optional  | nullable mime:jpg,jpeg,png size max 2mb
    
<!-- END_058cb3ce3a7a39f241b28c57df7a130e -->

<!-- START_52854a2ac9486d7cafe63852073268bc -->
## Admin edit pharmacy address

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/admin/pharmacy/address/1?id=consectetur" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"pincode":11,"street_name":"ducimus","city_village":"vel","district":"totam","state":"assumenda","country":"nemo","home_delivery":false,"order_amount":"dolores","currency_code":"enim","latitude":913124.80245429,"longitude":474987906.3412498}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/pharmacy/address/1"
);

let params = {
    "id": "consectetur",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "pincode": 11,
    "street_name": "ducimus",
    "city_village": "vel",
    "district": "totam",
    "state": "assumenda",
    "country": "nemo",
    "home_delivery": false,
    "order_amount": "dolores",
    "currency_code": "enim",
    "latitude": 913124.80245429,
    "longitude": 474987906.3412498
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "pincode": [
            "The pincode field is required."
        ],
        "street_name": [
            "The street name field is required."
        ],
        "city_village": [
            "The city village field is required."
        ],
        "district": [
            "The district field is required."
        ],
        "state": [
            "The state field is required."
        ],
        "country": [
            "The country field is required."
        ],
        "home_delivery": [
            "The home delivery field is required."
        ],
        "order_amount": [
            "The order amount is required when Home delivery field is yes."
        ],
        "latitude": [
            "The latitude field is required."
        ],
        "longitude": [
            "The longitude field is required."
        ]
    }
}
```
> Example response (404):

```json
{
    "message": "Pharmacy not found"
}
```
> Example response (200):

```json
{
    "id": 1,
    "pharmacy_details": {
        "pharmacist_name": "Hermann Bayer Jr.",
        "course": "Bsc",
        "pharmacist_reg_number": "PHAR1234",
        "issuing_authority": "GOVT",
        "alt_mobile_number": null,
        "alt_country_code": null,
        "reg_certificate": "http:\/\/localhost\/fms-api-laravel\/public\/storage",
        "reg_date": "2020-10-15",
        "reg_valid_upto": "2030-10-15"
    },
    "bank_details": {
        "id": 2,
        "bank_account_number": "BANK12345",
        "bank_account_holder": "BANKER",
        "bank_name": "BANK",
        "bank_city": "India",
        "bank_ifsc": "IFSC45098",
        "bank_account_type": "SAVINGS"
    }
}
```

### HTTP Request
`POST api/admin/pharmacy/address/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of record
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `pincode` | integer |  required  | length 6
        `street_name` | string |  required  | Street Name/ House No./ Area
        `city_village` | string |  required  | City/Village
        `district` | string |  required  | 
        `state` | string |  required  | 
        `country` | string |  required  | 
        `home_delivery` | boolean |  required  | 0 or 1
        `order_amount` | decimal |  optional  | nullable required if home_delivery is filled
        `currency_code` | string |  required  | 
        `latitude` | float |  required  | 
        `longitude` | float |  required  | 
    
<!-- END_52854a2ac9486d7cafe63852073268bc -->

<!-- START_2179467844346ba225a67d691353f8b3 -->
## Admin edit pharmacy Additional details

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/admin/pharmacy/additionaldetails/1?id=rerum" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"pharmacist_name":"ab","course":"necessitatibus","pharmacist_reg_number":"quia","issuing_authority":"esse","alt_mobile_number":"officiis","alt_country_code":"provident","reg_certificate":"aliquid","reg_date":"minus","reg_valid_upto":"asperiores","bank_account_number":"voluptatem","bank_account_holder":"non","bank_name":"pariatur","bank_city":"nihil","bank_ifsc":"vero","bank_account_type":"molestiae"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/pharmacy/additionaldetails/1"
);

let params = {
    "id": "rerum",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "pharmacist_name": "ab",
    "course": "necessitatibus",
    "pharmacist_reg_number": "quia",
    "issuing_authority": "esse",
    "alt_mobile_number": "officiis",
    "alt_country_code": "provident",
    "reg_certificate": "aliquid",
    "reg_date": "minus",
    "reg_valid_upto": "asperiores",
    "bank_account_number": "voluptatem",
    "bank_account_holder": "non",
    "bank_name": "pariatur",
    "bank_city": "nihil",
    "bank_ifsc": "vero",
    "bank_account_type": "molestiae"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "pharmacist_name": [
            "The pharmacist name field is required."
        ],
        "course": [
            "The course field is required."
        ],
        "pharmacist_reg_number": [
            "Pharmacist Registration Number is required."
        ],
        "issuing_authority": [
            "The issuing authority field is required."
        ],
        "alt_country_code": [
            "The alt country code field is required when alt mobile number is present."
        ],
        "reg_certificate": [
            "The reg certificate field is required."
        ],
        "reg_date": [
            "The reg date field is required."
        ],
        "reg_valid_upto": [
            "The reg valid upto field is required."
        ],
        "bank_account_number": [
            "The bank account number field is required."
        ],
        "bank_account_holder": [
            "The bank account holder field is required."
        ],
        "bank_name": [
            "The bank name field is required."
        ],
        "bank_city": [
            "The bank city field is required."
        ],
        "bank_ifsc": [
            "The bank ifsc field is required."
        ],
        "bank_account_type": [
            "The bank account type field is required."
        ]
    }
}
```
> Example response (404):

```json
{
    "message": "Pharmacy not found"
}
```
> Example response (200):

```json
{
    "message": "Pharmacy additional details saved successfully."
}
```

### HTTP Request
`POST api/admin/pharmacy/additionaldetails/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of record
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `pharmacist_name` | string |  required  | 
        `course` | string |  required  | 
        `pharmacist_reg_number` | string |  required  | 
        `issuing_authority` | string |  required  | 
        `alt_mobile_number` | string |  optional  | nullable
        `alt_country_code` | string |  required  | when alt_mobile_number is present
        `reg_certificate` | string |  required  | 
        `reg_date` | string |  required  | 
        `reg_valid_upto` | string |  required  | 
        `bank_account_number` | string |  required  | 
        `bank_account_holder` | string |  required  | 
        `bank_name` | string |  required  | 
        `bank_city` | string |  required  | 
        `bank_ifsc` | string |  required  | 
        `bank_account_type` | string |  required  | 
    
<!-- END_2179467844346ba225a67d691353f8b3 -->

<!-- START_6701e166fd751e37c9f3c58313c608b2 -->
## Admin get Doctor get profile

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/admin/doctor/profile/1?id=ea" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/doctor/profile/1"
);

let params = {
    "id": "ea",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```
> Example response (200):

```json
{
    "first_name": "Surgeon",
    "middle_name": "Heart",
    "last_name": "Heart surgery",
    "email": "theophilus@logidots.com",
    "country_code": "+91",
    "mobile_number": "+918940330536",
    "username": "theo",
    "gender": "MALE",
    "date_of_birth": "1993-06-19",
    "age": 4,
    "qualification": "BA",
    "specialization": [
        {
            "id": 1,
            "name": "Orthopedician"
        },
        {
            "id": 3,
            "name": "Pediatrician"
        },
        {
            "id": 5,
            "name": "General Surgeon"
        }
    ],
    "years_of_experience": "5",
    "alt_country_code": "+91",
    "alt_mobile_number": null,
    "clinic_name": null,
    "pincode": "627354",
    "street_name": "street",
    "city_village": "vill",
    "district": "district",
    "state": "KL",
    "country": "India",
    "specialization_list": [
        {
            "id": 1,
            "name": "Orthopedician"
        },
        {
            "id": 2,
            "name": "Dermatologist"
        },
        {
            "id": 3,
            "name": "Pediatrician"
        },
        {
            "id": 4,
            "name": "General Physician"
        }
    ]
}
```
> Example response (200):

```json
{
    "first_name": "theo",
    "middle_name": "theo",
    "last_name": "theo",
    "email": "theophilus@logidots.com",
    "country_code": "+91",
    "mobile_number": "+918940330536",
    "username": "user12345",
    "gender": "MALE",
    "date_of_birth": "1998-06-15",
    "age": 27,
    "qualification": "MD",
    "specialization": [],
    "years_of_experience": "5",
    "alt_country_code": "+91",
    "alt_mobile_number": null,
    "clinic_name": "GRACE",
    "pincode": "680001",
    "street_name": "street",
    "city_village": "VILLAGE",
    "district": "KL 15",
    "state": "KL",
    "country": "IN",
    "specialization_list": []
}
```

### HTTP Request
`GET api/admin/doctor/profile/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of doctor

<!-- END_6701e166fd751e37c9f3c58313c608b2 -->

<!-- START_c4a7a05e7de7bb16ba07b4b1ead635a8 -->
## Admin edit Doctor profile

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/admin/doctor/profile/1?id=rerum" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"first_name":"ipsum","middle_name":"nihil","last_name":"sit","gender":"beatae","date_of_birth":"eligendi","age":62591.928042,"qualification":"cupiditate","specialization":[],"years_of_experience":"veritatis","mobile_number":"sed","country_code":"quae","alt_mobile_number":"quo","alt_country_code":"exercitationem","email":"omnis","clinic_name":"minus","pincode":20,"street_name":"ut","city_village":"ut","district":"consequatur","state":"cumque","country":"eos"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/doctor/profile/1"
);

let params = {
    "id": "rerum",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "first_name": "ipsum",
    "middle_name": "nihil",
    "last_name": "sit",
    "gender": "beatae",
    "date_of_birth": "eligendi",
    "age": 62591.928042,
    "qualification": "cupiditate",
    "specialization": [],
    "years_of_experience": "veritatis",
    "mobile_number": "sed",
    "country_code": "quae",
    "alt_mobile_number": "quo",
    "alt_country_code": "exercitationem",
    "email": "omnis",
    "clinic_name": "minus",
    "pincode": 20,
    "street_name": "ut",
    "city_village": "ut",
    "district": "consequatur",
    "state": "cumque",
    "country": "eos"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "first_name": [
            "The first name field is required."
        ],
        "last_name": [
            "The last name field is required."
        ],
        "gender": [
            "The gender field is required."
        ],
        "date_of_birth": [
            "The date of birth field is required."
        ],
        "age": [
            "The age field is required."
        ],
        "qualification": [
            "The qualification field is required."
        ],
        "specialization": [
            "The specialization must be an array.."
        ],
        "mobile_number": [
            "The mobile number field is required."
        ],
        "email": [
            "The email field is required."
        ],
        "pincode": [
            "The pincode field is required."
        ],
        "street_name": [
            "The street name field is required."
        ],
        "city_village": [
            "The city village field is required."
        ],
        "district": [
            "The district field is required."
        ],
        "state": [
            "The state field is required."
        ],
        "country": [
            "The country field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Details saved successfully."
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```
> Example response (404):

```json
{
    "message": "Doctor not found."
}
```

### HTTP Request
`POST api/admin/doctor/profile/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of doctor
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `first_name` | string |  required  | 
        `middle_name` | string |  optional  | nullable
        `last_name` | string |  required  | 
        `gender` | string |  required  | 
        `date_of_birth` | string |  required  | 
        `age` | float |  required  | 
        `qualification` | string |  required  | 
        `specialization` | array |  required  | example specialization[0] = 1
        `years_of_experience` | string |  required  | 
        `mobile_number` | string |  required  | if edited verify using OTP
        `country_code` | string |  required  | if mobile_number is edited
        `alt_mobile_number` | string |  optional  | nullable
        `alt_country_code` | string |  optional  | nullable required if alt_mobile_number is filled
        `email` | string |  required  | if edited verify using OTP
        `clinic_name` | string |  optional  | nullable
        `pincode` | integer |  required  | length 6
        `street_name` | string |  required  | 
        `city_village` | string |  required  | 
        `district` | string |  required  | 
        `state` | string |  required  | 
        `country` | string |  required  | 
    
<!-- END_c4a7a05e7de7bb16ba07b4b1ead635a8 -->

<!-- START_a1237ecda36550d03a7b45aeb6e4a6ed -->
## Admin list doctor address

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/admin/doctor/address/1?id=commodi" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/doctor/address/1"
);

let params = {
    "id": "commodi",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "address_type": "CLINIC",
            "street_name": "street name",
            "city_village": "garden",
            "district": "idukki",
            "state": "kerala",
            "country": "India",
            "pincode": "680002",
            "country_code": "+91",
            "contact_number": "9876543210",
            "latitude": "13.06743900",
            "longitude": "80.23761700",
            "clinic_name": "Grace",
            "clinic_info": {
                "address_id": 1,
                "id": 2,
                "pharmacy_list": [
                    "1",
                    "2",
                    "3"
                ],
                "laboratory_id_1": []
            }
        },
        {
            "id": 3,
            "address_type": "CLINIC",
            "street_name": "address 2",
            "city_village": "garden",
            "district": "kollam",
            "state": "kerala",
            "country": "India",
            "pincode": "680002",
            "country_code": "+91",
            "contact_number": "9876543210",
            "latitude": "13.06743900",
            "longitude": "80.23761700",
            "clinic_name": "Grace",
            "clinic_info": {
                "address_id": 3,
                "id": 5,
                "pharmacy_list": [
                    "1",
                    "2",
                    "3"
                ],
                "laboratory_list": [
                    "1",
                    "2",
                    "3"
                ]
            }
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/doctor\/address?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/doctor\/address?page=1",
    "next_page_url": null,
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/doctor\/address",
    "per_page": 20,
    "prev_page_url": null,
    "to": 2,
    "total": 2
}
```
> Example response (404):

```json
{
    "message": "No records found."
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```
> Example response (404):

```json
{
    "message": "Doctor not found.."
}
```

### HTTP Request
`GET api/admin/doctor/address/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of doctor

<!-- END_a1237ecda36550d03a7b45aeb6e4a6ed -->

<!-- START_7f6d4fcab4d1ceb6c322b42e4cce9d9f -->
## Admin edit doctor address

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/admin/doctor/address/1?id=velit" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"clinic_name":"tenetur","pincode":12,"street_name":"in","city_village":"tempore","district":"deleniti","state":"et","country":"enim","contact_number":"quos","country_code":"consectetur","pharmacy_list":[],"laboratory_list":[],"latitude":219588.45,"longitude":1.124938061}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/doctor/address/1"
);

let params = {
    "id": "velit",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "clinic_name": "tenetur",
    "pincode": 12,
    "street_name": "in",
    "city_village": "tempore",
    "district": "deleniti",
    "state": "et",
    "country": "enim",
    "contact_number": "quos",
    "country_code": "consectetur",
    "pharmacy_list": [],
    "laboratory_list": [],
    "latitude": 219588.45,
    "longitude": 1.124938061
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "pincode": [
            "The pincode must be 6 digits."
        ],
        "clinic_name": [
            "The clinic name already exists."
        ],
        "street_name": [
            "The street name field is required."
        ],
        "city_village": [
            "The city village field is required."
        ],
        "district": [
            "The district field is required."
        ],
        "state": [
            "The state field is required."
        ],
        "country": [
            "The country field is required."
        ],
        "pharmacy_list": [
            "The pharmacy list must be an array."
        ],
        "laboratory_list": [
            "The laboratory list must be an array."
        ],
        "latitude": [
            "The latitude format is invalid."
        ],
        "longitude": [
            "The longitude format is invalid."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Address updated successfully."
}
```
> Example response (404):

```json
{
    "message": "Address not found."
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`POST api/admin/doctor/address/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of address
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `clinic_name` | string |  required  | 
        `pincode` | integer |  required  | length 6
        `street_name` | string |  required  | Street Name/ House No./ Area
        `city_village` | string |  required  | City/Village
        `district` | string |  required  | 
        `state` | string |  required  | 
        `country` | string |  required  | 
        `contact_number` | string |  optional  | nullable
        `country_code` | string |  optional  | nullable required if contact_number is filled
        `pharmacy_list` | array |  optional  | nullable pharmacy_list[0]=1,pharmacy_list[1]=2
        `laboratory_list` | array |  optional  | nullable laboratory_list[0]=1,laboratory_list[1]=2
        `latitude` | float |  required  | 
        `longitude` | float |  required  | 
    
<!-- END_7f6d4fcab4d1ceb6c322b42e4cce9d9f -->

<!-- START_55a1d97a04f4ec2393112638fcd980b4 -->
## Admin get Doctor Additional Information

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/admin/doctor/additionalinformation/1?id=ab" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/doctor/additionalinformation/1"
);

let params = {
    "id": "ab",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "career_profile": "Surgeon",
    "education_training": "Heart",
    "clinical_focus": "Heart surgery",
    "awards_achievements": null,
    "memberships": null,
    "experience": "5",
    "doctor_profile_photo": "http:\/\/localhost\/fms-api-laravel\/public\/storage\/uploads\/1\/1597232166-66392b02-8113-4961-ad0a-4ceaca84da1b.jpeg",
    "service": "INPATIENT",
    "appointment_type": "OFFLINE",
    "consulting_online_fee": null,
    "consulting_offline_fee": 675,
    "emergency_fee": 345,
    "emergency_appointment": 1,
    "no_of_followup": 3,
    "followups_after": 1,
    "cancel_time_period": 120,
    "reschedule_time_period": 48,
    "payout_period": 1,
    "registration_number": "REG-DEN-6894",
    "comment": "test comments",
    "currency_code": "USD"
}
```
> Example response (404):

```json
{
    "message": "Doctor additional information not found."
}
```

### HTTP Request
`GET api/admin/doctor/additionalinformation/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of doctor in user object

<!-- END_55a1d97a04f4ec2393112638fcd980b4 -->

<!-- START_6e6863aca75fc916074f6928f988d3bb -->
## Admin edit Doctor Additional Information

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/admin/doctor/additionalinformation/1?id=beatae" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"career_profile":"et","education_training":"reiciendis","clinical_focus":"ut","awards_achievements":"eum","memberships":"quis","experience":"qui","profile_photo":"a","service":"aut","appointment_type_online":false,"appointment_type_offline":false,"consulting_online_fee":"accusamus","consulting_offline_fee":"placeat","emergency_fee":1149.682884,"emergency_appointment":17,"no_of_followup":3,"followups_after":15,"cancel_time_period":9,"reschedule_time_period":5,"currency_code":"minima","payout_period":false,"registration_number":"laudantium"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/doctor/additionalinformation/1"
);

let params = {
    "id": "beatae",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "career_profile": "et",
    "education_training": "reiciendis",
    "clinical_focus": "ut",
    "awards_achievements": "eum",
    "memberships": "quis",
    "experience": "qui",
    "profile_photo": "a",
    "service": "aut",
    "appointment_type_online": false,
    "appointment_type_offline": false,
    "consulting_online_fee": "accusamus",
    "consulting_offline_fee": "placeat",
    "emergency_fee": 1149.682884,
    "emergency_appointment": 17,
    "no_of_followup": 3,
    "followups_after": 15,
    "cancel_time_period": 9,
    "reschedule_time_period": 5,
    "currency_code": "minima",
    "payout_period": false,
    "registration_number": "laudantium"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "career_profile": [
            "The career profile field is required."
        ],
        "education_training": [
            "The education training field is required."
        ],
        "service": [
            "The service field is required."
        ],
        "consulting_online_fee": [
            "The consulting online fee field is required when appointment type online is 1."
        ],
        "consulting_offline_fee": [
            "The consulting offline fee field is required when appointment type offline is 1."
        ],
        "no_of_followup": [
            "The number of followup field is required"
        ],
        "followups_after": [
            "The number of followup after field is required"
        ],
        "cancel_time_period": [
            "The cancel time period must be a number."
        ],
        "reschedule_time_period": [
            "The reschedule time period must be a number."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Details updated successfully."
}
```
> Example response (403):

```json
{
    "message": "Add Doctor profile details to continue."
}
```
> Example response (403):

```json
{
    "message": "Cancel Time Period is greater than Master Cancel Time Period."
}
```
> Example response (403):

```json
{
    "message": "Reschedule Time Period is greater than Master Reschedule Time Period."
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```
> Example response (404):

```json
{
    "message": "Doctor additional information not found."
}
```

### HTTP Request
`POST api/admin/doctor/additionalinformation/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of doctor in user object
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `career_profile` | string |  required  | 
        `education_training` | string |  required  | 
        `clinical_focus` | string |  required  | 
        `awards_achievements` | string |  optional  | nullable
        `memberships` | string |  optional  | nullable
        `experience` | string |  optional  | nullable
        `profile_photo` | image |  required  | required only if image is edited by user. image mime:jpg,jpeg,png size max 2mb
        `service` | string |  required  | anyone of ['INPATIENT', 'OUTPATIENT', 'BOTH']
        `appointment_type_online` | boolean |  optional  | nullable 0 or 1
        `appointment_type_offline` | boolean |  optional  | nullable 0 or 1
        `consulting_online_fee` | decimal |  optional  | The consulting online fee field is required when appointment type is 1.
        `consulting_offline_fee` | decimal |  optional  | The consulting offline fee field is required when appointment type is 1.
        `emergency_fee` | float |  optional  | nullable
        `emergency_appointment` | integer |  optional  | 
        `no_of_followup` | integer |  required  | values 1 to 10
        `followups_after` | integer |  required  | values 1 to 4
        `cancel_time_period` | integer |  optional  | nullable send 12 for 12 hours, 48 for 2 days
        `reschedule_time_period` | integer |  optional  | nullable send 12 for 12 hours, 48 for 2 days
        `currency_code` | stirng |  required  | 
        `payout_period` | boolean |  required  | 0 or 1
        `registration_number` | string |  required  | 
    
<!-- END_6e6863aca75fc916074f6928f988d3bb -->

<!-- START_fc3c3666c999a692e789c75d39c53126 -->
## Admin get Doctor bank details

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/admin/doctor/bankdetails/1?id=eos" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/doctor/bankdetails/1"
);

let params = {
    "id": "eos",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "id": 1,
    "bank_account_number": "BANK12345",
    "bank_account_holder": "BANKER",
    "bank_name": "BANK",
    "bank_city": "India",
    "bank_ifsc": "IFSC45098",
    "bank_account_type": "SAVINGS"
}
```
> Example response (404):

```json
{
    "message": "Doctor bank details not found."
}
```

### HTTP Request
`GET api/admin/doctor/bankdetails/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of doctor in user object

<!-- END_fc3c3666c999a692e789c75d39c53126 -->

<!-- START_8fc7c9561eaaccdc95ae6900b9dd87e0 -->
## Admin edit Doctor bank details

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/admin/doctor/bankdetails/1?id=nesciunt" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"bank_account_number":"dolores","bank_account_holder":"illo","bank_name":"voluptatem","bank_city":"libero","bank_ifsc":"veritatis","bank_account_type":"sed"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/doctor/bankdetails/1"
);

let params = {
    "id": "nesciunt",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "bank_account_number": "dolores",
    "bank_account_holder": "illo",
    "bank_name": "voluptatem",
    "bank_city": "libero",
    "bank_ifsc": "veritatis",
    "bank_account_type": "sed"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "bank_account_number": [
            "The bank account number field is required."
        ],
        "bank_account_holder": [
            "The bank account holder field is required."
        ],
        "bank_name": [
            "The bank name field is required."
        ],
        "bank_city": [
            "The bank city field is required."
        ],
        "bank_ifsc": [
            "The bank ifsc field is required."
        ],
        "bank_account_type": [
            "The bank account type field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Bank Account details saved successfully."
}
```
> Example response (404):

```json
{
    "message": "Doctor bank details not found."
}
```

### HTTP Request
`POST api/admin/doctor/bankdetails/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of bank record
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `bank_account_number` | string |  required  | 
        `bank_account_holder` | string |  required  | 
        `bank_name` | string |  required  | 
        `bank_city` | string |  required  | 
        `bank_ifsc` | string |  required  | 
        `bank_account_type` | string |  required  | 
    
<!-- END_8fc7c9561eaaccdc95ae6900b9dd87e0 -->

<!-- START_722323cc4a4c76516d979e2994728b87 -->
## Admin get patient profile details

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/admin/patient/profile/1?id=exercitationem" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/patient/profile/1"
);

let params = {
    "id": "exercitationem",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "title": "mr",
    "gender": "MALE",
    "date_of_birth": "1998-06-19",
    "age": 27,
    "blood_group": "B+ve",
    "height": null,
    "weight": null,
    "marital_status": null,
    "occupation": null,
    "alt_mobile_number": "8610025593",
    "first_name": "theo",
    "middle_name": "ben",
    "last_name": "phil",
    "email": "theophilus@logidots.com",
    "alt_country_code": "+91",
    "mobile_number": "8610025593",
    "country_code": "+91",
    "username": "user12345"
}
```
> Example response (404):

```json
{
    "message": "Details not found."
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/admin/patient/profile/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of patient in user object

<!-- END_722323cc4a4c76516d979e2994728b87 -->

<!-- START_9c083945572071929337100a97da8253 -->
## Admin edit patient profile details

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/admin/patient/profile/1?id=molestiae" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"title":"perspiciatis","first_name":"nam","middle_name":"corporis","last_name":"dolor","gender":"quaerat","date_of_birth":"ipsum","age":1.806,"blood_group":"consectetur","height":1.684,"weight":124.40906,"marital_status":"nisi","occupation":"eius","alt_mobile_number":"fugiat","alt_country_code":"accusantium","email":"est","mobile_number":"quos","country_code":"voluptas"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/patient/profile/1"
);

let params = {
    "id": "molestiae",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "title": "perspiciatis",
    "first_name": "nam",
    "middle_name": "corporis",
    "last_name": "dolor",
    "gender": "quaerat",
    "date_of_birth": "ipsum",
    "age": 1.806,
    "blood_group": "consectetur",
    "height": 1.684,
    "weight": 124.40906,
    "marital_status": "nisi",
    "occupation": "eius",
    "alt_mobile_number": "fugiat",
    "alt_country_code": "accusantium",
    "email": "est",
    "mobile_number": "quos",
    "country_code": "voluptas"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "title": [
            "The title field is required."
        ],
        "first_name": [
            "The first name field is required."
        ],
        "last_name": [
            "The last name field is required."
        ],
        "gender": [
            "The gender field is required."
        ],
        "date_of_birth": [
            "The date of birth field is required."
        ],
        "age": [
            "The age field is required."
        ],
        "blood_group": [
            "The blood group field is required."
        ],
        "height": [
            "The height field is required."
        ],
        "weight": [
            "The weight field is required."
        ],
        "marital_status": [
            "The marital status field is required."
        ],
        "occupation": [
            "The occupation field is required."
        ],
        "alt_mobile_number": [
            "The alt mobile number field is required."
        ],
        "email": [
            "The email field is required."
        ],
        "mobile_number": [
            "The mobile number field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Details saved successfully."
}
```

### HTTP Request
`POST api/admin/patient/profile/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of patient
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `title` | string |  required  | 
        `first_name` | string |  required  | 
        `middle_name` | string |  optional  | nullable
        `last_name` | string |  required  | 
        `gender` | string |  required  | any one of ['MALE', 'FEMALE', 'OTHERS']
        `date_of_birth` | date |  required  | format -> Y-m-d
        `age` | float |  required  | 
        `blood_group` | string |  optional  | nullable
        `height` | float |  optional  | nullable
        `weight` | float |  optional  | nullable
        `marital_status` | string |  optional  | nullable, if filled, any one of ['SINGLE', 'MARRIED', 'DIVORCED', 'WIDOWED']
        `occupation` | string |  optional  | nullable
        `alt_mobile_number` | string |  optional  | nullable
        `alt_country_code` | string |  optional  | nullable required if alt_mobile_number is filled
        `email` | email |  required  | 
        `mobile_number` | string |  required  | 
        `country_code` | string |  required  | 
    
<!-- END_9c083945572071929337100a97da8253 -->

<!-- START_2f6155ba4dbe4cf88d7f8279082d3df0 -->
## Admin list patient address

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/admin/patient/address/1?id=nesciunt" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/patient/address/1"
);

let params = {
    "id": "nesciunt",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "address_type": "WORK",
            "street_name": "Middle",
            "city_village": "lane",
            "district": "london",
            "state": "state",
            "country": "india",
            "pincode": "627354",
            "country_code": "+91",
            "contact_number": "987654321"
        },
        {
            "id": 2,
            "address_type": "WORK",
            "street_name": "Middle",
            "city_village": "lane",
            "district": "london",
            "state": "state",
            "country": "india",
            "pincode": "627354",
            "country_code": "+91",
            "contact_number": "987654321"
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/listaddress?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/listaddress?page=1",
    "next_page_url": null,
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/listaddress",
    "per_page": 20,
    "prev_page_url": null,
    "to": 2,
    "total": 2
}
```
> Example response (404):

```json
{
    "message": "No records found."
}
```
> Example response (404):

```json
{
    "message": "Patient not found."
}
```

### HTTP Request
`GET api/admin/patient/address/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of patient in user object

<!-- END_2f6155ba4dbe4cf88d7f8279082d3df0 -->

<!-- START_35d1e68d9c46dcb635ab907d9465ca24 -->
## Admin edit patient address

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/admin/patient/address/1?id=odit" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"pincode":"deserunt","street_name":"officiis","city_village":"ut","district":"alias","state":"excepturi","country":"sint","address_type":"praesentium","contact_number":"esse","country_code":"sunt","land_mark":"ad"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/patient/address/1"
);

let params = {
    "id": "odit",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "pincode": "deserunt",
    "street_name": "officiis",
    "city_village": "ut",
    "district": "alias",
    "state": "excepturi",
    "country": "sint",
    "address_type": "praesentium",
    "contact_number": "esse",
    "country_code": "sunt",
    "land_mark": "ad"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "pincode": [
            "The pincode field is required."
        ],
        "street_name": [
            "The street name field is required."
        ],
        "city_village": [
            "The city village field is required."
        ],
        "district": [
            "The district field is required."
        ],
        "state": [
            "The state field is required."
        ],
        "country": [
            "The country field is required."
        ],
        "address_type": [
            "The address type field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Address updated successfully."
}
```
> Example response (404):

```json
{
    "message": "Address not found."
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`POST api/admin/patient/address/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of address
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `pincode` | string |  required  | 
        `street_name` | string |  required  | Street Name/ House No./ Area
        `city_village` | string |  required  | City/Village
        `district` | string |  required  | 
        `state` | string |  required  | 
        `country` | string |  required  | 
        `address_type` | string |  required  | anyone of ['HOME', 'WORK', 'OTHERS']
        `contact_number` | string |  required  | 
        `country_code` | string |  required  | 
        `land_mark` | string |  required  | 
    
<!-- END_35d1e68d9c46dcb635ab907d9465ca24 -->

<!-- START_fbd42b5a4dafc7b432f515db84180bfa -->
## Admin edit list patient family member

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/admin/patient/family/1?id=in" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/patient/family/1"
);

let params = {
    "id": "in",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "patient_family_id": "P0000001F01",
            "title": "Mr",
            "first_name": "ben",
            "middle_name": "M",
            "last_name": "ten",
            "gender": "MALE",
            "date_of_birth": "1998-06-19",
            "age": 27,
            "height": 160,
            "weight": 90,
            "marital_status": "SINGLE",
            "occupation": "no work",
            "relationship": "SON",
            "country_code": null,
            "contact_number": null,
            "current_medication": "fever"
        },
        {
            "id": 2,
            "patient_family_id": "P0000001F12",
            "title": "Mr",
            "first_name": "ben",
            "middle_name": "M",
            "last_name": "ten",
            "gender": "MALE",
            "date_of_birth": "1998-06-19",
            "age": 27,
            "height": 160,
            "weight": 90,
            "marital_status": "SINGLE",
            "occupation": "no work",
            "relationship": "SON",
            "country_code": null,
            "contact_number": null,
            "current_medication": "fever"
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/family?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/family?page=1",
    "next_page_url": null,
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/family",
    "per_page": 20,
    "prev_page_url": null,
    "to": 5,
    "total": 5
}
```
> Example response (404):

```json
{
    "message": "Family members not found."
}
```
> Example response (404):

```json
{
    "message": "Patient not found."
}
```

### HTTP Request
`GET api/admin/patient/family/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of patient

<!-- END_fbd42b5a4dafc7b432f515db84180bfa -->

<!-- START_2813a8b82be0133eda75d864b7f36012 -->
## Admin edit patient family member

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/admin/patient/family/1?id=laudantium" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"title":"soluta","first_name":"quibusdam","middle_name":"velit","last_name":"tenetur","gender":"adipisci","date_of_birth":"et","age":0.311321,"height":143128907.68308136,"weight":3.97102,"marital_status":"sapiente","relationship":"et","occupation":"possimus","current_medication":"dicta","country_code":"nobis","contact_number":"sed","national_health_id":"placeat"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/patient/family/1"
);

let params = {
    "id": "laudantium",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "title": "soluta",
    "first_name": "quibusdam",
    "middle_name": "velit",
    "last_name": "tenetur",
    "gender": "adipisci",
    "date_of_birth": "et",
    "age": 0.311321,
    "height": 143128907.68308136,
    "weight": 3.97102,
    "marital_status": "sapiente",
    "relationship": "et",
    "occupation": "possimus",
    "current_medication": "dicta",
    "country_code": "nobis",
    "contact_number": "sed",
    "national_health_id": "placeat"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "title": [
            "The title field is required."
        ],
        "first_name": [
            "The first name field is required."
        ],
        "last_name": [
            "The last name field is required."
        ],
        "gender": [
            "The gender field is required."
        ],
        "date_of_birth": [
            "The date of birth field is required."
        ],
        "age": [
            "The age field is required."
        ],
        "relationship": [
            "The selected relationship is invalid."
        ]
    }
}
```
> Example response (404):

```json
{
    "message": "Family member not found."
}
```
> Example response (200):

```json
{
    "message": "Family member updated successfully."
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`POST api/admin/patient/family/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of record from family list
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `title` | string |  required  | 
        `first_name` | string |  required  | 
        `middle_name` | string |  optional  | nullable
        `last_name` | string |  required  | 
        `gender` | string |  required  | any one of ['MALE', 'FEMALE', 'OTHERS']
        `date_of_birth` | date |  required  | format -> Y-m-d
        `age` | float |  required  | 
        `height` | float |  optional  | nullable
        `weight` | float |  optional  | nullable
        `marital_status` | string |  optional  | nullable, if filled, any one of ['SINGLE', 'MARRIED', 'DIVORCED', 'WIDOWED']
        `relationship` | string |  required  | any one of ['FATHER', 'MOTHER', 'DAUGHTER', 'SON', 'HUSBAND', 'WIFE', 'GRANDFATHER', 'GRANDMOTHER','BROTHER', 'OTHERS']
        `occupation` | string |  optional  | nullable
        `current_medication` | string |  optional  | nullable
        `country_code` | string |  optional  | nullable
        `contact_number` | string |  optional  | nullable
        `national_health_id` | string |  optional  | nullable
    
<!-- END_2813a8b82be0133eda75d864b7f36012 -->

<!-- START_731ae42d5c91fb4f7d2f93e0283f601a -->
## Admin edit patient BPL info and Emergency contact details.

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/admin/patient/emergency/1?id=beatae" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"current_medication":"dicta","bpl_file_number":"non","bpl_file":"modi","first_name_primary":"recusandae","middle_name_primary":"tempora","last_name_primary":"cumque","mobile_number_primary":"est","country_code_primary":"porro","relationship_primary":"provident","first_name_secondary":"eius","middle_name_secondary":"provident","last_name_secondary":"qui","mobile_number_secondary":"quis","country_code_secondary":"cumque","relationship_secondary":"doloribus"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/patient/emergency/1"
);

let params = {
    "id": "beatae",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "current_medication": "dicta",
    "bpl_file_number": "non",
    "bpl_file": "modi",
    "first_name_primary": "recusandae",
    "middle_name_primary": "tempora",
    "last_name_primary": "cumque",
    "mobile_number_primary": "est",
    "country_code_primary": "porro",
    "relationship_primary": "provident",
    "first_name_secondary": "eius",
    "middle_name_secondary": "provident",
    "last_name_secondary": "qui",
    "mobile_number_secondary": "quis",
    "country_code_secondary": "cumque",
    "relationship_secondary": "doloribus"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "Details saved successfully."
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "bpl_file": [
            "The bpl file field is required when bpl file number is present."
        ],
        "first_name_primary": [
            "The first name primary field is required."
        ],
        "middle_name_primary": [
            "The middle name primary field is required."
        ],
        "last_name_primary": [
            "The last name primary field is required."
        ],
        "mobile_number_primary": [
            "The mobile number primary field is required."
        ],
        "relationship_primary": [
            "The selected relationship primary is invalid."
        ]
    }
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```
> Example response (404):

```json
{
    "message": "Patient not found."
}
```

### HTTP Request
`POST api/admin/patient/emergency/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of patient
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `current_medication` | string |  optional  | nullable
        `bpl_file_number` | string |  optional  | nullable
        `bpl_file` | string |  optional  | nullable if bpl_file_number is filled required File mime:pdf,jpg,jpeg,png size max 2mb
        `first_name_primary` | string |  required  | 
        `middle_name_primary` | string |  optional  | nullable
        `last_name_primary` | string |  required  | 
        `mobile_number_primary` | string |  required  | 
        `country_code_primary` | string |  required  | 
        `relationship_primary` | string |  required  | ['FATHER', 'MOTHER', 'DAUGHTER', 'SON', 'HUSBAND', 'WIFE', 'GRANDFATHER', 'GRANDMOTHER','', 'OTHERS']
        `first_name_secondary` | string |  optional  | nullable
        `middle_name_secondary` | string |  optional  | nullable
        `last_name_secondary` | string |  optional  | nullable
        `mobile_number_secondary` | string |  optional  | nullable
        `country_code_secondary` | string |  optional  | nullable if mobile_number_secondary is filled
        `relationship_secondary` | string |  optional  | nullable if filled, any one of ['FATHER', 'MOTHER', 'DAUGHTER', 'SON', 'HUSBAND', 'WIFE', 'GRANDFATHER', 'GRANDMOTHER','BROTHER', 'OTHERS']
    
<!-- END_731ae42d5c91fb4f7d2f93e0283f601a -->

<!-- START_669df5541d22788e2f29ce1c71ef18a0 -->
## Admin get Patient BPL info and Emergency contact details.

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/admin/patient/emergency/1?id=ipsa" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/patient/emergency/1"
);

let params = {
    "id": "ipsa",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "first_name_primary": "THEO",
    "middle_name_primary": "BEN",
    "last_name_primary": "PHIL",
    "country_code_primary": "+91",
    "mobile_number_primary": "+914867857682",
    "relationship_primary": "SON",
    "first_name_secondary": "",
    "middle_name_secondary": "",
    "last_name_secondary": "",
    "country_code_secondary": "+91",
    "mobile_number_secondary": "",
    "relationship_secondary": "",
    "current_medication": "No",
    "bpl_file_number": "123456",
    "bpl_file": "HLD- FMS_V1.pdf"
}
```
> Example response (404):

```json
{
    "message": "No records found."
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/admin/patient/emergency/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of patient

<!-- END_669df5541d22788e2f29ce1c71ef18a0 -->

<!-- START_cef4845cdbcf0e56f56f43dd078ad57b -->
## Admin get patient get BPL file to download

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/admin/patient/bplfile/1?id=dignissimos" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/patient/bplfile/1"
);

let params = {
    "id": "dignissimos",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "file": "file downloads directly"
}
```
> Example response (404):

```json
{
    "message": "File not found."
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/admin/patient/bplfile/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of patient

<!-- END_cef4845cdbcf0e56f56f43dd078ad57b -->

#Administrator


<!-- START_e37eb4d500ce28df12d33abec24853cb -->
## Admin, Employee list specialization

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/admin/specialization?paginate=vitae" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/specialization"
);

let params = {
    "paginate": "vitae",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "name": "Orthopedician",
            "image": "http:\/\/localhost\/fms-api-laravel\/public\/storage\/uploads\/specializations\/1625137134-34034151-f758-4743-827b-1d3fbee34063.jpg"
        },
        {
            "id": 2,
            "name": "Dermatologist",
            "image": "http:\/\/localhost\/fms-api-laravel\/public\/storage\/uploads\/specializations\/1625137134-34034151-f758-4743-827b-1d3fbee34063.jpg"
        },
        {
            "id": 3,
            "name": "Pediatrician",
            "image": "http:\/\/localhost\/fms-api-laravel\/public\/storage\/uploads\/specializations\/1625137134-34034151-f758-4743-827b-1d3fbee34063.jpg"
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/admin\/specialization?page=1",
    "from": 1,
    "last_page": 8,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/admin\/specialization?page=8",
    "next_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/admin\/specialization?page=2",
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/admin\/specialization",
    "per_page": 3,
    "prev_page_url": null,
    "to": 3,
    "total": 24
}
```
> Example response (404):

```json
{
    "message": "Specializations not found"
}
```

### HTTP Request
`GET api/admin/specialization`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `paginate` |  optional  | nullable integer nullable paginate = 0

<!-- END_e37eb4d500ce28df12d33abec24853cb -->

<!-- START_4dc70782d2be90bdf9d0083a12288702 -->
## Admin, Employee  list Doctor

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/administrator/list/doctor?filter=corrupti&report=autem" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/administrator/list/doctor"
);

let params = {
    "filter": "corrupti",
    "report": "autem",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "user_id": 2,
            "doctor_unique_id": "D0000001",
            "title": "Dr.",
            "gender": "MALE",
            "date_of_birth": "1993-06-19",
            "age": 4,
            "qualification": "BA",
            "years_of_experience": "5",
            "alt_country_code": "+91",
            "alt_mobile_number": null,
            "clinic_name": "GRACE",
            "career_profile": null,
            "education_training": null,
            "experience": null,
            "clinical_focus": null,
            "awards_achievements": null,
            "memberships": null,
            "appointment_type_online": null,
            "appointment_type_offline": null,
            "consulting_online_fee": 607,
            "consulting_offline_fee": 240,
            "emergency_fee": null,
            "emergency_appointment": null,
            "available_from_time": null,
            "available_to_time": null,
            "service": null,
            "no_of_followup": null,
            "followups_after": null,
            "cancel_time_period": 12,
            "reschedule_time_period": 24,
            "doctor_profile_photo": null,
            "user": {
                "id": 2,
                "first_name": "theo",
                "middle_name": "Heart",
                "last_name": "lineee",
                "email": "theophilus@logidots.com",
                "username": "theo",
                "country_code": "+91",
                "mobile_number": "8940330536",
                "user_type": "DOCTOR",
                "is_active": "1",
                "profile_photo_url": null
            },
            "address": [
                {
                    "id": 1,
                    "street_name": "North Road",
                    "city_village": "Nemmara",
                    "district": "Palakkad",
                    "state": "Kerala",
                    "country": "India",
                    "pincode": "627672",
                    "country_code": "+91",
                    "contact_number": null,
                    "latitude": "10.53034500",
                    "longitude": "76.21472900",
                    "clinic_name": "klein"
                },
                {
                    "id": 2,
                    "street_name": "South Road",
                    "city_village": "Edamattom",
                    "district": "Kottayam",
                    "state": "Kerala",
                    "country": "India",
                    "pincode": "686575",
                    "country_code": "+91",
                    "contact_number": null,
                    "latitude": "10.53034500",
                    "longitude": "76.21472900",
                    "clinic_name": "conroy"
                }
            ],
            "bank_account_details": [
                {
                    "id": 2,
                    "bank_account_number": "BANK12345",
                    "bank_account_holder": "BANKER",
                    "bank_name": "BANK",
                    "bank_city": "India",
                    "bank_ifsc": "IFSC45098",
                    "bank_account_type": "SAVINGS"
                }
            ]
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/admin\/list\/doctor?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/admin\/list\/doctor?page=1",
    "next_page_url": null,
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/admin\/list\/doctor",
    "per_page": 10,
    "prev_page_url": null,
    "to": 1,
    "total": 1
}
```
> Example response (404):

```json
{
    "message": "No records found."
}
```

### HTTP Request
`GET api/administrator/list/doctor`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `filter` |  optional  | nullable array filter[name]='text', filter[approved] any one of 0,1,2 filter[approved] = 0 for list to be approved, filter[approved] = 1 for approved list, filter[approved] = 2 for rejected list, filter[city]='text' for filter by city.
    `report` |  optional  | nullable send 1 to download as excel

<!-- END_4dc70782d2be90bdf9d0083a12288702 -->

<!-- START_4fc4040167f78c8a5518726343a6ec95 -->
## Admin, Employee list Pharmacy

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/administrator/list/pharmacy?filter=ad&paginate=unde&report=sint" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/administrator/list/pharmacy"
);

let params = {
    "filter": "ad",
    "paginate": "unde",
    "report": "sint",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
[
    {
        "id": 1,
        "pharmacy_name": "Pharmacy Name",
        "pharmacy_unique_id": "PHA0000001"
    },
    {
        "id": 2,
        "pharmacy_name": "Grace",
        "pharmacy_unique_id": "PHA0000002"
    }
]
```
> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "pharmacy_unique_id": "PHA0000001",
            "gstin": "GSTN49598E4",
            "dl_number": "LAB12345",
            "dl_issuing_authority": "AIMS",
            "dl_date_of_issue": "2020-10-15",
            "dl_valid_upto": "2030-10-15",
            "pharmacy_name": "Pharmacy Name",
            "pharmacist_name": "Prof. Tomas Ward MD",
            "course": "Bsc",
            "pharmacist_reg_number": "PHAR1234",
            "issuing_authority": "GOVT",
            "alt_mobile_number": null,
            "alt_country_code": null,
            "reg_date": "2020-10-15",
            "reg_valid_upto": "2030-10-15",
            "home_delivery": 0,
            "order_amount": "300.00",
            "dl_file": "http:\/\/localhost\/fms-api-laravel\/public\/storage",
            "reg_certificate": "http:\/\/localhost\/fms-api-laravel\/public\/storage",
            "user": {
                "id": 29,
                "first_name": "Alaina Hessel",
                "middle_name": "Burley Mertz",
                "last_name": "Prof. Tomas Ward MD",
                "email": "ziemann.dawn@example.com",
                "username": "isaac.abbott",
                "country_code": "+91",
                "mobile_number": "+1-496-551-6560",
                "user_type": "PHARMACIST",
                "is_active": "1",
                "profile_photo_url": null
            },
            "bank_account_details": [
                {
                    "id": 2,
                    "bank_account_number": "BANK12345",
                    "bank_account_holder": "BANKER",
                    "bank_name": "BANK",
                    "bank_city": "India",
                    "bank_ifsc": "IFSC45098",
                    "bank_account_type": "SAVINGS"
                }
            ],
            "address": [
                {
                    "id": 74,
                    "street_name": "East Road",
                    "city_village": "Edamon",
                    "district": "Kollam",
                    "state": "Kerala",
                    "country": "India",
                    "pincode": "691307",
                    "country_code": "+91",
                    "contact_number": null,
                    "latitude": "10.53034500",
                    "longitude": "76.21472900",
                    "clinic_name": null
                }
            ]
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/admin\/list\/pharmacy?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/admin\/list\/pharmacy?page=1",
    "next_page_url": null,
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/admin\/list\/pharmacy",
    "per_page": 10,
    "prev_page_url": null,
    "to": 1,
    "total": 1
}
```
> Example response (404):

```json
{
    "message": "No records found."
}
```

### HTTP Request
`GET api/administrator/list/pharmacy`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `filter` |  optional  | nullable array filter[name]='text' filter[approved] any one of 0,1,2 filter[approved] = 0 for list to be approved, filter[approved] = 1 for approved list, filter[approved] = 2 for rejected list, filter[city]='text' for filter by city.
    `paginate` |  optional  | nullable integer  paginate = 0
    `report` |  optional  | nullable send 1 to download as excel

<!-- END_4fc4040167f78c8a5518726343a6ec95 -->

<!-- START_24eadc7b8c04faf22d339795ec4c44d0 -->
## Admin, Employee list Laboratory

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/administrator/list/laboratory?filter=vel&paginate=unde&report=porro" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/administrator/list/laboratory"
);

let params = {
    "filter": "vel",
    "paginate": "unde",
    "report": "porro",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
[
    {
        "id": 1,
        "laboratory_unique_id": "LAB0000001",
        "laboratory_name": "theo"
    },
    {
        "id": 2,
        "laboratory_unique_id": "LAB0000002",
        "laboratory_name": "Grace"
    }
]
```
> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "laboratory_unique_id": "LAB0000001",
            "laboratory_name": "Laboratory Name",
            "alt_mobile_number": null,
            "alt_country_code": null,
            "gstin": "GSTN49598E4",
            "lab_reg_number": "LAB12345",
            "lab_issuing_authority": "AIMS",
            "lab_date_of_issue": "2020-10-15",
            "lab_valid_upto": "2030-10-15",
            "sample_collection": 0,
            "order_amount": null,
            "lab_tests": [
                {
                    "id": 1,
                    "sample_collect": 1
                }
            ],
            "lab_file": null,
            "user": {
                "id": 28,
                "first_name": "Garnett Kozey I",
                "middle_name": "Shyann Nienow",
                "last_name": "Monique Russel",
                "email": "runte.guadalupe@example.com",
                "username": "micaela66",
                "country_code": "+91",
                "mobile_number": "363.332.7484 x6886",
                "user_type": "LABORATORY",
                "is_active": "0",
                "profile_photo_url": null,
                "approved_by": "Jon"
            },
            "bank_account_details": [
                {
                    "id": 1,
                    "bank_account_number": "BANK12345",
                    "bank_account_holder": "BANKER",
                    "bank_name": "BANK",
                    "bank_city": "India",
                    "bank_ifsc": "IFSC45098",
                    "bank_account_type": "SAVINGS"
                }
            ],
            "address": [
                {
                    "id": 73,
                    "street_name": "East Road",
                    "city_village": "Edamon",
                    "district": "Kollam",
                    "state": "Kerala",
                    "country": "India",
                    "pincode": "691307",
                    "country_code": "+91",
                    "contact_number": null,
                    "latitude": "10.53034500",
                    "longitude": "76.21472900",
                    "clinic_name": null
                }
            ]
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/admin\/list\/laboratory?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/admin\/list\/laboratory?page=1",
    "next_page_url": null,
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/admin\/list\/laboratory",
    "per_page": 10,
    "prev_page_url": null,
    "to": 1,
    "total": 1
}
```
> Example response (404):

```json
{
    "message": "No records found."
}
```

### HTTP Request
`GET api/administrator/list/laboratory`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `filter` |  optional  | nullable array filter[name]='text' filter[approved] any one of 0,1,2 filter[approved] = 0 for list to be approved, filter[approved] = 1 for approved list, filter[approved] = 2 for rejected list
    `paginate` |  optional  | nullable integer paginate = 0
    `report` |  optional  | nullable send 1 to download as excel

<!-- END_24eadc7b8c04faf22d339795ec4c44d0 -->

<!-- START_9076dc428c1d671e3c2fa29dff707e67 -->
## Admin, Employee  list Patients

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/administrator/list/patient?filter=natus&report=dolore" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/administrator/list/patient"
);

let params = {
    "filter": "natus",
    "report": "dolore",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "user_id": 3,
            "patient_unique_id": "P0000001",
            "title": null,
            "gender": null,
            "date_of_birth": null,
            "age": null,
            "blood_group": null,
            "height": null,
            "weight": null,
            "marital_status": null,
            "occupation": null,
            "alt_country_code": null,
            "alt_mobile_number": null,
            "current_medication": null,
            "bpl_file_number": null,
            "bpl_file_name": null,
            "national_health_id": null,
            "patient_profile_photo": null,
            "user": {
                "id": 3,
                "first_name": "Test",
                "middle_name": null,
                "last_name": "Patient",
                "email": "patient@logidots.com",
                "username": "patient",
                "country_code": "+91",
                "mobile_number": "9876543210",
                "user_type": "PATIENT",
                "is_active": "1",
                "profile_photo_url": null,
                "approved_by": "Jon"
            },
            "address": [
                {
                    "id": 1,
                    "street_name": "North Road",
                    "city_village": "BBB",
                    "district": "Palakkad",
                    "state": "Kerala",
                    "country": "India",
                    "pincode": "627672",
                    "country_code": null,
                    "contact_number": null,
                    "latitude": "10.53034500",
                    "longitude": "76.21472900",
                    "clinic_name": "quigley"
                }
            ]
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/administrator\/list\/patient?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/administrator\/list\/patient?page=1",
    "next_page_url": null,
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/administrator\/list\/patient",
    "per_page": 10,
    "prev_page_url": null,
    "to": 1,
    "total": 1
}
```
> Example response (404):

```json
{
    "message": "No records found."
}
```

### HTTP Request
`GET api/administrator/list/patient`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `filter` |  optional  | nullable array filter[name]='text', filter[approved] any one of 0,1,2 filter[approved] = 0 for list to be approved, filter[approved] = 1 for approved list, filter[approved] = 2 for rejected list, filter[city]='text' for filter by city.
    `report` |  optional  | nullable send 1 to download as excel

<!-- END_9076dc428c1d671e3c2fa29dff707e67 -->

<!-- START_7cdfe2cad7d5eab7b7db954dbddca88f -->
## Admin list Appointments

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/administrator/list/appointments?start_date=adipisci&end_date=exercitationem&doctor_id=nobis&status=repellendus&consultation_type=libero&start_fee=aspernatur&end_fee=dolorum&followup=qui&search=voluptates&report=quas" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/administrator/list/appointments"
);

let params = {
    "start_date": "adipisci",
    "end_date": "exercitationem",
    "doctor_id": "nobis",
    "status": "repellendus",
    "consultation_type": "libero",
    "start_fee": "aspernatur",
    "end_fee": "dolorum",
    "followup": "qui",
    "search": "voluptates",
    "report": "quas",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "start_date": [
            "The start date field must be present."
        ],
        "end_date": [
            "The end date field must be present."
        ],
        "doctor_id": [
            "The doctor id field must be present."
        ],
        "status": [
            "The status field must be present."
        ],
        "consultation_type": [
            "The consultation type field must be present."
        ],
        "start_fee": [
            "The start fee field must be present."
        ],
        "followup": [
            "The followup field must be present."
        ],
        "search": [
            "The search field must be present."
        ]
    }
}
```
> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 1410,
            "doctor_id": 25,
            "patient_id": 22,
            "appointment_unique_id": "AP0001410",
            "date": "2021-06-08",
            "time": null,
            "consultation_type": "EMERGENCY",
            "shift": "NIGHT",
            "payment_status": "Paid",
            "total": 571.93,
            "tax": 0,
            "is_cancelled": 0,
            "is_completed": 1,
            "followup_id": null,
            "followup_date": null,
            "cancel_time": 2,
            "reschedule_time": 2,
            "comment": null,
            "cancelled_by": null,
            "reschedule_by": null,
            "booking_date": "2021-06-08",
            "current_patient_info": {
                "user": {
                    "first_name": "Vishnu",
                    "middle_name": "S",
                    "last_name": "Sharma",
                    "email": "vishnusharmatest123@yopmail.com",
                    "country_code": "+91",
                    "mobile_number": "3736556464",
                    "profile_photo_url": null
                },
                "case": 0,
                "info": {
                    "first_name": "Manoj",
                    "middle_name": null,
                    "last_name": "Tiwari",
                    "email": "vishnusharmatest123@yopmail.com",
                    "country_code": "in",
                    "mobile_number": "8888888882",
                    "height": null,
                    "weight": null,
                    "gender": null,
                    "age": null
                },
                "address": {
                    "id": 22,
                    "street_name": "ABC street 66",
                    "city_village": "new villagehdhdh",
                    "district": "Thiruvananthapuram",
                    "state": "Kerala",
                    "country": "India",
                    "pincode": "695017",
                    "country_code": null,
                    "contact_number": "6644883737",
                    "land_mark": "Near temple lane",
                    "latitude": null,
                    "longitude": null,
                    "clinic_name": null
                }
            },
            "doctor": {
                "id": 25,
                "first_name": "Ravi",
                "middle_name": null,
                "last_name": "Tharakan",
                "email": "ravi.tharakantest@yopmail.com",
                "username": "RAVI",
                "country_code": "+91",
                "mobile_number": "7835516447",
                "user_type": "DOCTOR",
                "is_active": "1",
                "role": [
                    4
                ],
                "currency_code": "INR",
                "approved_date": "2021-03-08",
                "comment": null,
                "profile_photo_url": null
            },
            "prescription": {
                "id": 504,
                "appointment_id": 1410,
                "pdf_url": null,
                "status_medicine": "Requested"
            }
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/administrator\/list\/appointments?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/administrator\/list\/appointments?page=1",
    "next_page_url": null,
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/administrator\/list\/appointments",
    "per_page": 10,
    "prev_page_url": null,
    "to": 1,
    "total": 1
}
```
> Example response (404):

```json
{
    "message": "No records found."
}
```

### HTTP Request
`GET api/administrator/list/appointments`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `start_date` |  optional  | nullable date present format-> Y-m-d
    `end_date` |  optional  | nullable date present format-> Y-m-d
    `doctor_id` |  optional  | nullable present id of doctor
    `status` |  optional  | nullable present PNS, Not completed, Completed
    `consultation_type` |  optional  | nullable present INCLINIC,ONLINE,EMERGENCY
    `start_fee` |  optional  | nullable present
    `end_fee` |  optional  | nullable present
    `followup` |  optional  | nullable present FREE,PAID
    `search` |  optional  | nullable present
    `report` |  optional  | nullable present send 1

<!-- END_7cdfe2cad7d5eab7b7db954dbddca88f -->

<!-- START_aab34ddb7312a8f92ec2c74912b441ee -->
## Administrator add Patient

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/administrator/patient" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"title":"molestias","first_name":"ipsum","middle_name":"quas","last_name":"porro","gender":"dicta","date_of_birth":"occaecati","age":539229.95982051,"blood_group":"alias","height":583180909.31434,"weight":53022.9869,"marital_status":"fugiat","occupation":"vero","email":"eligendi","mobile_number":"sit","country_code":"illo","profile_photo":"omnis","alt_mobile_number":"cum","alt_country_code":"quia","pincode":"aliquam","street_name":"corporis","city_village":"architecto","district":"fuga","state":"est","country":"ab","address_type":"fugiat","current_medication":"deserunt","bpl_file_number":"molestiae","bpl_file":"voluptatem","first_name_primary":"aut","middle_name_primary":"sunt","last_name_primary":"assumenda","mobile_number_primary":"suscipit","country_code_primary":"quo","relationship_primary":"et","first_name_secondary":"ea","middle_name_secondary":"error","last_name_secondary":"aut","mobile_number_secondary":"ex","country_code_secondary":"reprehenderit","relationship_secondary":"soluta"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/administrator/patient"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "title": "molestias",
    "first_name": "ipsum",
    "middle_name": "quas",
    "last_name": "porro",
    "gender": "dicta",
    "date_of_birth": "occaecati",
    "age": 539229.95982051,
    "blood_group": "alias",
    "height": 583180909.31434,
    "weight": 53022.9869,
    "marital_status": "fugiat",
    "occupation": "vero",
    "email": "eligendi",
    "mobile_number": "sit",
    "country_code": "illo",
    "profile_photo": "omnis",
    "alt_mobile_number": "cum",
    "alt_country_code": "quia",
    "pincode": "aliquam",
    "street_name": "corporis",
    "city_village": "architecto",
    "district": "fuga",
    "state": "est",
    "country": "ab",
    "address_type": "fugiat",
    "current_medication": "deserunt",
    "bpl_file_number": "molestiae",
    "bpl_file": "voluptatem",
    "first_name_primary": "aut",
    "middle_name_primary": "sunt",
    "last_name_primary": "assumenda",
    "mobile_number_primary": "suscipit",
    "country_code_primary": "quo",
    "relationship_primary": "et",
    "first_name_secondary": "ea",
    "middle_name_secondary": "error",
    "last_name_secondary": "aut",
    "mobile_number_secondary": "ex",
    "country_code_secondary": "reprehenderit",
    "relationship_secondary": "soluta"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "title": [
            "The title field is required."
        ],
        "first_name": [
            "The first name field is required."
        ],
        "last_name": [
            "The last name field is required."
        ],
        "gender": [
            "The gender field is required."
        ],
        "date_of_birth": [
            "The date of birth field is required."
        ],
        "age": [
            "The age field is required."
        ],
        "blood_group": [
            "The blood group field is required."
        ],
        "height": [
            "The height field is required."
        ],
        "weight": [
            "The weight field is required."
        ],
        "marital_status": [
            "The marital status field is required."
        ],
        "occupation": [
            "The occupation field is required."
        ],
        "alt_mobile_number": [
            "The alt mobile number field is required."
        ],
        "email": [
            "The email field is required."
        ],
        "mobile_number": [
            "The mobile number field is required."
        ]
    }
}
```
> Example response (422):

```json
{
    "message": "Something went wrong."
}
```
> Example response (200):

```json
{
    "message": "Patient added successfully."
}
```

### HTTP Request
`POST api/administrator/patient`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `title` | string |  required  | 
        `first_name` | string |  required  | 
        `middle_name` | string |  optional  | nullable
        `last_name` | string |  required  | 
        `gender` | string |  required  | any one of ['MALE', 'FEMALE', 'OTHERS']
        `date_of_birth` | date |  required  | format -> Y-m-d
        `age` | float |  required  | 
        `blood_group` | string |  optional  | nullable
        `height` | float |  optional  | nullable
        `weight` | float |  optional  | nullable
        `marital_status` | string |  optional  | nullable, if filled, any one of ['SINGLE', 'MARRIED', 'DIVORCED', 'WIDOWED']
        `occupation` | string |  optional  | nullable
        `email` | email |  required  | 
        `mobile_number` | string |  required  | 
        `country_code` | string |  required  | 
        `profile_photo` | file |  optional  | nullable File mime:jpg,jpeg,png size max 2mb
        `alt_mobile_number` | string |  optional  | nullable
        `alt_country_code` | string |  optional  | nullable required if alt_mobile_number is filled
        `pincode` | string |  optional  | nullable if filled strictly validate in frontend
        `street_name` | string |  optional  | nullable Street Name/ House No./ Area if filled strictly validate in frontend
        `city_village` | string |  optional  | nullable City/Village if filled strictly validate in frontend
        `district` | string |  optional  | nullable if filled strictly validate in frontend
        `state` | string |  optional  | nullable if filled strictly validate in frontend
        `country` | string |  optional  | nullable if filled strictly validate in frontend
        `address_type` | string |  required  | anyone of ['HOME', 'WORK', 'OTHERS'] strictly validate in frontend
        `current_medication` | string |  optional  | nullable
        `bpl_file_number` | string |  optional  | nullable
        `bpl_file` | string |  optional  | nullable if bpl_file_number is filled required File mime:pdf,jpg,jpeg,png size max 2mb
        `first_name_primary` | string |  optional  | nullable if filled strictly validate in frontend
        `middle_name_primary` | string |  optional  | nullable
        `last_name_primary` | string |  optional  | nullable if filled strictly validate in frontend
        `mobile_number_primary` | string |  optional  | nullable if filled strictly validate in frontend
        `country_code_primary` | string |  optional  | nullable if filled strictly validate in frontend
        `relationship_primary` | string |  optional  | nullable any one of['FATHER', 'MOTHER', 'DAUGHTER', 'SON', 'HUSBAND', 'WIFE', 'GRANDFATHER', 'GRANDMOTHER','BROTHER', 'OTHERS'] nullable if filled strictly validate in frontend
        `first_name_secondary` | string |  optional  | nullable
        `middle_name_secondary` | string |  optional  | nullable
        `last_name_secondary` | string |  optional  | nullable
        `mobile_number_secondary` | string |  optional  | nullable
        `country_code_secondary` | string |  optional  | nullable if mobile_number_secondary is filled
        `relationship_secondary` | string |  optional  | nullable if filled, any one of ['FATHER', 'MOTHER', 'DAUGHTER', 'SON', 'HUSBAND', 'WIFE', 'GRANDFATHER','BROTHER', 'GRANDMOTHER', 'OTHERS']
    
<!-- END_aab34ddb7312a8f92ec2c74912b441ee -->

<!-- START_a2901f48c61d36a50c370c83d57d7a7d -->
## Administrator add Doctor

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/administrator/doctor" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"first_name":"labore","middle_name":"omnis","last_name":"saepe","gender":"libero","date_of_birth":"unde","age":1042.11531755,"qualification":"quis","specialization":[],"years_of_experience":"ipsam","mobile_number":"omnis","country_code":"et","alt_mobile_number":"ipsa","alt_country_code":"fugit","email":"doloribus","clinic_name":"doloremque","pincode":6,"street_name":"blanditiis","city_village":"non","district":"totam","state":"amet","country":"deleniti","address":[{"clinic_name":"dolorem","pincode":2,"street_name":"voluptatem","city_village":"omnis","district":"a","state":"molestiae","country":"libero","contact_number":"et","country_code":"rem","pharmacy_list":[5],"laboratory_list":[7],"latitude":225349134.0729,"longitude":342140961}],"career_profile":"ratione","education_training":"qui","clinical_focus":"corrupti","awards_achievements":"atque","memberships":"ullam","experience":"perferendis","profile_photo":"molestiae","service":"reiciendis","appointment_type_online":false,"appointment_type_offline":false,"currency_code":"ducimus","consulting_online_fee":"consequuntur","consulting_offline_fee":"a","emergency_fee":72755713.4259652,"emergency_appointment":19,"no_of_followup":5,"followups_after":8,"cancel_time_period":20,"reschedule_time_period":20,"bank_account_number":"porro","bank_account_holder":"quis","bank_name":"quibusdam","bank_city":"officiis","bank_ifsc":"in","bank_account_type":"omnis"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/administrator/doctor"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "first_name": "labore",
    "middle_name": "omnis",
    "last_name": "saepe",
    "gender": "libero",
    "date_of_birth": "unde",
    "age": 1042.11531755,
    "qualification": "quis",
    "specialization": [],
    "years_of_experience": "ipsam",
    "mobile_number": "omnis",
    "country_code": "et",
    "alt_mobile_number": "ipsa",
    "alt_country_code": "fugit",
    "email": "doloribus",
    "clinic_name": "doloremque",
    "pincode": 6,
    "street_name": "blanditiis",
    "city_village": "non",
    "district": "totam",
    "state": "amet",
    "country": "deleniti",
    "address": [
        {
            "clinic_name": "dolorem",
            "pincode": 2,
            "street_name": "voluptatem",
            "city_village": "omnis",
            "district": "a",
            "state": "molestiae",
            "country": "libero",
            "contact_number": "et",
            "country_code": "rem",
            "pharmacy_list": [
                5
            ],
            "laboratory_list": [
                7
            ],
            "latitude": 225349134.0729,
            "longitude": 342140961
        }
    ],
    "career_profile": "ratione",
    "education_training": "qui",
    "clinical_focus": "corrupti",
    "awards_achievements": "atque",
    "memberships": "ullam",
    "experience": "perferendis",
    "profile_photo": "molestiae",
    "service": "reiciendis",
    "appointment_type_online": false,
    "appointment_type_offline": false,
    "currency_code": "ducimus",
    "consulting_online_fee": "consequuntur",
    "consulting_offline_fee": "a",
    "emergency_fee": 72755713.4259652,
    "emergency_appointment": 19,
    "no_of_followup": 5,
    "followups_after": 8,
    "cancel_time_period": 20,
    "reschedule_time_period": 20,
    "bank_account_number": "porro",
    "bank_account_holder": "quis",
    "bank_name": "quibusdam",
    "bank_city": "officiis",
    "bank_ifsc": "in",
    "bank_account_type": "omnis"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "Something went wrong."
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "first_name": [
            "The first name field is required."
        ],
        "last_name": [
            "The last name field is required."
        ],
        "gender": [
            "The gender field is required."
        ],
        "date_of_birth": [
            "The date of birth field is required."
        ],
        "age": [
            "The age field is required."
        ],
        "mobile_number": [
            "The mobile number field is required."
        ],
        "email": [
            "The email field is required."
        ],
        "service": [
            "The selected service is invalid."
        ],
        "no_of_followup": [
            "The number of followup field is required"
        ],
        "followups_after": [
            "The number of followup after field is required"
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Doctor added successfully."
}
```

### HTTP Request
`POST api/administrator/doctor`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `first_name` | string |  required  | 
        `middle_name` | string |  optional  | nullable
        `last_name` | string |  required  | 
        `gender` | string |  required  | any one of ['MALE', 'FEMALE', 'OTHERS']
        `date_of_birth` | string |  required  | format -> Y-m-d
        `age` | float |  required  | 
        `qualification` | string |  required  | 
        `specialization` | array |  required  | example specialization[0] = 1
        `years_of_experience` | string |  required  | 
        `mobile_number` | string |  required  | if edited verify using OTP
        `country_code` | string |  required  | if mobile_number is edited
        `alt_mobile_number` | string |  optional  | nullable
        `alt_country_code` | string |  optional  | nullable required if alt_mobile_number is filled
        `email` | string |  required  | if edited verify using OTP
        `clinic_name` | string |  optional  | nullable
        `pincode` | integer |  optional  | nullable length 6
        `street_name` | string |  optional  | nullable
        `city_village` | string |  optional  | nullable
        `district` | string |  optional  | nullable
        `state` | string |  optional  | nullable
        `country` | string |  optional  | nullable
        `address` | array |  required  | 
        `address.*.clinic_name` | string |  required  | 
        `address.*.pincode` | integer |  required  | length 6
        `address.*.street_name` | string |  required  | Street Name/ House No./ Area
        `address.*.city_village` | string |  required  | City/Village
        `address.*.district` | string |  required  | 
        `address.*.state` | string |  required  | 
        `address.*.country` | string |  required  | 
        `address.*.contact_number` | string |  optional  | nullable
        `address.*.country_code` | string |  optional  | nullable required if contact_number is filled
        `address.*.pharmacy_list` | array |  optional  | nullable
        `address.*.pharmacy_list.*` | integer |  required  | unique id of pharmacy
        `address.*.laboratory_list` | array |  optional  | nullable
        `address.*.laboratory_list.*` | integer |  required  | unique id of laboratory
        `address.*.latitude` | float |  required  | 
        `address.*.longitude` | float |  required  | 
        `career_profile` | string |  required  | 
        `education_training` | string |  required  | 
        `clinical_focus` | string |  required  | 
        `awards_achievements` | string |  optional  | nullable
        `memberships` | string |  optional  | nullable
        `experience` | string |  optional  | nullable
        `profile_photo` | image |  required  | required only if image is edited by user. image mime:jpg,jpeg,png size max 2mb
        `service` | string |  required  | anyone of ['INPATIENT', 'OUTPATIENT', 'BOTH']
        `appointment_type_online` | boolean |  optional  | nullable 0 or 1
        `appointment_type_offline` | boolean |  optional  | nullable 0 or 1
        `currency_code` | stirng |  required  | 
        `consulting_online_fee` | decimal |  optional  | The consulting online fee field is required when appointment type is 1.
        `consulting_offline_fee` | decimal |  optional  | The consulting offline fee field is required when appointment type is 1.
        `emergency_fee` | float |  optional  | nullable
        `emergency_appointment` | integer |  optional  | 
        `no_of_followup` | integer |  required  | values 1 to 10
        `followups_after` | integer |  required  | values 1 to 4
        `cancel_time_period` | integer |  optional  | nullable send 12 for 12 hours, 48 for 2 days
        `reschedule_time_period` | integer |  optional  | nullable send 12 for 12 hours, 48 for 2 days
        `bank_account_number` | string |  optional  | nullable
        `bank_account_holder` | string |  optional  | nullable required with bank_account_number
        `bank_name` | string |  optional  | nullable required with bank_account_number
        `bank_city` | string |  optional  | nullable required with bank_account_number
        `bank_ifsc` | string |  optional  | nullable required with bank_account_number
        `bank_account_type` | string |  optional  | nullable required with bank_account_number
    
<!-- END_a2901f48c61d36a50c370c83d57d7a7d -->

<!-- START_20bd00ac99045ca35f3db658f117df65 -->
## Administrator add Pharmacy

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/administrator/pharmacy" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"pharmacy_name":"rerum","country_code":"vero","mobile_number":"atque","email":"eaque","gstin":"velit","dl_number":"tempora","dl_issuing_authority":"vero","dl_date_of_issue":"autem","dl_valid_upto":"aut","dl_file":"dolores","pincode":5,"street_name":"labore","city_village":"consequatur","district":"quo","state":"inventore","country":"dolores","home_delivery":true,"order_amount":"nemo","currency_code":"velit","latitude":11223.463575,"longitude":6.04,"pharmacist_name":"tempora","course":"consequuntur","pharmacist_reg_number":"sit","issuing_authority":"rerum","alt_mobile_number":"aut","alt_country_code":"suscipit","reg_certificate":"accusantium","reg_date":"sint","reg_valid_upto":"debitis","bank_account_number":"expedita","bank_account_holder":"labore","bank_name":"doloremque","bank_city":"dolores","bank_ifsc":"dolores","bank_account_type":"occaecati"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/administrator/pharmacy"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "pharmacy_name": "rerum",
    "country_code": "vero",
    "mobile_number": "atque",
    "email": "eaque",
    "gstin": "velit",
    "dl_number": "tempora",
    "dl_issuing_authority": "vero",
    "dl_date_of_issue": "autem",
    "dl_valid_upto": "aut",
    "dl_file": "dolores",
    "pincode": 5,
    "street_name": "labore",
    "city_village": "consequatur",
    "district": "quo",
    "state": "inventore",
    "country": "dolores",
    "home_delivery": true,
    "order_amount": "nemo",
    "currency_code": "velit",
    "latitude": 11223.463575,
    "longitude": 6.04,
    "pharmacist_name": "tempora",
    "course": "consequuntur",
    "pharmacist_reg_number": "sit",
    "issuing_authority": "rerum",
    "alt_mobile_number": "aut",
    "alt_country_code": "suscipit",
    "reg_certificate": "accusantium",
    "reg_date": "sint",
    "reg_valid_upto": "debitis",
    "bank_account_number": "expedita",
    "bank_account_holder": "labore",
    "bank_name": "doloremque",
    "bank_city": "dolores",
    "bank_ifsc": "dolores",
    "bank_account_type": "occaecati"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "Something went wrong."
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "pharmacy_name": [
            "The pharmacy name field is required."
        ],
        "country_code": [
            "The country code field is required."
        ],
        "mobile_number": [
            "The mobile number field is required."
        ],
        "email": [
            "The email field is required."
        ],
        "gstin": [
            "GSTIN (Goods and Services Tax Identification Number) is required."
        ],
        "dl_number": [
            "Drug licence number is required."
        ],
        "dl_issuing_authority": [
            "Drug licence Issuing Authority is required."
        ],
        "dl_date_of_issue": [
            "Drug licence date of issue is required."
        ],
        "dl_valid_upto": [
            "Drug licence valid upto is required."
        ],
        "pincode": [
            "The pincode field is required."
        ],
        "street_name": [
            "The street name field is required."
        ],
        "city_village": [
            "The city village field is required."
        ],
        "district": [
            "The district field is required."
        ],
        "state": [
            "The state field is required."
        ],
        "country": [
            "The country field is required."
        ],
        "home_delivery": [
            "The home delivery field is required."
        ],
        "latitude": [
            "The latitude field is required."
        ],
        "longitude": [
            "The longitude field is required."
        ],
        "pharmacist_name": [
            "The pharmacist name field is required."
        ],
        "course": [
            "The course field is required."
        ],
        "pharmacist_reg_number": [
            "Pharmacist Registration Number is required."
        ],
        "issuing_authority": [
            "The issuing authority field is required."
        ],
        "reg_date": [
            "Registration date field is required."
        ],
        "reg_valid_upto": [
            "Registration valid up to is required."
        ],
        "bank_account_number": [
            "The bank account number field is required."
        ],
        "bank_account_holder": [
            "The bank account holder field is required."
        ],
        "bank_name": [
            "The bank name field is required."
        ],
        "bank_city": [
            "The bank city field is required."
        ],
        "bank_ifsc": [
            "The bank ifsc field is required."
        ],
        "bank_account_type": [
            "The bank account type field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Pharmacy added successfully."
}
```

### HTTP Request
`POST api/administrator/pharmacy`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `pharmacy_name` | string |  required  | 
        `country_code` | string |  required  | 
        `mobile_number` | string |  required  | 
        `email` | string |  required  | 
        `gstin` | string |  required  | 
        `dl_number` | string |  required  | 
        `dl_issuing_authority` | string |  required  | 
        `dl_date_of_issue` | date |  required  | format:Y-m-d
        `dl_valid_upto` | date |  required  | format:Y-m-d
        `dl_file` | file |  required  | mime:jpg,jpeg,png size max 2mb
        `pincode` | integer |  required  | length 6
        `street_name` | string |  required  | Street Name/ House No./ Area
        `city_village` | string |  required  | City/Village
        `district` | string |  required  | 
        `state` | string |  required  | 
        `country` | string |  required  | 
        `home_delivery` | boolean |  required  | 0 or 1
        `order_amount` | decimal |  optional  | nullable required if home_delivery is filled
        `currency_code` | stirng |  required  | 
        `latitude` | float |  required  | 
        `longitude` | float |  required  | 
        `pharmacist_name` | string |  required  | 
        `course` | string |  required  | 
        `pharmacist_reg_number` | string |  required  | 
        `issuing_authority` | string |  required  | 
        `alt_mobile_number` | string |  optional  | nullable
        `alt_country_code` | string |  required  | when alt_mobile_number is present
        `reg_certificate` | file |  required  | mime:jpg,jpeg,png size max 2mb
        `reg_date` | string |  required  | 
        `reg_valid_upto` | file |  required  | 
        `bank_account_number` | string |  optional  | nullable
        `bank_account_holder` | string |  optional  | nullable required with bank_account_number
        `bank_name` | string |  optional  | nullable required with bank_account_number
        `bank_city` | string |  optional  | nullable required with bank_account_number
        `bank_ifsc` | string |  optional  | nullable required with bank_account_number
        `bank_account_type` | string |  optional  | nullable required with bank_account_number
    
<!-- END_20bd00ac99045ca35f3db658f117df65 -->

<!-- START_5d4e95dcf2215f0c002b14b14cb51c2d -->
## Administrator add Laboratory

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/administrator/laboratory" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"laboratory_name":"consequatur","country_code":"impedit","mobile_number":"aut","email":"sit","alt_mobile_number":"atque","alt_country_code":"repellendus","gstin":"doloremque","lab_reg_number":"quibusdam","lab_issuing_authority":"est","lab_date_of_issue":"perspiciatis","lab_valid_upto":"enim","lab_file":"ipsa","row":[{"id":14,"sample_collect":true}],"pincode":17,"street_name":"veniam","city_village":"possimus","district":"similique","state":"dolores","country":"eos","sample_collection":true,"order_amount":"soluta","currency_code":"quo","latitude":2325029.444172,"longitude":11.91,"bank_account_number":"ex","bank_account_holder":"voluptates","bank_name":"et","bank_city":"sit","bank_ifsc":"laborum","bank_account_type":"facere"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/administrator/laboratory"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "laboratory_name": "consequatur",
    "country_code": "impedit",
    "mobile_number": "aut",
    "email": "sit",
    "alt_mobile_number": "atque",
    "alt_country_code": "repellendus",
    "gstin": "doloremque",
    "lab_reg_number": "quibusdam",
    "lab_issuing_authority": "est",
    "lab_date_of_issue": "perspiciatis",
    "lab_valid_upto": "enim",
    "lab_file": "ipsa",
    "row": [
        {
            "id": 14,
            "sample_collect": true
        }
    ],
    "pincode": 17,
    "street_name": "veniam",
    "city_village": "possimus",
    "district": "similique",
    "state": "dolores",
    "country": "eos",
    "sample_collection": true,
    "order_amount": "soluta",
    "currency_code": "quo",
    "latitude": 2325029.444172,
    "longitude": 11.91,
    "bank_account_number": "ex",
    "bank_account_holder": "voluptates",
    "bank_name": "et",
    "bank_city": "sit",
    "bank_ifsc": "laborum",
    "bank_account_type": "facere"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "Something went wrong."
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "laboratory_name": [
            "The laboratory name field is required."
        ],
        "country_code": [
            "The country code field is required."
        ],
        "mobile_number": [
            "The mobile number field is required."
        ],
        "email": [
            "The email field is required."
        ],
        "gstin": [
            "The gstin field is required."
        ],
        "lab_reg_number": [
            "The lab reg number field is required."
        ],
        "lab_issuing_authority": [
            "The lab issuing authority field is required."
        ],
        "lab_date_of_issue": [
            "The lab date of issue field is required."
        ],
        "lab_valid_upto": [
            "The lab valid upto field is required."
        ],
        "lab_file": [
            "The lab file field is required."
        ],
        "pincode": [
            "The pincode field is required."
        ],
        "street_name": [
            "The street name field is required."
        ],
        "city_village": [
            "The city village field is required."
        ],
        "district": [
            "The district field is required."
        ],
        "state": [
            "The state field is required."
        ],
        "country": [
            "The country field is required."
        ],
        "sample_collection": [
            "The sample collection field is required."
        ],
        "latitude": [
            "The latitude field is required."
        ],
        "longitude": [
            "The longitude field is required."
        ],
        "data_id": [
            "The data id field is required."
        ],
        "row": [
            "The row field is required."
        ],
        "bank_account_number": [
            "The bank account number field is required."
        ],
        "bank_account_holder": [
            "The bank account holder field is required."
        ],
        "bank_name": [
            "The bank name field is required."
        ],
        "bank_city": [
            "The bank city field is required."
        ],
        "bank_ifsc": [
            "The bank ifsc field is required."
        ],
        "bank_account_type": [
            "The bank account type field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Laboratory added successfully."
}
```

### HTTP Request
`POST api/administrator/laboratory`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `laboratory_name` | string |  required  | 
        `country_code` | string |  required  | 
        `mobile_number` | string |  required  | 
        `email` | string |  required  | 
        `alt_mobile_number` | string |  optional  | nullable
        `alt_country_code` | string |  required  | when alt_mobile_number is present
        `gstin` | string |  required  | 
        `lab_reg_number` | string |  required  | 
        `lab_issuing_authority` | string |  required  | 
        `lab_date_of_issue` | date |  required  | format:Y-m-d
        `lab_valid_upto` | date |  required  | format:Y-m-d
        `lab_file` | image |  required  | required mime:jpg,jpeg,png size max 2mb
        `row` | array |  optional  | nullable
        `row.*.id` | integer |  required  | test list ids
        `row.*.sample_collect` | boolean |  required  | 0 or 1
        `pincode` | integer |  required  | length 6
        `street_name` | string |  required  | Street Name/ House No./ Area
        `city_village` | string |  required  | City/Village
        `district` | string |  required  | 
        `state` | string |  required  | 
        `country` | string |  required  | 
        `sample_collection` | boolean |  required  | 0 or 1
        `order_amount` | decimal |  optional  | nullable required if home_delivery is filled
        `currency_code` | stirng |  required  | 
        `latitude` | float |  required  | 
        `longitude` | float |  required  | 
        `bank_account_number` | string |  optional  | nullable
        `bank_account_holder` | string |  optional  | nullable required with bank_account_number
        `bank_name` | string |  optional  | nullable required with bank_account_number
        `bank_city` | string |  optional  | nullable required with bank_account_number
        `bank_ifsc` | string |  optional  | nullable required with bank_account_number
        `bank_account_type` | string |  optional  | nullable required with bank_account_number
    
<!-- END_5d4e95dcf2215f0c002b14b14cb51c2d -->

#Appointments


<!-- START_de109c0576741c61a39eca0fb8dece0a -->
## Get Details to make appointment

Authorization: &quot;Bearer {access_token}&quot; is optional, when a valid access_token is present , user is authenticated and allowed to proceed with payment. If access_token is invalid a redirect_id is provided to contine to payment after successfull login.

> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/appointments/details" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"doctor_id":4,"address_id":5,"consultation_type":"assumenda","time_stot_id":15,"date":"quidem","shift":"quia","followup_id":4,"timezone":"animi"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/appointments/details"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "doctor_id": 4,
    "address_id": 5,
    "consultation_type": "assumenda",
    "time_stot_id": 15,
    "date": "quidem",
    "shift": "quia",
    "followup_id": 4,
    "timezone": "animi"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "doctor_id": [
            "The doctor id field is required."
        ],
        "address_id": [
            "The address id field is required."
        ],
        "time_stot_id": [
            "The time stot id field is required."
        ],
        "consultation_type": [
            "The Consultation type stot id field is required."
        ],
        "date": [
            "The date field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "redirect_id": 2
}
```
> Example response (200):

```json
{
    "id": 2,
    "doctor_unique_id": "4",
    "title": "Dr.",
    "gender": "MALE",
    "date_of_birth": "1975-12-03",
    "age": 8,
    "qualification": "eum",
    "years_of_experience": "5",
    "alt_mobile_number": null,
    "clinic_name": null,
    "career_profile": null,
    "education_training": null,
    "experience": null,
    "clinical_focus": null,
    "awards_achievements": null,
    "memberships": null,
    "profile_photo": null,
    "appointment_type_online": null,
    "appointment_type_offline": null,
    "consulting_online_fee": null,
    "consulting_offline_fee": null,
    "available_from_time": null,
    "available_to_time": null,
    "service": null,
    "address": {
        "id": 2,
        "street_name": "Waters Cape",
        "city_village": "817 Theresa Summit",
        "district": "Lennyborough",
        "state": "Louisiana",
        "country": "Mali",
        "pincode": "94379",
        "contact_number": "782.971.9321",
        "latitude": "-13.71597100",
        "longitude": "-76.15551600"
    },
    "time_slot": {
        "id": 1,
        "day": "FRIDAY",
        "slot_start": "19:30:00",
        "slot_end": "19:40:00",
        "type": "ONLINE",
        "doctor_clinic_id": 1,
        "shift": "MORNING"
    },
    "patient": [
        {
            "id": 2,
            "first_name": "ammu",
            "middle_name": null,
            "last_name": "prasad",
            "email": "ammu.prasad@logidots.com",
            "username": "ammu",
            "country_code": "+91",
            "mobile_number": "7591985087",
            "user_type": "PATIENT",
            "profile_photo_url": "http:\/\/localhost\/fms-api-laravel\/public\/storage\/uploads\/2\/1601270200-4cb339a2-fb1e-4c3c-8ada-fe9e6566e7db.jpeg",
            "family": [
                {
                    "id": 1,
                    "patient_family_id": "P0000001F01",
                    "title": "Mr",
                    "first_name": "ben",
                    "middle_name": "M",
                    "last_name": "ten",
                    "gender": "MALE",
                    "date_of_birth": "1998-06-19",
                    "age": 27,
                    "height": 160,
                    "weight": 90,
                    "marital_status": "SINGLE",
                    "occupation": "nothing to work",
                    "relationship": "SON",
                    "current_medication": "fever"
                },
                {
                    "id": 2,
                    "patient_family_id": "P0000001F02",
                    "title": "Mr",
                    "first_name": "ben",
                    "middle_name": "M",
                    "last_name": "ten",
                    "gender": "MALE",
                    "date_of_birth": "1998-06-19",
                    "age": 27,
                    "height": 160,
                    "weight": 90,
                    "marital_status": "SINGLE",
                    "occupation": "nothing to work",
                    "relationship": "SON",
                    "current_medication": "fever"
                }
            ]
        }
    ],
    "consultation_type": "INCLINIC",
    "shift": "MORNING",
    "followup_id": "2",
    "date": "2020-09-23",
    "user": {
        "id": 5,
        "first_name": "Mrs. Bessie Strosin",
        "middle_name": "Miss Trisha Walter",
        "last_name": "Rocky Batz"
    },
    "specialization": [
        {
            "id": 7,
            "name": "Dietitian",
            "pivot": {
                "doctor_personal_info_id": 1,
                "specializations_id": 7
            }
        },
        {
            "id": 8,
            "name": "Pulmonologist",
            "pivot": {
                "doctor_personal_info_id": 1,
                "specializations_id": 8
            }
        }
    ]
}
```

### HTTP Request
`POST api/appointments/details`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `doctor_id` | integer |  required  | 
        `address_id` | integer |  required  | 
        `consultation_type` | string |  required  | any one of INCLINIC,ONLINE,EMERGENCY
        `time_stot_id` | integer |  required  | if consultation_type is equal to anyone of INCLINIC,ONLINE
        `date` | date |  required  | format Y-m-d
        `shift` | string |  optional  | nullable required if consultation_type is equal to EMERGENCY , any one of MORNING, AFTERNOON, EVENING, NIGHT
        `followup_id` | integer |  optional  | nullable
        `timezone` | string |  required  | 
    
<!-- END_de109c0576741c61a39eca0fb8dece0a -->

<!-- START_44693abd8e88da2038f84b2fe0531b5c -->
## List Prescription

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/appointments/prescription?patient_id=a&name=reiciendis&date=consectetur" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/appointments/prescription"
);

let params = {
    "patient_id": "a",
    "name": "reiciendis",
    "date": "consectetur",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "patient_id": [
            "The selected patient id is invalid."
        ]
    }
}
```
> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "appointment_id": 3,
            "diagnosis": "this patient has corona",
            "comments": null,
            "dispensed_at_clinic": 1,
            "medicine_list": [
                {
                    "comment": "take 2 tables",
                    "medicine_id": "1"
                },
                {
                    "comment": "take 5 tables",
                    "medicine_id": "2"
                }
            ],
            "test_list": [
                {
                    "comment": "take 2 tables",
                    "test_id": "1"
                }
            ],
            "dispense_type": null,
            "created_at": "2020-12-02T06:03:17.000000Z",
            "updated_at": "2020-12-02T06:04:18.000000Z",
            "pdf_url": "http:\/\/localhost\/fms-api-laravel\/public\/storage\/uploads\/prescription\/1-1606889057.pdf",
            "appointment": {
                "id": 3,
                "doctor_id": 2,
                "patient_id": 3,
                "appointment_unique_id": "AP0000003",
                "date": "2020-12-03",
                "time": "11:00 AM",
                "consultation_type": "INCLINIC",
                "shift": "MORNING",
                "payment_status": "PAID",
                "transaction_id": 1,
                "total": "700.00",
                "is_cancelled": 0,
                "is_completed": 0,
                "booking_date": "2020-12-01",
                "doctor": {
                    "id": 2,
                    "first_name": "Theophilus",
                    "middle_name": "Jos",
                    "last_name": "Simeon",
                    "email": "theophilus@logidots.com",
                    "username": "theo",
                    "country_code": "+91",
                    "mobile_number": "8940330536",
                    "user_type": "DOCTOR",
                    "is_active": "1",
                    "role": null,
                    "approved_date": "2020-12-01",
                    "profile_photo_url": null,
                    "approved_by": "Super  Admin"
                }
            }
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/appointments\/prescription?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/appointments\/prescription?page=1",
    "next_page_url": null,
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/appointments\/prescription",
    "per_page": 10,
    "prev_page_url": null,
    "to": 1,
    "total": 1
}
```
> Example response (404):

```json
{
    "message": "No records found."
}
```

### HTTP Request
`GET api/appointments/prescription`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `patient_id` |  required  | integer id of patient object
    `name` |  optional  | nullable string name of patient
    `date` |  optional  | nullable date format-> Y-m-d

<!-- END_44693abd8e88da2038f84b2fe0531b5c -->

<!-- START_4784e78669507b77b10400ca93881a90 -->
## Continue with draft appointment

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/appointments/continue/1?redirect_id=omnis" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/appointments/continue/1"
);

let params = {
    "redirect_id": "omnis",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "id": 2,
    "doctor_unique_id": "4",
    "title": "Dr.",
    "gender": "MALE",
    "date_of_birth": "1975-12-03",
    "age": 8,
    "qualification": "eum",
    "years_of_experience": "5",
    "alt_mobile_number": null,
    "clinic_name": null,
    "career_profile": null,
    "education_training": null,
    "experience": null,
    "clinical_focus": null,
    "awards_achievements": null,
    "memberships": null,
    "profile_photo": null,
    "appointment_type_online": null,
    "appointment_type_offline": null,
    "consulting_online_fee": null,
    "consulting_offline_fee": null,
    "available_from_time": null,
    "available_to_time": null,
    "service": null,
    "address": {
        "id": 2,
        "street_name": "Waters Cape",
        "city_village": "817 Theresa Summit",
        "district": "Lennyborough",
        "state": "Louisiana",
        "country": "Mali",
        "pincode": "94379",
        "contact_number": "782.971.9321",
        "latitude": "-13.71597100",
        "longitude": "-76.15551600"
    },
    "time_slot": {
        "id": 1,
        "day": "FRIDAY",
        "slot_start": "19:30:00",
        "slot_end": "19:40:00",
        "type": "ONLINE",
        "doctor_clinic_id": 1,
        "shift": "MORNING"
    },
    "patient": [
        {
            "id": 2,
            "first_name": "ammu",
            "middle_name": null,
            "last_name": "prasad",
            "email": "ammu.prasad@logidots.com",
            "username": "ammu",
            "country_code": "+91",
            "mobile_number": "7591985087",
            "user_type": "PATIENT",
            "profile_photo_url": "http:\/\/localhost\/fms-api-laravel\/public\/storage\/uploads\/2\/1601270200-4cb339a2-fb1e-4c3c-8ada-fe9e6566e7db.jpeg",
            "user": {
                "id": 2,
                "first_name": "ammu",
                "middle_name": "ammu",
                "last_name": "phil",
                "mobile_number": "+917591985087",
                "email": "ammu.prasad@logidots.com"
            },
            "family": [
                {
                    "id": 1,
                    "patient_family_id": "P0000001F01",
                    "title": "Mr",
                    "first_name": "ben",
                    "middle_name": "M",
                    "last_name": "ten",
                    "gender": "MALE",
                    "date_of_birth": "1998-06-19",
                    "age": 27,
                    "height": 160,
                    "weight": 90,
                    "marital_status": "SINGLE",
                    "occupation": "nothing to work",
                    "relationship": "SON",
                    "current_medication": "fever"
                },
                {
                    "id": 2,
                    "patient_family_id": "P0000001F02",
                    "title": "Mr",
                    "first_name": "ben",
                    "middle_name": "M",
                    "last_name": "ten",
                    "gender": "MALE",
                    "date_of_birth": "1998-06-19",
                    "age": 27,
                    "height": 160,
                    "weight": 90,
                    "marital_status": "SINGLE",
                    "occupation": "nothing to work",
                    "relationship": "SON",
                    "current_medication": "fever"
                }
            ]
        }
    ],
    "consultation_type": "INCLINIC",
    "shift": "MORNING",
    "followup_id": "2",
    "date": "2020-09-23",
    "user": {
        "id": 5,
        "first_name": "Mrs. Bessie Strosin",
        "middle_name": "Miss Trisha Walter",
        "last_name": "Rocky Batz"
    },
    "specialization": [
        {
            "id": 7,
            "name": "Dietitian",
            "pivot": {
                "doctor_personal_info_id": 1,
                "specializations_id": 7
            }
        },
        {
            "id": 8,
            "name": "Pulmonologist",
            "pivot": {
                "doctor_personal_info_id": 1,
                "specializations_id": 8
            }
        }
    ]
}
```
> Example response (404):

```json
{
    "message": "Redirect id not found."
}
```

### HTTP Request
`GET api/appointments/continue/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `redirect_id` |  required  | integer

<!-- END_4784e78669507b77b10400ca93881a90 -->

<!-- START_aca2bcb96f97ce92b1b66b71e30c293e -->
## Create appointment

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/appointments/confirm" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"doctor_id":17,"address_id":1,"patient_id":18,"consultation_type":"quia","time_slot_id":3,"date":"esse","shift":"molestiae","followup_id":11,"patient_info":{"mobile_code":"consequatur","mobile":"reiciendis","first_name":"in","middle_name":"ullam","last_name":"incidunt","patient_mobile_code":"aspernatur","patient_mobile":"magni","email":"rerum","case":"optio","id":11}}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/appointments/confirm"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "doctor_id": 17,
    "address_id": 1,
    "patient_id": 18,
    "consultation_type": "quia",
    "time_slot_id": 3,
    "date": "esse",
    "shift": "molestiae",
    "followup_id": 11,
    "patient_info": {
        "mobile_code": "consequatur",
        "mobile": "reiciendis",
        "first_name": "in",
        "middle_name": "ullam",
        "last_name": "incidunt",
        "patient_mobile_code": "aspernatur",
        "patient_mobile": "magni",
        "email": "rerum",
        "case": "optio",
        "id": 11
    }
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "doctor_id": [
            "The doctor id field is required."
        ],
        "address_id": [
            "The address id field is required."
        ],
        "patient_id": [
            "The patient id field is required."
        ],
        "consultation_type": [
            "The consultation type field is required."
        ],
        "date": [
            "The date must be a date after or equal to now."
        ]
    }
}
```
> Example response (403):

```json
{
    "message": "Time slot already booked."
}
```
> Example response (403):

```json
{
    "message": "Emergency appointment can't be booked."
}
```
> Example response (200):

```json
{
    "appointment_id": 1,
    "type": "FOLLOWUP",
    "message": "Appointment created successfully."
}
```
> Example response (200):

```json
{
    "id": 484,
    "doctor_id": 2,
    "patient_id": 3,
    "appointment_unique_id": "AP0000484",
    "date": "2021-04-03",
    "time": "18:00:00",
    "consultation_type": "ONLINE",
    "shift": null,
    "payment_status": null,
    "transaction_id": null,
    "total": null,
    "tax": null,
    "commission": null,
    "is_cancelled": 0,
    "is_completed": 0,
    "followup_id": null,
    "booking_date": "2021-03-03",
    "current_patient_info": {
        "user": {
            "first_name": "Ben",
            "middle_name": null,
            "last_name": "Patient",
            "email": "patient@logidots.com",
            "country_code": "+91",
            "mobile_number": "9876543210",
            "profile_photo_url": null
        },
        "case": 0,
        "info": {
            "first_name": "someoneElse",
            "middle_name": null,
            "last_name": "Two",
            "email": "patient@logidots.com",
            "country_code": "+91",
            "mobile_number": 9876543210,
            "height": null,
            "weight": null,
            "gender": null,
            "age": null
        },
        "address": {
            "id": 36,
            "street_name": "Sreekariyam",
            "city_village": "Trivandrum",
            "district": "Alappuzha",
            "state": "Kerala",
            "country": "India",
            "pincode": "688001",
            "country_code": null,
            "contact_number": null,
            "land_mark": null,
            "latitude": null,
            "longitude": null,
            "clinic_name": null
        }
    },
    "doctor": {
        "id": 2,
        "first_name": "Theophilus",
        "middle_name": "Jos",
        "last_name": "Simeon",
        "email": "theophilus@logidots.com",
        "username": "theo",
        "country_code": "+91",
        "mobile_number": "8940330536",
        "user_type": "DOCTOR",
        "is_active": "1",
        "role": null,
        "currency_code": "INR",
        "approved_date": "2021-01-04",
        "profile_photo_url": null
    },
    "clinic_address": {
        "id": 1,
        "street_name": "South Road",
        "city_village": "Edamatto",
        "district": "Kottayam",
        "state": "Kerala",
        "country": "India",
        "pincode": "686575",
        "country_code": null,
        "contact_number": "9786200983",
        "land_mark": null,
        "latitude": "10.53034500",
        "longitude": "76.21472900",
        "clinic_name": "Neo clinic"
    },
    "tax_percent": 15,
    "total_commission": 15,
    "total_tax": 15,
    "total_fees": 150,
    "type": "NEW_APPOINTMENT"
}
```

### HTTP Request
`POST api/appointments/confirm`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `doctor_id` | integer |  required  | 
        `address_id` | integer |  required  | 
        `patient_id` | integer |  required  | 
        `consultation_type` | string |  required  | anyone of INCLINIC,ONLINE,EMERGENCY
        `time_slot_id` | integer |  required  | 
        `date` | date |  required  | format -> Y-m-d
        `shift` | string |  optional  | nullable anyone of MORNING,AFTERNOON,EVENING,NIGHT required_if consultation_type is EMERGENCY
        `followup_id` | integer |  optional  | nullable
        `patient_info.mobile_code` | string |  required  | 
        `patient_info.mobile` | string |  required  | 
        `patient_info.first_name` | string |  required  | 
        `patient_info.middle_name` | string |  optional  | nullable
        `patient_info.last_name` | string |  required  | 
        `patient_info.patient_mobile_code` | string |  required  | 
        `patient_info.patient_mobile` | string |  required  | 
        `patient_info.email` | string |  optional  | nullable
        `patient_info.case` | interger |  required  | 0 for someonelse, 1 for current patient, 2 for family member
        `patient_info.id` | integer |  optional  | nullable patient_id or family_member_id
    
<!-- END_aca2bcb96f97ce92b1b66b71e30c293e -->

<!-- START_a17862fc74da1c61935b80785f59be89 -->
## Create checkout

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/appointments/checkout" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"appointment_id":11,"tax":"eos","total":"dolor","commission":"nihil"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/appointments/checkout"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "appointment_id": 11,
    "tax": "eos",
    "total": "dolor",
    "commission": "nihil"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "appointment_id": [
            "The appointment id field is required."
        ],
        "tax": [
            "The tax field is required."
        ],
        "total": [
            "The total field is required."
        ],
        "minutes": [
            "The minutes field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "razorpay_order_id": "order_Ghk58p1UZD35g8",
    "currency": "INR",
    "appointment_id": 1,
    "total": "5000",
    "name": "Ben Patient",
    "email": "patient@logidots.com"
}
```

### HTTP Request
`POST api/appointments/checkout`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `appointment_id` | integer |  required  | 
        `tax` | price |  required  | 
        `total` | price |  required  | 
        `commission` | price |  required  | 
    
<!-- END_a17862fc74da1c61935b80785f59be89 -->

<!-- START_95a05cc29848f3f1943f0ac26aeb4c28 -->
## Confirm payment

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/appointments/confirmpayment" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"razorpay_payment_id":"magni","razorpay_order_id":"et","razorpay_signature":"architecto"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/appointments/confirmpayment"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "razorpay_payment_id": "magni",
    "razorpay_order_id": "et",
    "razorpay_signature": "architecto"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "razorpay_payment_id": [
            "The razorpay payment id field is required."
        ],
        "razorpay_order_id": [
            "The razorpay order id field is required."
        ],
        "razorpay_signature": [
            "The razorpay signature field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Payment successfull."
}
```
> Example response (422):

```json
{
    "message": "Invalid signature passed."
}
```
> Example response (422):

```json
{
    "message": "OrderId not found."
}
```

### HTTP Request
`POST api/appointments/confirmpayment`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `razorpay_payment_id` | string |  required  | 
        `razorpay_order_id` | string |  required  | 
        `razorpay_signature` | string |  required  | 
    
<!-- END_95a05cc29848f3f1943f0ac26aeb4c28 -->

<!-- START_7bd051cfa29a7f1dc4fd87e4df25040d -->
## Cancel payment

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/appointments/cancelpayment" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"appointment_id":15}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/appointments/cancelpayment"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "appointment_id": 15
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "appointment_id": [
            "The appointment id field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Payment cancelled successfully."
}
```
> Example response (404):

```json
{
    "message": "Appointment can't be cancelled."
}
```

### HTTP Request
`POST api/appointments/cancelpayment`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `appointment_id` | integer |  required  | 
    
<!-- END_7bd051cfa29a7f1dc4fd87e4df25040d -->

#Authenticaton and Authorization


<!-- START_b19e2ecbb41b5fa6802edaf581aab5f6 -->
## Get profile info for logged in user

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/me" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/me"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "first_name": "Theophilus",
    "middle_name": "Jos",
    "last_name": "Simeon",
    "email": "theophilus@logidots.com",
    "user_type": "DOCTOR",
    "first_login": 0,
    "current_user_id": 2,
    "currency_code": "EUR",
    "is_active": "3",
    "username": "user_name",
    "profile_photo": "http:\/\/localhost\/fms-api-laravel\/public\/storage\/\/var\/www\/html\/fms-api-laravel\/storage\/app\/public\/uploads\/2\/1606756408-d4288ed1-62ea-4ba4-8759-e1305675f465.jpeg",
    "roles": [
        "patient"
    ]
}
```

### HTTP Request
`GET api/me`


<!-- END_b19e2ecbb41b5fa6802edaf581aab5f6 -->

<!-- START_2cfa5fc4191765a61d15617314c9c25b -->
## Check unique Email and mobile number

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/checkunique?email_or_mobile=aut" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/checkunique"
);

let params = {
    "email_or_mobile": "aut",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email_or_mobile": [
            "The email or mobile field is required.."
        ]
    }
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email_or_mobile": [
            "The Mobile number has already been taken."
        ]
    }
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email_or_mobile": [
            "The Email has already been taken."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Mobile number is unique."
}
```
> Example response (200):

```json
{
    "message": "Email is unique."
}
```

### HTTP Request
`POST api/checkunique`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `email_or_mobile` |  required  | string

<!-- END_2cfa5fc4191765a61d15617314c9c25b -->

<!-- START_cd7403a7d5139a001db11e443bc82100 -->
## Change UserName

> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/change/username" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"username":"sint"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/change/username"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "username": "sint"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "username": [
            "The username has already been taken."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Username saved successfully."
}
```

### HTTP Request
`POST api/change/username`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `username` | string |  required  | 
    
<!-- END_cd7403a7d5139a001db11e443bc82100 -->

<!-- START_bb0bd443bfd36746cfaa37e6759f4e2c -->
## Register User

> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/oauth/register" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"first_name":"quae","middle_name":"consequatur","last_name":"numquam","password":"iure","password_confirmation":"ipsam","country_code":"ipsam","mobile_number":"consequuntur","email":"omnis","username":"tempora","user_type":"voluptas","login_type":"nemo"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/oauth/register"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "first_name": "quae",
    "middle_name": "consequatur",
    "last_name": "numquam",
    "password": "iure",
    "password_confirmation": "ipsam",
    "country_code": "ipsam",
    "mobile_number": "consequuntur",
    "email": "omnis",
    "username": "tempora",
    "user_type": "voluptas",
    "login_type": "nemo"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "first_name": [
            "The first name field is required."
        ],
        "middle_name": [
            "The middle name field is required."
        ],
        "last_name": [
            "The last name field is required."
        ],
        "password": [
            "The password field is required."
        ],
        "country_code": [
            "The country code field is required."
        ],
        "mobile_number": [
            "The mobile number field is required."
        ],
        "email": [
            "The email field is required."
        ],
        "username": [
            "The username has already been taken."
        ],
        "user_type": [
            "The user type field is required."
        ],
        "login_type": [
            "The login type field is required."
        ]
    }
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "mobile_number": [
            "The mobile number has already been taken."
        ],
        "email": [
            "The email has already been taken."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Email, Mobile OTP has been sent",
    "user_id": 2,
    "mobile_number": "+918610025593",
    "email": "theophilus1@logidots.com"
}
```
> Example response (422):

```json
{
    "message": "OTP sending failed"
}
```

### HTTP Request
`POST api/oauth/register`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `first_name` | string |  required  | 
        `middle_name` | string |  optional  | nullable
        `last_name` | string |  required  | 
        `password` | string |  required  | 
        `password_confirmation` | string |  required  | 
        `country_code` | string |  required  | 
        `mobile_number` | string |  required  | 
        `email` | string |  required  | 
        `username` | string |  required  | unique max 15 chars min 4 chars
        `user_type` | string |  required  | any one of ['PATIENT','DOCTOR']
        `login_type` | string |  required  | any one of ['WEB', 'FACEBOOK', 'GOOGLE']
    
<!-- END_bb0bd443bfd36746cfaa37e6759f4e2c -->

<!-- START_9620f2b1e1671f3a1cd5fabe0a8d47ad -->
## Resend Email OTP

> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/oauth/otp/resend/email" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"email":"autem"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/oauth/otp/resend/email"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "autem"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "Email OTP sent successfully"
}
```
> Example response (404):

```json
{
    "message": "Email not registered"
}
```
> Example response (403):

```json
{
    "message": "Email already verified"
}
```
> Example response (422):

```json
{
    "message": "OTP resend failed"
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": [
            "The email field is required."
        ]
    }
}
```

### HTTP Request
`POST api/oauth/otp/resend/email`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `email` | email |  required  | 
    
<!-- END_9620f2b1e1671f3a1cd5fabe0a8d47ad -->

<!-- START_f9e1b6b2881d0d928e1ecf93e22951f2 -->
## Resend Mobile OTP

> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/oauth/otp/resend/mobile" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"mobile_number":"quo"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/oauth/otp/resend/mobile"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "mobile_number": "quo"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "Mobile OTP resent successfully"
}
```
> Example response (404):

```json
{
    "message": "Mobile number not registered"
}
```
> Example response (403):

```json
{
    "message": "Mobile number already verified"
}
```
> Example response (422):

```json
{
    "message": "OTP resend failed"
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "mobile_number": [
            "The mobile number field is required."
        ]
    }
}
```

### HTTP Request
`POST api/oauth/otp/resend/mobile`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `mobile_number` | string |  required  | 
    
<!-- END_f9e1b6b2881d0d928e1ecf93e22951f2 -->

<!-- START_afc407ef02557b4531d443520b71dd22 -->
## Verify Mobile OTP

> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/oauth/otp/verify/mobile" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"mobile_number":"iure","mobile_otp":12}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/oauth/otp/verify/mobile"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "mobile_number": "iure",
    "mobile_otp": 12
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (403):

```json
{
    "message": "Mobile number already verified"
}
```
> Example response (200):

```json
{
    "token_type": "Bearer",
    "expires_in": 31536000,
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiNmI4YWIyM2Q0YWQ5MzdiMWJlOGNj",
    "refresh_token": null,
    "first_name": "theo",
    "middle_name": "Heart",
    "last_name": "lineee",
    "email": "theophilus@logidots.com",
    "user_type": "DOCTOR",
    "first_login": 1,
    "current_user_id": 2,
    "currency_code": "EUR",
    "is_active": "3",
    "profile_photo": "http:\/\/localhost\/fms-api-laravel\/public\/storage\/uploads\/1\/1600431373-de7f8a81-97b6-4d68-8d8c-5327c4c4b522.jpeg",
    "roles": [
        "patient"
    ]
}
```
> Example response (404):

```json
{
    "message": "Mobile number not registered"
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "mobile_number": [
            "The mobile number field is required."
        ],
        "mobile_otp": [
            "The mobile otp field is required."
        ]
    }
}
```
> Example response (422):

```json
{
    "message": "Mobile number OTP expired"
}
```
> Example response (422):

```json
{
    "message": "Incorrect Mobile number OTP"
}
```
> Example response (404):

```json
{
    "message": "Mobile number verification request not found"
}
```
> Example response (403):

```json
{
    "message": "Waiting for Admin to approve your account."
}
```
> Example response (403):

```json
{
    "message": "Admin has suspended your account."
}
```

### HTTP Request
`POST api/oauth/otp/verify/mobile`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `mobile_number` | string |  required  | send number with country code "+919876543210"
        `mobile_otp` | integer |  required  | 
    
<!-- END_afc407ef02557b4531d443520b71dd22 -->

<!-- START_178f1da004ab2df90282ce0d2c1c6f28 -->
## Verify Email OTP

> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/oauth/otp/verify/email" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"email":"molestias","email_otp":19}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/oauth/otp/verify/email"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "molestias",
    "email_otp": 19
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "token_type": "Bearer",
    "expires_in": 31536000,
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiNmI4YWIyM2Q0YWQ5MzdiMWJlOGNj",
    "refresh_token": null,
    "first_name": "theo",
    "middle_name": "Heart",
    "last_name": "lineee",
    "email": "theophilus@logidots.com",
    "user_type": "DOCTOR",
    "first_login": 1,
    "current_user_id": 2,
    "currency_code": "EUR",
    "is_active": "3",
    "profile_photo": "http:\/\/localhost\/fms-api-laravel\/public\/storage\/uploads\/1\/1600431373-de7f8a81-97b6-4d68-8d8c-5327c4c4b522.jpeg",
    "roles": [
        "patient"
    ]
}
```
> Example response (403):

```json
{
    "message": "Email already verified"
}
```
> Example response (422):

```json
{
    "message": "Email OTP expired"
}
```
> Example response (422):

```json
{
    "message": "Incorrect Email OTP"
}
```
> Example response (404):

```json
{
    "message": "Email verification request not found"
}
```
> Example response (404):

```json
{
    "message": "Email not registered"
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": [
            "The email field is required."
        ],
        "email_otp": [
            "The email otp field is required."
        ]
    }
}
```
> Example response (403):

```json
{
    "message": "Waiting for Admin to approve your account."
}
```
> Example response (403):

```json
{
    "message": "Admin has suspended your account."
}
```

### HTTP Request
`POST api/oauth/otp/verify/email`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `email` | email |  required  | 
        `email_otp` | integer |  required  | 
    
<!-- END_178f1da004ab2df90282ce0d2c1c6f28 -->

<!-- START_96d53d835f2a57c4a99eddb593c776b6 -->
## Verify Mobile and Email OTP

> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/oauth/otp/verify/mobileandemail" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"mobile_number":"animi","mobile_otp":17,"email":"consequuntur","email_otp":14}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/oauth/otp/verify/mobileandemail"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "mobile_number": "animi",
    "mobile_otp": 17,
    "email": "consequuntur",
    "email_otp": 14
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": [
            "The email field is required."
        ],
        "email_otp": [
            "The email otp field is required."
        ],
        "mobile_number": [
            "The mobile number field is required."
        ],
        "mobile_otp": [
            "The mobile otp field is required."
        ]
    }
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email_request": [
            "Email verification request not found"
        ],
        "mobile_request": [
            "Mobile number verification request not found"
        ]
    }
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "mobile_otp": [
            "The mobile otp must be 6 digits."
        ],
        "email_otp": [
            "The email otp must be an integer.",
            "The email otp must be 6 digits."
        ]
    }
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email_otp": [
            "Incorrect Email OTP"
        ],
        "mobile_otp": [
            "Incorrect Mobile number OTP"
        ]
    }
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email_otp": [
            "Email OTP expired"
        ],
        "mobile_otp": [
            "Mobile number OTP expired"
        ]
    }
}
```
> Example response (403):

```json
{
    "message": "Email and Mobile number already verified."
}
```
> Example response (403):

```json
{
    "message": "Email, Mobile number already verified. Waiting for admin to approve your account."
}
```
> Example response (403):

```json
{
    "message": "Waiting for Admin to approve your account."
}
```
> Example response (403):

```json
{
    "message": "Admin has suspended your account."
}
```
> Example response (200):

```json
{
    "token_type": "Bearer",
    "expires_in": 31536000,
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiNmI4YWIyM2Q0YWQ5MzdiMWJlOGNj",
    "refresh_token": null,
    "first_name": "theo",
    "middle_name": "Heart",
    "last_name": "lineee",
    "email": "theophilus@logidots.com",
    "user_type": "DOCTOR",
    "first_login": 1,
    "current_user_id": 2,
    "currency_code": "EUR",
    "is_active": "3",
    "profile_photo": "http:\/\/localhost\/fms-api-laravel\/public\/storage\/uploads\/1\/1600431373-de7f8a81-97b6-4d68-8d8c-5327c4c4b522.jpeg",
    "roles": [
        "patient"
    ]
}
```

### HTTP Request
`POST api/oauth/otp/verify/mobileandemail`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `mobile_number` | string |  required  | 
        `mobile_otp` | integer |  required  | 
        `email` | string |  required  | 
        `email_otp` | integer |  required  | 
    
<!-- END_96d53d835f2a57c4a99eddb593c776b6 -->

<!-- START_c0354caa6545dbe02274f3636d49e289 -->
## Login

> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/oauth/login" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"username":"doloribus","password":"non","timezone":"doloremque"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/oauth/login"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "username": "doloribus",
    "password": "non",
    "timezone": "doloremque"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "token_type": "Bearer",
    "expires_in": 35999,
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.oiMzhiMWM5NTUyMTM2Y2NlODJkZjNhOT",
    "refresh_token": "def50200c42edf813ab61ae3619dc3581c5f34ea6aaee04f114599ab6d7386ddfc7",
    "first_name": "theophilus",
    "middle_name": null,
    "last_name": "simeon",
    "email": "theophilus@logidots.com",
    "user_type": "PATIENT",
    "first_login": 0,
    "current_user_id": 2,
    "currency_code": "EUR",
    "is_active": "3",
    "profile_photo": "http:\/\/localhost\/fms-api-laravel\/public\/storage\/uploads\/1\/1600431373-de7f8a81-97b6-4d68-8d8c-5327c4c4b522.jpeg",
    "roles": [
        "patient"
    ]
}
```
> Example response (401):

```json
{
    "message": "Invalid Username\/Password."
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "username": [
            "The Email\/Username field is required."
        ],
        "password": [
            "   The password field is required."
        ]
    }
}
```
> Example response (403):

```json
{
    "message": "The given data was invalid.",
    "action": "redirect",
    "errors": {
        "email_otp": [
            "Email not verified"
        ],
        "mobile_otp": [
            "Mobile number not verified"
        ]
    }
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "action": "redirect",
    "errors": {
        "email_otp": [
            "Email not verified"
        ],
        "email": [
            "coder7@gmail.com"
        ],
        "mobile_otp": [
            "Mobile number not verified"
        ],
        "country_code": [
            "+91"
        ],
        "mobile_number": [
            "9988776631"
        ]
    }
}
```
> Example response (403):

```json
{
    "message": "Waiting for Admin to approve your account."
}
```
> Example response (403):

```json
{
    "message": "Admin has suspended your account."
}
```

### HTTP Request
`POST api/oauth/login`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `username` | string |  required  | email or username of the user
        `password` | string |  required  | 
        `timezone` | string |  optional  | nullable
    
<!-- END_c0354caa6545dbe02274f3636d49e289 -->

<!-- START_e567e460e8e61ae52f0ebf15e88947cc -->
## Get Access token using Refresh token

> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/oauth/refresh" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"refresh_token":"sapiente"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/oauth/refresh"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "refresh_token": "sapiente"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "token_type": "Bearer",
    "expires_in": 35999,
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.oiMzhiMWM5NTUyMTM2Y2NlODJkZjNhOT",
    "refresh_token": "def50200c42edf813ab61ae3619dc3581c5f34ea6aaee04f114599ab6d7386ddfc7"
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "refresh_token": [
            "The refresh token field is required."
        ]
    }
}
```
> Example response (401):

```json
{
    "message": "The refresh token is invalid."
}
```

### HTTP Request
`POST api/oauth/refresh`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `refresh_token` | string |  required  | Get Access token using Refresh token
    
<!-- END_e567e460e8e61ae52f0ebf15e88947cc -->

<!-- START_6092c345f576fdb51396e55dcc4865dc -->
## Logout

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/oauth/logout" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/oauth/logout"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "You have been successfully logged out!"
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated"
}
```

### HTTP Request
`GET api/oauth/logout`


<!-- END_6092c345f576fdb51396e55dcc4865dc -->

<!-- START_5d08f2a7a5fb932ab20d8d4c50981279 -->
## Forgot Password Send OTP
send OTP through email or mobile number

> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/oauth/password/forgot" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"email_or_mobile":"velit"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/oauth/password/forgot"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email_or_mobile": "velit"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "Email OTP sent successfully"
}
```
> Example response (200):

```json
{
    "message": "Mobile OTP sent successfully"
}
```
> Example response (404):

```json
{
    "message": "User doesn't exist"
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email_or_mobile": [
            "The email or mobile field is required."
        ]
    }
}
```

### HTTP Request
`POST api/oauth/password/forgot`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `email_or_mobile` | string |  required  | email or mobile number
    
<!-- END_5d08f2a7a5fb932ab20d8d4c50981279 -->

<!-- START_838877be1316e924665229ac92dbb3ac -->
## Forgot Password Verify OTP

verify forgot password OTP sent through email or mobile number and change password

> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/oauth/password/forgot/verify" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"email_or_mobile":"ipsa","otp":5,"password":"aspernatur","password_confirmation":"libero"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/oauth/password/forgot/verify"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email_or_mobile": "ipsa",
    "otp": 5,
    "password": "aspernatur",
    "password_confirmation": "libero"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "password reset successfull"
}
```
> Example response (422):

```json
{
    "message": "Email OTP expired"
}
```
> Example response (422):

```json
{
    "message": "Incorrect Email OTP"
}
```
> Example response (404):

```json
{
    "message": "Forgot password request using Email not found"
}
```
> Example response (422):

```json
{
    "message": "Mobile number OTP expired"
}
```
> Example response (422):

```json
{
    "message": "Incorrect Mobile number OTP"
}
```
> Example response (404):

```json
{
    "message": "Forgot password request using Mobile number not found"
}
```
> Example response (404):

```json
{
    "message": "User doesn't exist"
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email_or_mobile": [
            "The email or mobile field is required."
        ],
        "otp": [
            "The otp must be 6 characters."
        ],
        "password": [
            "The password field is required."
        ]
    }
}
```

### HTTP Request
`POST api/oauth/password/forgot/verify`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `email_or_mobile` | string |  required  | email or mobile number.
        `otp` | integer |  required  | length 6 digits
        `password` | string |  required  | 
        `password_confirmation` | string |  required  | 
    
<!-- END_838877be1316e924665229ac92dbb3ac -->

<!-- START_67689c9c0bd73e1bcd6b96bab1ed5f91 -->
## Change Password

All tokens issued previously will be revoked.

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/oauth/password/change" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"current_password":"exercitationem","password":"eum","password_confirmation":"quis"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/oauth/password/change"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "current_password": "exercitationem",
    "password": "eum",
    "password_confirmation": "quis"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "password": [
            "The password must be at least 8 characters.",
            "The password format is invalid.",
            "The password confirmation does not match."
        ],
        "current_password": [
            "The current password field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "password reset successfull."
}
```
> Example response (400):

```json
{
    "message": "Current password is invalid."
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`POST api/oauth/password/change`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `current_password` | string |  required  | 
        `password` | string |  required  | 
        `password_confirmation` | string |  required  | 
    
<!-- END_67689c9c0bd73e1bcd6b96bab1ed5f91 -->

<!-- START_a595b3b8cbde6a962182c3cc1cbf25a0 -->
## Check UserName

> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/oauth/check/username?username=dolor" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/oauth/check/username"
);

let params = {
    "username": "dolor",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "username": [
            "The username has already been taken."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "username is unique."
}
```

### HTTP Request
`GET api/oauth/check/username`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `username` |  required  | string

<!-- END_a595b3b8cbde6a962182c3cc1cbf25a0 -->

<!-- START_03a84ebf7c9fd3e5bc91dca8fad9f272 -->
## Pharmacy Registration - step(1) FD282

> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/oauth/pharmacy/basicinfo" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"pharmacy_name":"veritatis","country_code":"et","mobile_number":"voluptatibus","email":"minus","gstin":"id","dl_number":"aliquid","dl_issuing_authority":"accusantium","dl_date_of_issue":"earum","dl_valid_upto":"repellendus","dl_file":"fuga"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/oauth/pharmacy/basicinfo"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "pharmacy_name": "veritatis",
    "country_code": "et",
    "mobile_number": "voluptatibus",
    "email": "minus",
    "gstin": "id",
    "dl_number": "aliquid",
    "dl_issuing_authority": "accusantium",
    "dl_date_of_issue": "earum",
    "dl_valid_upto": "repellendus",
    "dl_file": "fuga"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "pharmacy_name": [
            "The pharmacy name field is required."
        ],
        "country_code": [
            "The country code field is required."
        ],
        "gstin": [
            "GSTIN (Goods and Services Tax Identification Number) is required."
        ],
        "dl_number": [
            "Drug licence number is required."
        ],
        "dl_issuing_authority": [
            "Drug licence Issuing Authority is required."
        ],
        "dl_date_of_issue": [
            "Drug licence date of issue is required."
        ],
        "dl_valid_upto": [
            "Drug licence valid upto is required."
        ],
        "dl_file": [
            "Drug licence image file is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "data_id": 3
}
```

### HTTP Request
`POST api/oauth/pharmacy/basicinfo`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `pharmacy_name` | string |  required  | 
        `country_code` | string |  required  | 
        `mobile_number` | string |  required  | 
        `email` | string |  required  | 
        `gstin` | string |  required  | 
        `dl_number` | string |  required  | 
        `dl_issuing_authority` | string |  required  | 
        `dl_date_of_issue` | date |  required  | format:Y-m-d
        `dl_valid_upto` | date |  required  | format:Y-m-d
        `dl_file` | image |  required  | required mime:jpg,jpeg,png size max 2mb
    
<!-- END_03a84ebf7c9fd3e5bc91dca8fad9f272 -->

<!-- START_0c1977cc84e6b6f8bcafcbd17a18e747 -->
## Pharmacy Registration - step(2) FD283

> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/oauth/pharmacy/address" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"data_id":1,"pincode":20,"street_name":"laborum","city_village":"et","district":"odio","state":"at","country":"sapiente","home_delivery":false,"order_amount":"impedit","currency_code":"in","latitude":102935.19274,"longitude":1468}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/oauth/pharmacy/address"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "data_id": 1,
    "pincode": 20,
    "street_name": "laborum",
    "city_village": "et",
    "district": "odio",
    "state": "at",
    "country": "sapiente",
    "home_delivery": false,
    "order_amount": "impedit",
    "currency_code": "in",
    "latitude": 102935.19274,
    "longitude": 1468
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "data_id": [
            "The data id field is required."
        ],
        "pincode": [
            "The pincode field is required."
        ],
        "street_name": [
            "The street name field is required."
        ],
        "city_village": [
            "The city village field is required."
        ],
        "district": [
            "The district field is required."
        ],
        "state": [
            "The state field is required."
        ],
        "country": [
            "The country field is required."
        ],
        "home_delivery": [
            "The home delivery field is required."
        ],
        "order_amount": [
            "The order amount field is required when home delivery is 1."
        ],
        "latitude": [
            "The latitude field is required."
        ],
        "longitude": [
            "The longitude field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "data_id": 3
}
```
> Example response (404):

```json
{
    "message": "data id not found"
}
```

### HTTP Request
`POST api/oauth/pharmacy/address`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `data_id` | integer |  required  | data_id returned from step 1
        `pincode` | integer |  required  | length 6
        `street_name` | string |  required  | Street Name/ House No./ Area
        `city_village` | string |  required  | City/Village
        `district` | string |  required  | 
        `state` | string |  required  | 
        `country` | string |  required  | 
        `home_delivery` | boolean |  required  | 0 or 1
        `order_amount` | decimal |  optional  | nullable required if home_delivery is filled
        `currency_code` | string |  required  | 
        `latitude` | float |  required  | 
        `longitude` | float |  required  | 
    
<!-- END_0c1977cc84e6b6f8bcafcbd17a18e747 -->

<!-- START_b950239b37b45dfaafc0f14785bce025 -->
## Pharmacy Registration - step(3) FD284

> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/oauth/pharmacy/additionaldetails" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"data_id":3,"pharmacist_name":"fugit","course":"delectus","pharmacist_reg_number":"ea","issuing_authority":"dolore","alt_mobile_number":"quidem","alt_country_code":"earum","reg_certificate":"velit","reg_date":"odit","reg_valid_upto":"inventore","bank_account_number":"aut","bank_account_holder":"non","bank_name":"fuga","bank_city":"voluptatem","bank_ifsc":"odit","bank_account_type":"ut"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/oauth/pharmacy/additionaldetails"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "data_id": 3,
    "pharmacist_name": "fugit",
    "course": "delectus",
    "pharmacist_reg_number": "ea",
    "issuing_authority": "dolore",
    "alt_mobile_number": "quidem",
    "alt_country_code": "earum",
    "reg_certificate": "velit",
    "reg_date": "odit",
    "reg_valid_upto": "inventore",
    "bank_account_number": "aut",
    "bank_account_holder": "non",
    "bank_name": "fuga",
    "bank_city": "voluptatem",
    "bank_ifsc": "odit",
    "bank_account_type": "ut"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "data_id": [
            "The data id field is required."
        ],
        "pharmacist_name": [
            "The pharmacist name field is required."
        ],
        "course": [
            "The course field is required."
        ],
        "pharmacist_reg_number": [
            "Pharmacist Registration Number is required."
        ],
        "issuing_authority": [
            "The issuing authority field is required."
        ],
        "alt_country_code": [
            "The alt country code field is required when alt mobile number is present."
        ],
        "reg_certificate": [
            "The reg certificate field is required."
        ],
        "reg_date": [
            "The reg date field is required."
        ],
        "reg_valid_upto": [
            "The reg valid upto field is required."
        ],
        "bank_account_number": [
            "The bank account number field is required."
        ],
        "bank_account_holder": [
            "The bank account holder field is required."
        ],
        "bank_name": [
            "The bank name field is required."
        ],
        "bank_city": [
            "The bank city field is required."
        ],
        "bank_ifsc": [
            "The bank ifsc field is required."
        ],
        "bank_account_type": [
            "The bank account type field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Email, Mobile OTP has been sent",
    "data_id": 3,
    "mobile_number": "8940330539",
    "email": "theophilus1@logidots.com"
}
```
> Example response (404):

```json
{
    "message": "data id not found"
}
```

### HTTP Request
`POST api/oauth/pharmacy/additionaldetails`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `data_id` | integer |  required  | data_id returned from step 2
        `pharmacist_name` | string |  required  | 
        `course` | string |  required  | 
        `pharmacist_reg_number` | string |  required  | 
        `issuing_authority` | string |  required  | 
        `alt_mobile_number` | string |  optional  | nullable
        `alt_country_code` | string |  required  | when alt_mobile_number is present
        `reg_certificate` | string |  required  | 
        `reg_date` | string |  required  | 
        `reg_valid_upto` | string |  required  | 
        `bank_account_number` | string |  optional  | nullable
        `bank_account_holder` | string |  optional  | nullable required with bank_account_number
        `bank_name` | string |  optional  | nullable required with bank_account_number
        `bank_city` | string |  optional  | nullable required with bank_account_number
        `bank_ifsc` | string |  optional  | nullable required with bank_account_number
        `bank_account_type` | string |  optional  | nullable required with bank_account_number
    
<!-- END_b950239b37b45dfaafc0f14785bce025 -->

<!-- START_a7783c455befc4cec1ed48de34dbe288 -->
## Pharmacy Resend Email OTP

> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/oauth/pharmacy/otp/resend/email" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"email":"beatae"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/oauth/pharmacy/otp/resend/email"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "beatae"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "Email OTP sent successfully"
}
```
> Example response (404):

```json
{
    "message": "Email not registered"
}
```
> Example response (403):

```json
{
    "message": "Email already verified"
}
```
> Example response (422):

```json
{
    "message": "OTP resend failed"
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": [
            "The email field is required."
        ]
    }
}
```

### HTTP Request
`POST api/oauth/pharmacy/otp/resend/email`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `email` | email |  required  | 
    
<!-- END_a7783c455befc4cec1ed48de34dbe288 -->

<!-- START_bd2d4aad338f7f6e6c8235cd6ca61bba -->
## Pharmacy Resend Mobile OTP

> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/oauth/pharmacy/otp/resend/mobile" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"mobile_number":"sed"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/oauth/pharmacy/otp/resend/mobile"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "mobile_number": "sed"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "Mobile OTP resent successfully"
}
```
> Example response (404):

```json
{
    "message": "Mobile number not registered"
}
```
> Example response (403):

```json
{
    "message": "Mobile number already verified"
}
```
> Example response (422):

```json
{
    "message": "OTP resend failed"
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "mobile_number": [
            "The mobile number field is required."
        ]
    }
}
```

### HTTP Request
`POST api/oauth/pharmacy/otp/resend/mobile`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `mobile_number` | string |  required  | 
    
<!-- END_bd2d4aad338f7f6e6c8235cd6ca61bba -->

<!-- START_175df380cd929bd77e1c7e837b0ee890 -->
## Pharmacy Verify Mobile and Email OTP

> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/oauth/pharmacy/otp/verify/mobileandemail" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"mobile_number":"aliquam","mobile_otp":5,"email":"ad","email_otp":19}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/oauth/pharmacy/otp/verify/mobileandemail"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "mobile_number": "aliquam",
    "mobile_otp": 5,
    "email": "ad",
    "email_otp": 19
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": [
            "The email field is required."
        ],
        "email_otp": [
            "The email otp field is required."
        ],
        "mobile_number": [
            "The mobile number field is required."
        ],
        "mobile_otp": [
            "The mobile otp field is required."
        ]
    }
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email_request": [
            "Email verification request not found"
        ],
        "mobile_request": [
            "Mobile number verification request not found"
        ]
    }
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "mobile_otp": [
            "The mobile otp must be 6 digits."
        ],
        "email_otp": [
            "The email otp must be an integer.",
            "The email otp must be 6 digits."
        ]
    }
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email_otp": [
            "Incorrect Email OTP"
        ],
        "mobile_otp": [
            "Incorrect Mobile number OTP"
        ]
    }
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email_otp": [
            "Email OTP expired"
        ],
        "mobile_otp": [
            "Mobile number OTP expired"
        ]
    }
}
```
> Example response (403):

```json
{
    "message": "Email and Mobile number already verified"
}
```
> Example response (200):

```json
{
    "message": "You will receive notification mail once Admin approves registration."
}
```

### HTTP Request
`POST api/oauth/pharmacy/otp/verify/mobileandemail`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `mobile_number` | string |  required  | 
        `mobile_otp` | integer |  required  | 
        `email` | string |  required  | 
        `email_otp` | integer |  required  | 
    
<!-- END_175df380cd929bd77e1c7e837b0ee890 -->

<!-- START_73a00755a152d91adb0268d3d4167f1d -->
## Laboratory Registration - step(1) FD288

> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/oauth/laboratory/basicinfo" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"laboratory_name":"excepturi","country_code":"sunt","mobile_number":"tenetur","alt_mobile_number":"rerum","alt_country_code":"aut","email":"rerum","gstin":"incidunt","lab_reg_number":"voluptas","lab_issuing_authority":"ea","lab_date_of_issue":"quo","lab_valid_upto":"qui","lab_file":"praesentium"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/oauth/laboratory/basicinfo"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "laboratory_name": "excepturi",
    "country_code": "sunt",
    "mobile_number": "tenetur",
    "alt_mobile_number": "rerum",
    "alt_country_code": "aut",
    "email": "rerum",
    "gstin": "incidunt",
    "lab_reg_number": "voluptas",
    "lab_issuing_authority": "ea",
    "lab_date_of_issue": "quo",
    "lab_valid_upto": "qui",
    "lab_file": "praesentium"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "laboratory_name": [
            "The laboratory name field is required."
        ],
        "country_code": [
            "The country code field is required."
        ],
        "mobile_number": [
            "The mobile number field is required."
        ],
        "alt_country_code": [
            "The Alternative country code field is required when Alternative mobile number is present."
        ],
        "email": [
            "The email field is required."
        ],
        "gstin": [
            "GSTIN (Goods and Services Tax Identification Number) is required."
        ],
        "lab_reg_number": [
            "Laboratory Registraton number is required."
        ],
        "lab_issuing_authority": [
            "Laboratory Registraton Issuing Authority is required."
        ],
        "lab_date_of_issue": [
            "Laboratory Registraton date of issue is required."
        ],
        "lab_valid_upto": [
            "Laboratory Registraton valid upto is required."
        ],
        "lab_file": [
            "Laboratory Registraton image file is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "data_id": 3
}
```

### HTTP Request
`POST api/oauth/laboratory/basicinfo`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `laboratory_name` | string |  required  | 
        `country_code` | string |  required  | 
        `mobile_number` | string |  required  | 
        `alt_mobile_number` | string |  optional  | nullable
        `alt_country_code` | string |  required  | when alt_mobile_number is present
        `email` | string |  required  | 
        `gstin` | string |  required  | 
        `lab_reg_number` | string |  required  | 
        `lab_issuing_authority` | string |  required  | 
        `lab_date_of_issue` | date |  required  | format:Y-m-d
        `lab_valid_upto` | date |  required  | format:Y-m-d
        `lab_file` | image |  required  | required mime:jpg,jpeg,png size max 2mb
    
<!-- END_73a00755a152d91adb0268d3d4167f1d -->

<!-- START_c4d3d9a76559815b89f86ce67c16bf0e -->
## Laboratory Registration - step(2) FD290

> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/oauth/laboratory/address" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"data_id":12,"pincode":17,"street_name":"inventore","city_village":"molestiae","district":"et","state":"et","country":"dignissimos","sample_collection":true,"order_amount":"maiores","currency_code":"cumque","latitude":212104,"longitude":4.117170131}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/oauth/laboratory/address"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "data_id": 12,
    "pincode": 17,
    "street_name": "inventore",
    "city_village": "molestiae",
    "district": "et",
    "state": "et",
    "country": "dignissimos",
    "sample_collection": true,
    "order_amount": "maiores",
    "currency_code": "cumque",
    "latitude": 212104,
    "longitude": 4.117170131
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "data_id": [
            "The data id field is required."
        ],
        "pincode": [
            "The pincode field is required."
        ],
        "street_name": [
            "The street name field is required."
        ],
        "city_village": [
            "The city village field is required."
        ],
        "district": [
            "The district field is required."
        ],
        "state": [
            "The state field is required."
        ],
        "country": [
            "The country field is required."
        ],
        "sample_collection": [
            "Sample collection from home field is required."
        ],
        "order_amount": [
            "Order amount is required when Sample collection from home field is yes."
        ],
        "latitude": [
            "The latitude field is required."
        ],
        "longitude": [
            "The longitude field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "data_id": 1
}
```
> Example response (404):

```json
{
    "message": "data id not found"
}
```

### HTTP Request
`POST api/oauth/laboratory/address`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `data_id` | integer |  required  | data_id returned from step 1
        `pincode` | integer |  required  | length 6
        `street_name` | string |  required  | Street Name/ House No./ Area
        `city_village` | string |  required  | City/Village
        `district` | string |  required  | 
        `state` | string |  required  | 
        `country` | string |  required  | 
        `sample_collection` | boolean |  required  | 0 or 1
        `order_amount` | decimal |  optional  | nullable required if sample_collection is filled
        `currency_code` | stirng |  required  | 
        `latitude` | float |  required  | 
        `longitude` | float |  required  | 
    
<!-- END_c4d3d9a76559815b89f86ce67c16bf0e -->

<!-- START_c4350db30c891eb3a0a14f00b17d59e8 -->
## Laboratory Registration - step(3) FD292

> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/oauth/laboratory/testlist" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"data_id":7,"row":[{"id":16,"sample_collect":false}]}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/oauth/laboratory/testlist"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "data_id": 7,
    "row": [
        {
            "id": 16,
            "sample_collect": false
        }
    ]
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data_id": 3
}
```
> Example response (404):

```json
{
    "message": "data id not found"
}
```

### HTTP Request
`POST api/oauth/laboratory/testlist`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `data_id` | integer |  required  | data_id returned from step 1
        `row` | array |  optional  | nullable
        `row[0][id]` | integer |  required  | id of Laboratory Test List, Unique
        `row[0][sample_collect]` | boolean |  required  | 1 0r 0
    
<!-- END_c4350db30c891eb3a0a14f00b17d59e8 -->

<!-- START_9c63f79a141462ce9e4911b125715bfa -->
## Laboratory Registration - step(4) FD291

> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/oauth/laboratory/bankdetails" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"data_id":19,"bank_account_number":"deserunt","bank_account_holder":"totam","bank_name":"omnis","bank_city":"et","bank_ifsc":"et","bank_account_type":"porro"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/oauth/laboratory/bankdetails"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "data_id": 19,
    "bank_account_number": "deserunt",
    "bank_account_holder": "totam",
    "bank_name": "omnis",
    "bank_city": "et",
    "bank_ifsc": "et",
    "bank_account_type": "porro"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "bank_account_number": [
            "The bank account number field is required."
        ],
        "bank_account_holder": [
            "The bank account holder field is required."
        ],
        "bank_name": [
            "The bank name field is required."
        ],
        "bank_city": [
            "The bank city field is required."
        ],
        "bank_ifsc": [
            "The bank ifsc field is required."
        ],
        "bank_account_type": [
            "The bank account type field is required."
        ]
    }
}
```
> Example response (404):

```json
{
    "message": "data id not found"
}
```
> Example response (200):

```json
{
    "message": "Email, Mobile OTP has been sent",
    "data_id": 3,
    "mobile_number": "8940330539",
    "email": "theophilus1@logidots.com"
}
```
> Example response (403):

```json
{
    "message": "Email, Mobile OTP already been sent"
}
```

### HTTP Request
`POST api/oauth/laboratory/bankdetails`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `data_id` | integer |  required  | data_id returned from step 1
        `bank_account_number` | string |  optional  | nullable
        `bank_account_holder` | string |  optional  | nullable required with bank_account_number
        `bank_name` | string |  optional  | nullable required with bank_account_number
        `bank_city` | string |  optional  | nullable required with bank_account_number
        `bank_ifsc` | string |  optional  | nullable required with bank_account_number
        `bank_account_type` | string |  optional  | nullable required with bank_account_number
    
<!-- END_9c63f79a141462ce9e4911b125715bfa -->

<!-- START_b18e94855c8a98a9d406e20bbb417cc5 -->
## Laboratory Resend Email OTP

> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/oauth/laboratory/otp/resend/email" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"email":"iusto"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/oauth/laboratory/otp/resend/email"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "iusto"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "Email OTP sent successfully"
}
```
> Example response (404):

```json
{
    "message": "Email not registered"
}
```
> Example response (403):

```json
{
    "message": "Email already verified"
}
```
> Example response (422):

```json
{
    "message": "OTP resend failed"
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": [
            "The email field is required."
        ]
    }
}
```

### HTTP Request
`POST api/oauth/laboratory/otp/resend/email`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `email` | email |  required  | 
    
<!-- END_b18e94855c8a98a9d406e20bbb417cc5 -->

<!-- START_fd116c8cc279c23f3f2d12e2b776095d -->
## Laboratory Resend Mobile OTP

> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/oauth/laboratory/otp/resend/mobile" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"mobile_number":"deserunt"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/oauth/laboratory/otp/resend/mobile"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "mobile_number": "deserunt"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "Mobile OTP resent successfully"
}
```
> Example response (404):

```json
{
    "message": "Mobile number not registered"
}
```
> Example response (403):

```json
{
    "message": "Mobile number already verified"
}
```
> Example response (422):

```json
{
    "message": "OTP resend failed"
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "mobile_number": [
            "The mobile number field is required."
        ]
    }
}
```

### HTTP Request
`POST api/oauth/laboratory/otp/resend/mobile`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `mobile_number` | string |  required  | 
    
<!-- END_fd116c8cc279c23f3f2d12e2b776095d -->

<!-- START_8f023fb7d2c77431ddb1988b43654f07 -->
## Laboratory Verify Mobile and Email OTP

> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/oauth/laboratory/otp/verify/mobileandemail" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"mobile_number":"nesciunt","mobile_otp":3,"email":"cumque","email_otp":20}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/oauth/laboratory/otp/verify/mobileandemail"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "mobile_number": "nesciunt",
    "mobile_otp": 3,
    "email": "cumque",
    "email_otp": 20
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": [
            "The email field is required."
        ],
        "email_otp": [
            "The email otp field is required."
        ],
        "mobile_number": [
            "The mobile number field is required."
        ],
        "mobile_otp": [
            "The mobile otp field is required."
        ]
    }
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email_request": [
            "Email verification request not found"
        ],
        "mobile_request": [
            "Mobile number verification request not found"
        ]
    }
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "mobile_otp": [
            "The mobile otp must be 6 digits."
        ],
        "email_otp": [
            "The email otp must be an integer.",
            "The email otp must be 6 digits."
        ]
    }
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email_otp": [
            "Incorrect Email OTP"
        ],
        "mobile_otp": [
            "Incorrect Mobile number OTP"
        ]
    }
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email_otp": [
            "Email OTP expired"
        ],
        "mobile_otp": [
            "Mobile number OTP expired"
        ]
    }
}
```
> Example response (403):

```json
{
    "message": "Email and Mobile number already verified"
}
```
> Example response (200):

```json
{
    "message": "You will receive notification mail once Admin approves registration."
}
```

### HTTP Request
`POST api/oauth/laboratory/otp/verify/mobileandemail`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `mobile_number` | string |  required  | 
        `mobile_otp` | integer |  required  | 
        `email` | string |  required  | 
        `email_otp` | integer |  required  | 
    
<!-- END_8f023fb7d2c77431ddb1988b43654f07 -->

<!-- START_442e06606003057372caaaaa54d5c379 -->
## Health associate Registration - step(1)

> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/oauth/healthassociate/basicinfo" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"first_name":"nisi","middle_name":"aspernatur","last_name":"quaerat","father_first_name":"magni","father_middle_name":"odit","father_last_name":"quia","gender":"sequi","date_of_birth":"minus","age":8,"country_code":"eius","mobile_number":"iste","email":"fuga","resume":"culpa"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/oauth/healthassociate/basicinfo"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "first_name": "nisi",
    "middle_name": "aspernatur",
    "last_name": "quaerat",
    "father_first_name": "magni",
    "father_middle_name": "odit",
    "father_last_name": "quia",
    "gender": "sequi",
    "date_of_birth": "minus",
    "age": 8,
    "country_code": "eius",
    "mobile_number": "iste",
    "email": "fuga",
    "resume": "culpa"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "first_name": [
            "The first name field is required."
        ],
        "middle_name": [
            "The middle name field must be present."
        ],
        "last_name": [
            "The last name field is required."
        ],
        "father_first_name": [
            "The father first name field is required."
        ],
        "father_middle_name": [
            "The father middle name field must be present."
        ],
        "father_last_name": [
            "The father last name field is required."
        ],
        "gender": [
            "The gender field is required."
        ],
        "date_of_birth": [
            "The date of birth field is required."
        ],
        "age": [
            "The age field is required."
        ],
        "country_code": [
            "The country code field is required."
        ],
        "mobile_number": [
            "The mobile number field is required."
        ],
        "email": [
            "The email field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "data_id": 1
}
```

### HTTP Request
`POST api/oauth/healthassociate/basicinfo`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `first_name` | string |  required  | 
        `middle_name` | string |  optional  | nullable present
        `last_name` | string |  required  | 
        `father_first_name` | string |  required  | 
        `father_middle_name` | string |  optional  | nullable present
        `father_last_name` | string |  required  | 
        `gender` | string |  required  | any one of ['MALE', 'FEMALE', 'OTHERS']
        `date_of_birth` | string |  required  | format -> Y-m-d
        `age` | integer |  required  | 
        `country_code` | string |  required  | 
        `mobile_number` | string |  required  | 
        `email` | string |  required  | 
        `resume` | file |  optional  | nullable File mime:doc,pdf,docx size max 2mb
    
<!-- END_442e06606003057372caaaaa54d5c379 -->

<!-- START_827ee94439a78de78288bc6834504c8c -->
## Health associate Registration - step(2)

> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/oauth/healthassociate/address" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"data_id":3,"pincode":16,"street_name":"magnam","city_village":"aliquid","district":"tenetur","state":"eum","country":"quia"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/oauth/healthassociate/address"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "data_id": 3,
    "pincode": 16,
    "street_name": "magnam",
    "city_village": "aliquid",
    "district": "tenetur",
    "state": "eum",
    "country": "quia"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "data_id": [
            "The data id field is required."
        ],
        "pincode": [
            "The pincode field is required."
        ],
        "street_name": [
            "The street name field is required."
        ],
        "city_village": [
            "The city village field is required."
        ],
        "district": [
            "The district field is required."
        ],
        "state": [
            "The state field is required."
        ],
        "country": [
            "The country field is required."
        ]
    }
}
```
> Example response (404):

```json
{
    "message": "data id not found"
}
```
> Example response (200):

```json
{
    "message": "Email, Mobile OTP has been sent",
    "data_id": 3,
    "mobile_number": "8940330539",
    "email": "theophilus1@logidots.com"
}
```
> Example response (403):

```json
{
    "message": "Email, Mobile OTP already been sent"
}
```

### HTTP Request
`POST api/oauth/healthassociate/address`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `data_id` | integer |  required  | data_id returned from step 1
        `pincode` | integer |  required  | length 6
        `street_name` | string |  required  | Street Name/ House No./ Area
        `city_village` | string |  required  | City/Village
        `district` | string |  required  | 
        `state` | string |  required  | 
        `country` | string |  required  | 
    
<!-- END_827ee94439a78de78288bc6834504c8c -->

<!-- START_e75d747a712c914c543f3c1415455957 -->
## Health associate Resend Email OTP

> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/oauth/healthassociate/otp/resend/email" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"email":"pariatur"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/oauth/healthassociate/otp/resend/email"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "pariatur"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "Email OTP sent successfully"
}
```
> Example response (404):

```json
{
    "message": "Email not registered"
}
```
> Example response (403):

```json
{
    "message": "Email already verified"
}
```
> Example response (422):

```json
{
    "message": "OTP resend failed"
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": [
            "The email field is required."
        ]
    }
}
```

### HTTP Request
`POST api/oauth/healthassociate/otp/resend/email`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `email` | email |  required  | 
    
<!-- END_e75d747a712c914c543f3c1415455957 -->

<!-- START_5ccc41eb255bf0f42d2143dbea9f8d74 -->
## Health associate Resend Mobile OTP

> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/oauth/healthassociate/otp/resend/mobile" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"mobile_number":"doloremque"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/oauth/healthassociate/otp/resend/mobile"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "mobile_number": "doloremque"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "Mobile OTP resent successfully"
}
```
> Example response (404):

```json
{
    "message": "Mobile number not registered"
}
```
> Example response (403):

```json
{
    "message": "Mobile number already verified"
}
```
> Example response (422):

```json
{
    "message": "OTP resend failed"
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "mobile_number": [
            "The mobile number field is required."
        ]
    }
}
```

### HTTP Request
`POST api/oauth/healthassociate/otp/resend/mobile`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `mobile_number` | string |  required  | 
    
<!-- END_5ccc41eb255bf0f42d2143dbea9f8d74 -->

<!-- START_d3d6237b933bd391a7418c1524036df4 -->
## Health associate Verify Mobile and Email OTP

> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/oauth/healthassociate/otp/verify/mobileandemail" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"mobile_number":"ullam","mobile_otp":4,"email":"perspiciatis","email_otp":8}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/oauth/healthassociate/otp/verify/mobileandemail"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "mobile_number": "ullam",
    "mobile_otp": 4,
    "email": "perspiciatis",
    "email_otp": 8
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": [
            "The email field is required."
        ],
        "email_otp": [
            "The email otp field is required."
        ],
        "mobile_number": [
            "The mobile number field is required."
        ],
        "mobile_otp": [
            "The mobile otp field is required."
        ]
    }
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email_request": [
            "Email verification request not found"
        ],
        "mobile_request": [
            "Mobile number verification request not found"
        ]
    }
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "mobile_otp": [
            "The mobile otp must be 6 digits."
        ],
        "email_otp": [
            "The email otp must be an integer.",
            "The email otp must be 6 digits."
        ]
    }
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email_otp": [
            "Incorrect Email OTP"
        ],
        "mobile_otp": [
            "Incorrect Mobile number OTP"
        ]
    }
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email_otp": [
            "Email OTP expired"
        ],
        "mobile_otp": [
            "Mobile number OTP expired"
        ]
    }
}
```
> Example response (403):

```json
{
    "message": "Email and Mobile number already verified"
}
```
> Example response (200):

```json
{
    "message": "You will receive notification mail once Admin approves registration."
}
```

### HTTP Request
`POST api/oauth/healthassociate/otp/verify/mobileandemail`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `mobile_number` | string |  required  | 
        `mobile_otp` | integer |  required  | 
        `email` | string |  required  | 
        `email_otp` | integer |  required  | 
    
<!-- END_d3d6237b933bd391a7418c1524036df4 -->

<!-- START_0e867ee9fd8c0163c468bc039ca3d071 -->
## Ecommerce Register User

> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/oauth/ecommerce/register" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"first_name":"sint","last_name":"aut","password":"sunt","email":"cumque"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/oauth/ecommerce/register"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "first_name": "sint",
    "last_name": "aut",
    "password": "sunt",
    "email": "cumque"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "first_name": [
            "The first name field is required."
        ],
        "last_name": [
            "The last name field is required."
        ],
        "password": [
            "The password field is required."
        ],
        "email": [
            "The email field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Email OTP has been sent",
    "user_id": 53,
    "email": "theo@gmail.com"
}
```

### HTTP Request
`POST api/oauth/ecommerce/register`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `first_name` | string |  required  | 
        `last_name` | string |  required  | 
        `password` | string |  required  | 
        `email` | string |  required  | 
    
<!-- END_0e867ee9fd8c0163c468bc039ca3d071 -->

#Cart


<!-- START_3045eab9b818156433434f751510823f -->
## Get Cart By Id

> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/cart/1?id=sit" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/cart/1"
);

let params = {
    "id": "sit",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "id": 1,
    "tax": null,
    "subtotal": 13000,
    "discount": null,
    "delivery_charge": null,
    "total": null,
    "cart_items_count": 1,
    "cart_items": [
        {
            "id": 1,
            "cart_id": 1,
            "item_id": 11,
            "price": 13000,
            "quantity": 65,
            "details": {
                "id": 11,
                "category_id": 1,
                "sku": "MED0000011",
                "composition": "paracet",
                "weight": 0.5,
                "weight_unit": "mg",
                "name": "Crocin",
                "manufacturer": "Inc",
                "medicine_type": "Tablet",
                "drug_type": "Generic",
                "qty_per_strip": 10,
                "price_per_strip": 200,
                "rate_per_unit": 10,
                "rx_required": 1,
                "short_desc": "Take for fever",
                "long_desc": null,
                "cart_desc": null,
                "image_name": null,
                "image_url": null
            }
        }
    ]
}
```
> Example response (200):

```json
{
    "id": 51,
    "tax": null,
    "subtotal": 6616.5,
    "discount": null,
    "delivery_charge": null,
    "total": null,
    "type": "LAB",
    "cart_items_count": 1,
    "cart_items": [
        {
            "id": 61,
            "cart_id": 51,
            "item_id": 2,
            "type": "LAB",
            "price": 6616.5,
            "quantity": 33,
            "test": {
                "id": 2,
                "name": "Basic Metabolic Panel",
                "unique_id": "LAT0000002",
                "price": 200.5,
                "currency_code": "INR",
                "code": "BMP",
                "image": null
            }
        }
    ]
}
```
> Example response (200):

```json
{
    "id": 71,
    "tax": null,
    "subtotal": 5633,
    "discount": null,
    "delivery_charge": null,
    "total": null,
    "type": "LAB",
    "cart_items_count": 2,
    "cart_items": [
        {
            "id": 73,
            "cart_id": 71,
            "item_id": 4,
            "type": "LAB",
            "price": 3227,
            "quantity": 14,
            "test": {
                "id": 4,
                "name": "Lipid Panel",
                "unique_id": "LAT0000004",
                "price": 230.5,
                "currency_code": "INR",
                "code": "LP77",
                "image": null
            }
        }
    ]
}
```
> Example response (404):

```json
{
    "message": "Cart id not found."
}
```

### HTTP Request
`GET api/cart/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of cart

<!-- END_3045eab9b818156433434f751510823f -->

<!-- START_8f2276110cf6c54680c9be48deed3d74 -->
## Create an empty cart

> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/cart/create" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"type":"aspernatur"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/cart/create"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "type": "aspernatur"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "cart_id": 1
}
```

### HTTP Request
`POST api/cart/create`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `type` | string |  required  | MED for medicine cart, LAB for Lab test cart
    
<!-- END_8f2276110cf6c54680c9be48deed3d74 -->

<!-- START_65a6cba15cf889e76afe0acf94c4048c -->
## Create cart with a single product

> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/cart/items" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"item_id":20,"quantity":11,"type":"hic"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/cart/items"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "item_id": 20,
    "quantity": 11,
    "type": "hic"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "item_id": [
            "The item id field is required."
        ],
        "quantity": [
            "The quantity field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "id": 1,
    "tax": null,
    "subtotal": 13000,
    "discount": null,
    "delivery_charge": null,
    "total": null,
    "cart_items_count": 1,
    "cart_items": [
        {
            "id": 1,
            "cart_id": 1,
            "item_id": 11,
            "price": 13000,
            "quantity": 65,
            "details": {
                "id": 11,
                "category_id": 1,
                "sku": "MED0000011",
                "composition": "paracet",
                "weight": 0.5,
                "weight_unit": "mg",
                "name": "Crocin",
                "manufacturer": "Inc",
                "medicine_type": "Tablet",
                "drug_type": "Generic",
                "qty_per_strip": 10,
                "price_per_strip": 200,
                "rate_per_unit": 10,
                "rx_required": 1,
                "short_desc": "Take for fever",
                "long_desc": null,
                "cart_desc": null,
                "image_name": null,
                "image_url": null
            }
        }
    ]
}
```

### HTTP Request
`POST api/cart/items`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `item_id` | integer |  required  | id of medicine
        `quantity` | integer |  required  | 
        `type` | string |  required  | MED for medicine cart, LAB for Lab test cart
    
<!-- END_65a6cba15cf889e76afe0acf94c4048c -->

<!-- START_01f6082707815c6d6f07dea632faa917 -->
## Add product to cart

> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/cart/1/items?id=quibusdam" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"item_id":12,"quantity":3}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/cart/1/items"
);

let params = {
    "id": "quibusdam",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "item_id": 12,
    "quantity": 3
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "item_id": [
            "The item id field is required."
        ],
        "quantity": [
            "The quantity field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "id": 1,
    "tax": null,
    "subtotal": 13000,
    "discount": null,
    "delivery_charge": null,
    "total": null,
    "cart_items_count": 1,
    "cart_items": [
        {
            "id": 1,
            "cart_id": 1,
            "item_id": 11,
            "price": 13000,
            "quantity": 65,
            "medicine": {
                "id": 11,
                "category_id": 1,
                "sku": "MED0000011",
                "composition": "paracet",
                "weight": 0.5,
                "weight_unit": "mg",
                "name": "Crocin",
                "manufacturer": "Inc",
                "medicine_type": "Tablet",
                "drug_type": "Generic",
                "qty_per_strip": 10,
                "price_per_strip": 200,
                "rate_per_unit": 10,
                "rx_required": 1,
                "short_desc": "Take for fever",
                "long_desc": null,
                "cart_desc": null,
                "image_name": null,
                "image_url": null
            }
        }
    ]
}
```
> Example response (200):

```json
{
    "id": 58,
    "tax": null,
    "subtotal": 2406,
    "discount": null,
    "delivery_charge": null,
    "total": null,
    "type": "LAB",
    "cart_items_count": 1,
    "cart_items": [
        {
            "id": 62,
            "cart_id": 58,
            "item_id": 2,
            "type": "LAB",
            "price": 2406,
            "quantity": 12,
            "test": {
                "id": 2,
                "name": "Basic Metabolic Panel",
                "unique_id": "LAT0000002",
                "price": 200.5,
                "currency_code": "INR",
                "code": "BMP",
                "image": null
            }
        }
    ]
}
```
> Example response (404):

```json
{
    "message": "Cart id not found."
}
```

### HTTP Request
`POST api/cart/{id}/items`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of cart
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `item_id` | integer |  required  | id of medicine
        `quantity` | integer |  required  | 
    
<!-- END_01f6082707815c6d6f07dea632faa917 -->

<!-- START_c5b6f3e6a51e16b373ec5193541bb056 -->
## Update product to cart

> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/cart/1/items/update?id=rerum" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"cart_item_id":15,"quantity":8}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/cart/1/items/update"
);

let params = {
    "id": "rerum",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "cart_item_id": 15,
    "quantity": 8
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "cart_item_id": [
            "The cart item id field is required."
        ],
        "quantity": [
            "The quantity field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "id": 1,
    "tax": null,
    "subtotal": 13000,
    "discount": null,
    "delivery_charge": null,
    "total": null,
    "cart_items_count": 1,
    "cart_items": [
        {
            "id": 1,
            "cart_id": 1,
            "item_id": 11,
            "price": 13000,
            "quantity": 65,
            "medicine": {
                "id": 11,
                "category_id": 1,
                "sku": "MED0000011",
                "composition": "paracet",
                "weight": 0.5,
                "weight_unit": "mg",
                "name": "Crocin",
                "manufacturer": "Inc",
                "medicine_type": "Tablet",
                "drug_type": "Generic",
                "qty_per_strip": 10,
                "price_per_strip": 200,
                "rate_per_unit": 10,
                "rx_required": 1,
                "short_desc": "Take for fever",
                "long_desc": null,
                "cart_desc": null,
                "image_name": null,
                "image_url": null
            }
        }
    ]
}
```
> Example response (200):

```json
{
    "id": 71,
    "tax": null,
    "subtotal": 5633,
    "discount": null,
    "delivery_charge": null,
    "total": null,
    "type": "LAB",
    "cart_items_count": 2,
    "cart_items": [
        {
            "id": 73,
            "cart_id": 71,
            "item_id": 4,
            "type": "LAB",
            "price": 3227,
            "quantity": 14,
            "test": {
                "id": 4,
                "name": "Lipid Panel",
                "unique_id": "LAT0000004",
                "price": 230.5,
                "currency_code": "INR",
                "code": "LP77",
                "image": null
            }
        }
    ]
}
```
> Example response (404):

```json
{
    "message": "Cart id not found."
}
```

### HTTP Request
`POST api/cart/{id}/items/update`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of cart
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `cart_item_id` | integer |  required  | id of cart item
        `quantity` | integer |  required  | 
    
<!-- END_c5b6f3e6a51e16b373ec5193541bb056 -->

<!-- START_dea77afc50abc9edb59b20b12505c7d4 -->
## Remove a item from cart

> Example request:

```bash
curl -X DELETE \
    "http://localhost/fms-api-laravel/public/api/cart/1/items/1?id=quo&cart_item_id=nulla" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/cart/1/items/1"
);

let params = {
    "id": "quo",
    "cart_item_id": "nulla",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "id": 1,
    "tax": null,
    "subtotal": 13000,
    "discount": null,
    "delivery_charge": null,
    "total": null,
    "cart_items_count": 1,
    "cart_items": [
        {
            "id": 1,
            "cart_id": 1,
            "item_id": 11,
            "price": 13000,
            "quantity": 65,
            "details": {
                "id": 11,
                "category_id": 1,
                "sku": "MED0000011",
                "composition": "paracet",
                "weight": 0.5,
                "weight_unit": "mg",
                "name": "Crocin",
                "manufacturer": "Inc",
                "medicine_type": "Tablet",
                "drug_type": "Generic",
                "qty_per_strip": 10,
                "price_per_strip": 200,
                "rate_per_unit": 10,
                "rx_required": 1,
                "short_desc": "Take for fever",
                "long_desc": null,
                "cart_desc": null,
                "image_name": null,
                "image_url": null
            }
        }
    ]
}
```
> Example response (200):

```json
{
    "id": 71,
    "tax": null,
    "subtotal": 2406,
    "discount": null,
    "delivery_charge": null,
    "total": null,
    "type": "LAB",
    "cart_items_count": 1,
    "cart_items": [
        {
            "id": 74,
            "cart_id": 71,
            "item_id": 2,
            "type": "LAB",
            "price": 2406,
            "quantity": 12,
            "test": {
                "id": 2,
                "name": "Basic Metabolic Panel",
                "unique_id": "LAT0000002",
                "price": 200.5,
                "currency_code": "INR",
                "code": "BMP",
                "image": null
            }
        }
    ]
}
```
> Example response (404):

```json
{
    "message": "Id not found."
}
```

### HTTP Request
`DELETE api/cart/{id}/items/{cart_item_id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of cart
    `cart_item_id` |  required  | integer id of cart item

<!-- END_dea77afc50abc9edb59b20b12505c7d4 -->

<!-- START_31ffac3a110ca4858e085244a686e611 -->
## Delete cart by id

> Example request:

```bash
curl -X DELETE \
    "http://localhost/fms-api-laravel/public/api/cart/1?id=dolor" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/cart/1"
);

let params = {
    "id": "dolor",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "Cart deleted successfully."
}
```
> Example response (404):

```json
{
    "message": "Cart id not found."
}
```

### HTTP Request
`DELETE api/cart/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of cart

<!-- END_31ffac3a110ca4858e085244a686e611 -->

#Doctor


<!-- START_742184f4b827fa9dee0f15427af18c05 -->
## Doctor, Admin cancel appointment

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/doctor/appointments/cancel/1?id=aut" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/doctor/appointments/cancel/1"
);

let params = {
    "id": "aut",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "Appointment cancelled successfully."
}
```
> Example response (403):

```json
{
    "message": "Appointment can't be cancelled."
}
```

### HTTP Request
`POST api/doctor/appointments/cancel/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of Appointment

<!-- END_742184f4b827fa9dee0f15427af18c05 -->

<!-- START_a72a911d01a67ce745d783b9f5916cd3 -->
## Doctor, Admin reschedule appointment

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/doctor/appointments/reschedule" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"appointment_id":"amet","consultation_type":"exercitationem","shift":"in","date":"odio","doctor_time_slots_id":"omnis"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/doctor/appointments/reschedule"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "appointment_id": "amet",
    "consultation_type": "exercitationem",
    "shift": "in",
    "date": "odio",
    "doctor_time_slots_id": "omnis"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "appointment_id": [
            "The appointment id field is required."
        ],
        "date": [
            "The date field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Appointment rescheduled successfully."
}
```
> Example response (404):

```json
{
    "message": "Appointment not found."
}
```
> Example response (403):

```json
{
    "message": "Appointment can't be rescheduled."
}
```
> Example response (403):

```json
{
    "message": "Previous appointment consultation type is not equal to current input."
}
```

### HTTP Request
`POST api/doctor/appointments/reschedule`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `appointment_id` | required |  optional  | integer id of Appointment
        `consultation_type` | string |  required  | anyone of INCLINIC,ONLINE,EMERGENCY
        `shift` | string |  optional  | nullable anyone of MORNING,AFTERNOON,EVENING,NIGHT required_if consultation_type is EMERGENCY
        `date` | required |  optional  | date format Y-m-d
        `doctor_time_slots_id` | required |  optional  | id of timeslot
    
<!-- END_a72a911d01a67ce745d783b9f5916cd3 -->

<!-- START_115aa07c6f23f300d7b4290dfd35b288 -->
## Doctor get profile

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/doctor/profile" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/doctor/profile"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```
> Example response (200):

```json
{
    "first_name": "Surgeon",
    "middle_name": "Heart",
    "last_name": "Heart surgery",
    "email": "theophilus@logidots.com",
    "country_code": "+91",
    "mobile_number": "+918940330536",
    "username": "theo",
    "gender": "MALE",
    "date_of_birth": "1993-06-19",
    "age": 4,
    "qualification": "BA",
    "specialization": [
        {
            "id": 1,
            "name": "Orthopedician"
        },
        {
            "id": 3,
            "name": "Pediatrician"
        },
        {
            "id": 5,
            "name": "General Surgeon"
        }
    ],
    "years_of_experience": "5",
    "alt_country_code": "+91",
    "alt_mobile_number": null,
    "clinic_name": null,
    "pincode": "627354",
    "street_name": "street",
    "city_village": "vill",
    "district": "district",
    "state": "KL",
    "country": "India",
    "specialization_list": [
        {
            "id": 1,
            "name": "Orthopedician"
        },
        {
            "id": 2,
            "name": "Dermatologist"
        },
        {
            "id": 3,
            "name": "Pediatrician"
        },
        {
            "id": 4,
            "name": "General Physician"
        }
    ]
}
```
> Example response (200):

```json
{
    "first_name": "theo",
    "middle_name": "theo",
    "last_name": "theo",
    "email": "theophilus@logidots.com",
    "country_code": "+91",
    "mobile_number": "+918940330536",
    "username": "user12345",
    "gender": "MALE",
    "date_of_birth": "1998-06-15",
    "age": 27,
    "qualification": "MD",
    "specialization": [],
    "years_of_experience": "5",
    "alt_country_code": "+91",
    "alt_mobile_number": null,
    "clinic_name": "GRACE",
    "pincode": "680001",
    "street_name": "street",
    "city_village": "VILLAGE",
    "district": "KL 15",
    "state": "KL",
    "country": "IN",
    "specialization_list": []
}
```

### HTTP Request
`GET api/doctor/profile`


<!-- END_115aa07c6f23f300d7b4290dfd35b288 -->

<!-- START_cbf5167d272f1a716c6c3ad4dcedafd0 -->
## Doctor edit profile

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/doctor/profile" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"first_name":"qui","middle_name":"beatae","last_name":"nam","gender":"esse","date_of_birth":"enim","age":3.4178673,"qualification":"veniam","specialization":[],"years_of_experience":"ad","mobile_number":"est","country_code":"quia","alt_mobile_number":"exercitationem","alt_country_code":"quaerat","email":"ut","clinic_name":"fugiat","pincode":3,"street_name":"omnis","city_village":"totam","district":"dolores","state":"officiis","country":"cum"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/doctor/profile"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "first_name": "qui",
    "middle_name": "beatae",
    "last_name": "nam",
    "gender": "esse",
    "date_of_birth": "enim",
    "age": 3.4178673,
    "qualification": "veniam",
    "specialization": [],
    "years_of_experience": "ad",
    "mobile_number": "est",
    "country_code": "quia",
    "alt_mobile_number": "exercitationem",
    "alt_country_code": "quaerat",
    "email": "ut",
    "clinic_name": "fugiat",
    "pincode": 3,
    "street_name": "omnis",
    "city_village": "totam",
    "district": "dolores",
    "state": "officiis",
    "country": "cum"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "first_name": [
            "The first name field is required."
        ],
        "last_name": [
            "The last name field is required."
        ],
        "gender": [
            "The gender field is required."
        ],
        "date_of_birth": [
            "The date of birth field is required."
        ],
        "age": [
            "The age field is required."
        ],
        "qualification": [
            "The qualification field is required."
        ],
        "specialization": [
            "The specialization must be an array.."
        ],
        "mobile_number": [
            "The mobile number field is required."
        ],
        "email": [
            "The email field is required."
        ],
        "pincode": [
            "The pincode field is required."
        ],
        "street_name": [
            "The street name field is required."
        ],
        "city_village": [
            "The city village field is required."
        ],
        "district": [
            "The district field is required."
        ],
        "state": [
            "The state field is required."
        ],
        "country": [
            "The country field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Details saved successfully."
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`POST api/doctor/profile`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `first_name` | string |  required  | 
        `middle_name` | string |  optional  | nullable
        `last_name` | string |  required  | 
        `gender` | string |  required  | any one of ['MALE', 'FEMALE', 'OTHERS']
        `date_of_birth` | string |  required  | format -> Y-m-d
        `age` | float |  required  | 
        `qualification` | string |  required  | 
        `specialization` | array |  required  | example specialization[0] = 1
        `years_of_experience` | string |  required  | 
        `mobile_number` | string |  required  | if edited verify using OTP
        `country_code` | string |  required  | if mobile_number is edited
        `alt_mobile_number` | string |  optional  | nullable
        `alt_country_code` | string |  optional  | nullable required if alt_mobile_number is filled
        `email` | string |  required  | if edited verify using OTP
        `clinic_name` | string |  optional  | nullable
        `pincode` | integer |  required  | length 6
        `street_name` | string |  required  | 
        `city_village` | string |  required  | 
        `district` | string |  required  | 
        `state` | string |  required  | 
        `country` | string |  required  | 
    
<!-- END_cbf5167d272f1a716c6c3ad4dcedafd0 -->

<!-- START_5b00ba081daa08c57a17d5148f9dfcb5 -->
## Doctor get Additional Information

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/doctor/profile/additionalinformation" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/doctor/profile/additionalinformation"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "career_profile": "Surgeon",
    "education_training": "Heart",
    "clinical_focus": "Heart surgery",
    "awards_achievements": null,
    "memberships": null,
    "experience": "5",
    "doctor_profile_photo": "http:\/\/localhost\/fms-api-laravel\/public\/storage\/uploads\/1\/1597232166-66392b02-8113-4961-ad0a-4ceaca84da1b.jpeg",
    "service": "INPATIENT",
    "appointment_type": "OFFLINE",
    "currency_code": "INR",
    "consulting_online_fee": null,
    "consulting_offline_fee": 675,
    "emergency_fee": 345,
    "emergency_appointment": 1,
    "no_of_followup": 3,
    "followups_after": 1,
    "cancel_time_period": 120,
    "reschedule_time_period": 48,
    "payout_period": 0
}
```
> Example response (200):

```json
{
    "career_profile": null,
    "education_training": null,
    "clinical_focus": null,
    "awards_achievements": null,
    "memberships": null,
    "experience": null,
    "doctor_profile_photo": null,
    "service": null,
    "appointment_type_online": null,
    "appointment_type_offline": null,
    "currency_code": null,
    "consulting_online_fee": null,
    "consulting_offline_fee": null,
    "emergency_fee": null,
    "emergency_appointment": null,
    "no_of_followup": null,
    "followups_after": null,
    "cancel_time_period": null,
    "reschedule_time_period": null,
    "payout_period": 0,
    "time_intravel": 10,
    "registration_number": null
}
```

### HTTP Request
`GET api/doctor/profile/additionalinformation`


<!-- END_5b00ba081daa08c57a17d5148f9dfcb5 -->

<!-- START_ca381e2192f90f90cacecfad876c71e1 -->
## Doctor edit Additional Information

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/doctor/profile/additionalinformation" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"career_profile":"minus","education_training":"sed","clinical_focus":"non","awards_achievements":"quis","memberships":"magnam","experience":"iste","profile_photo":"praesentium","service":"minus","appointment_type_online":true,"appointment_type_offline":true,"consulting_online_fee":"eum","consulting_offline_fee":"et","currency_code":"quibusdam","emergency_fee":52758.35,"emergency_appointment":9,"no_of_followup":13,"followups_after":5,"cancel_time_period":18,"reschedule_time_period":6,"payout_period":true,"registration_number":"ut","time_intravel":17}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/doctor/profile/additionalinformation"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "career_profile": "minus",
    "education_training": "sed",
    "clinical_focus": "non",
    "awards_achievements": "quis",
    "memberships": "magnam",
    "experience": "iste",
    "profile_photo": "praesentium",
    "service": "minus",
    "appointment_type_online": true,
    "appointment_type_offline": true,
    "consulting_online_fee": "eum",
    "consulting_offline_fee": "et",
    "currency_code": "quibusdam",
    "emergency_fee": 52758.35,
    "emergency_appointment": 9,
    "no_of_followup": 13,
    "followups_after": 5,
    "cancel_time_period": 18,
    "reschedule_time_period": 6,
    "payout_period": true,
    "registration_number": "ut",
    "time_intravel": 17
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "career_profile": [
            "The career profile field is required."
        ],
        "education_training": [
            "The education training field is required."
        ],
        "service": [
            "The service field is required."
        ],
        "consulting_online_fee": [
            "The consulting online fee field is required when appointment type online is 1."
        ],
        "consulting_offline_fee": [
            "The consulting offline fee field is required when appointment type offline is 1."
        ],
        "no_of_followup": [
            "The number of followup field is required"
        ],
        "followups_after": [
            "The number of followup after field is required"
        ],
        "cancel_time_period": [
            "The cancel time period must be a number."
        ],
        "reschedule_time_period": [
            "The reschedule time period must be a number."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Profile details updated successfully"
}
```
> Example response (403):

```json
{
    "message": "Add Doctor profile details to continue."
}
```
> Example response (403):

```json
{
    "message": "Cancel Time Period is greater than Master Cancel Time Period."
}
```
> Example response (403):

```json
{
    "message": "Reschedule Time Period is greater than Master Reschedule Time Period."
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`POST api/doctor/profile/additionalinformation`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `career_profile` | string |  required  | 
        `education_training` | string |  required  | 
        `clinical_focus` | string |  required  | 
        `awards_achievements` | string |  optional  | nullable
        `memberships` | string |  optional  | nullable
        `experience` | string |  optional  | nullable
        `profile_photo` | image |  required  | required only if image is edited by user. image mime:jpg,jpeg,png size max 2mb
        `service` | string |  required  | anyone of ['INPATIENT', 'OUTPATIENT', 'BOTH']
        `appointment_type_online` | boolean |  optional  | nullable 0 or 1
        `appointment_type_offline` | boolean |  optional  | nullable 0 or 1
        `consulting_online_fee` | decimal |  optional  | The consulting online fee field is required when appointment type is 1.
        `consulting_offline_fee` | decimal |  optional  | The consulting offline fee field is required when appointment type is 1.
        `currency_code` | stirng |  required  | 
        `emergency_fee` | float |  optional  | nullable
        `emergency_appointment` | integer |  optional  | 
        `no_of_followup` | integer |  required  | values 1 to 10
        `followups_after` | integer |  required  | values 1 to 4
        `cancel_time_period` | integer |  optional  | nullable send 12 for 12 hours, 48 for 2 days
        `reschedule_time_period` | integer |  optional  | nullable send 12 for 12 hours, 48 for 2 days
        `payout_period` | boolean |  required  | 0 or 1
        `registration_number` | string |  required  | 
        `time_intravel` | integer |  optional  | nullable max 59
    
<!-- END_ca381e2192f90f90cacecfad876c71e1 -->

<!-- START_352d6480aa77de2e0359b82667ec9ec5 -->
## Doctor add bank details

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/doctor/bankdetails" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"bank_account_number":"fugit","bank_account_holder":"molestiae","bank_name":"dolorum","bank_city":"quia","bank_ifsc":"aspernatur","bank_account_type":"velit"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/doctor/bankdetails"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "bank_account_number": "fugit",
    "bank_account_holder": "molestiae",
    "bank_name": "dolorum",
    "bank_city": "quia",
    "bank_ifsc": "aspernatur",
    "bank_account_type": "velit"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "bank_account_number": [
            "The bank account number field is required."
        ],
        "bank_account_holder": [
            "The bank account holder field is required."
        ],
        "bank_name": [
            "The bank name field is required."
        ],
        "bank_city": [
            "The bank city field is required."
        ],
        "bank_ifsc": [
            "The bank ifsc field is required."
        ],
        "bank_account_type": [
            "The bank account type field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Bank Account saved successfully."
}
```

### HTTP Request
`POST api/doctor/bankdetails`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `bank_account_number` | string |  required  | 
        `bank_account_holder` | string |  required  | 
        `bank_name` | string |  required  | 
        `bank_city` | string |  required  | 
        `bank_ifsc` | string |  required  | 
        `bank_account_type` | string |  required  | 
    
<!-- END_352d6480aa77de2e0359b82667ec9ec5 -->

<!-- START_41c318837932001e4ad3e925ab202568 -->
## Doctor get bank details

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/doctor/bankdetails" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/doctor/bankdetails"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "id": 1,
    "bank_account_number": "BANK12345",
    "bank_account_holder": "BANKER",
    "bank_name": "BANK",
    "bank_city": "India",
    "bank_ifsc": "IFSC45098",
    "bank_account_type": "SAVINGS"
}
```
> Example response (404):

```json
{
    "message": "No records found."
}
```

### HTTP Request
`GET api/doctor/bankdetails`


<!-- END_41c318837932001e4ad3e925ab202568 -->

<!-- START_ea84972ef20812872c9d24a0d60d3f79 -->
## Doctor add address

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/doctor/address" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"clinic_name":"temporibus","pincode":5,"street_name":"quas","city_village":"veritatis","district":"temporibus","state":"dolorum","country":"soluta","contact_number":"blanditiis","country_code":"recusandae","pharmacy_list":[],"laboratory_list":[],"latitude":207.131656563,"longitude":2930.2}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/doctor/address"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "clinic_name": "temporibus",
    "pincode": 5,
    "street_name": "quas",
    "city_village": "veritatis",
    "district": "temporibus",
    "state": "dolorum",
    "country": "soluta",
    "contact_number": "blanditiis",
    "country_code": "recusandae",
    "pharmacy_list": [],
    "laboratory_list": [],
    "latitude": 207.131656563,
    "longitude": 2930.2
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "clinic_name": [
            "The clinic name already exists."
        ],
        "pincode": [
            "The pincode must be 6 digits."
        ],
        "street_name": [
            "The street name field is required."
        ],
        "city_village": [
            "The city village field is required."
        ],
        "district": [
            "The district field is required."
        ],
        "state": [
            "The state field is required."
        ],
        "country": [
            "The country field is required."
        ],
        "pharmacy_list": [
            "The pharmacy list must be an array."
        ],
        "laboratory_list": [
            "The laboratory list must be an array."
        ],
        "latitude": [
            "The latitude format is invalid."
        ],
        "longitude": [
            "The longitude format is invalid."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Address added successfully"
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`POST api/doctor/address`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `clinic_name` | string |  required  | 
        `pincode` | integer |  required  | length 6
        `street_name` | string |  required  | Street Name/ House No./ Area
        `city_village` | string |  required  | City/Village
        `district` | string |  required  | 
        `state` | string |  required  | 
        `country` | string |  required  | 
        `contact_number` | string |  optional  | nullable
        `country_code` | string |  optional  | nullable required if contact_number is filled
        `pharmacy_list` | array |  optional  | nullable pharmacy_list[0]=1,pharmacy_list[1]=2
        `laboratory_list` | array |  optional  | nullable laboratory_list[0]=1,laboratory_list[1]=2
        `latitude` | float |  required  | 
        `longitude` | float |  required  | 
    
<!-- END_ea84972ef20812872c9d24a0d60d3f79 -->

<!-- START_2f8497e6f0df8cd8c5366f25deb4a0cf -->
## Doctor edit address

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/doctor/address/1?id=provident" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"clinic_name":"reiciendis","pincode":4,"street_name":"in","city_village":"quo","district":"quae","state":"aliquid","country":"inventore","contact_number":"quia","country_code":"ducimus","pharmacy_list":[],"laboratory_list":[],"latitude":87599.13,"longitude":343916.474}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/doctor/address/1"
);

let params = {
    "id": "provident",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "clinic_name": "reiciendis",
    "pincode": 4,
    "street_name": "in",
    "city_village": "quo",
    "district": "quae",
    "state": "aliquid",
    "country": "inventore",
    "contact_number": "quia",
    "country_code": "ducimus",
    "pharmacy_list": [],
    "laboratory_list": [],
    "latitude": 87599.13,
    "longitude": 343916.474
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "pincode": [
            "The pincode must be 6 digits."
        ],
        "clinic_name": [
            "The clinic name already exists."
        ],
        "street_name": [
            "The street name field is required."
        ],
        "city_village": [
            "The city village field is required."
        ],
        "district": [
            "The district field is required."
        ],
        "state": [
            "The state field is required."
        ],
        "country": [
            "The country field is required."
        ],
        "pharmacy_list": [
            "The pharmacy list must be an array."
        ],
        "laboratory_list": [
            "The laboratory list must be an array."
        ],
        "latitude": [
            "The latitude format is invalid."
        ],
        "longitude": [
            "The longitude format is invalid."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Address updated successfully"
}
```
> Example response (404):

```json
{
    "message": "Address not found"
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`POST api/doctor/address/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of record
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `clinic_name` | string |  required  | 
        `pincode` | integer |  required  | length 6
        `street_name` | string |  required  | Street Name/ House No./ Area
        `city_village` | string |  required  | City/Village
        `district` | string |  required  | 
        `state` | string |  required  | 
        `country` | string |  required  | 
        `contact_number` | string |  optional  | nullable
        `country_code` | string |  optional  | nullable required if contact_number is filled
        `pharmacy_list` | array |  optional  | nullable pharmacy_list[0]=1,pharmacy_list[1]=2
        `laboratory_list` | array |  optional  | nullable laboratory_list[0]=1,laboratory_list[1]=2
        `latitude` | float |  required  | 
        `longitude` | float |  required  | 
    
<!-- END_2f8497e6f0df8cd8c5366f25deb4a0cf -->

<!-- START_222d7d5ad7b55dbc1e8ce7ed91efb026 -->
## Doctor list address

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/doctor/address" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/doctor/address"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "address_type": "CLINIC",
            "street_name": "street name",
            "city_village": "garden",
            "district": "idukki",
            "state": "kerala",
            "country": "India",
            "pincode": "680002",
            "country_code": "+91",
            "contact_number": "9876543210",
            "latitude": "13.06743900",
            "longitude": "80.23761700",
            "clinic_name": "Grace",
            "clinic_info": {
                "address_id": 1,
                "id": 2,
                "pharmacy_list": [
                    "1",
                    "2",
                    "3"
                ],
                "laboratory_id_1": []
            }
        },
        {
            "id": 3,
            "address_type": "CLINIC",
            "street_name": "address 2",
            "city_village": "garden",
            "district": "kollam",
            "state": "kerala",
            "country": "India",
            "pincode": "680002",
            "country_code": "+91",
            "contact_number": "9876543210",
            "latitude": "13.06743900",
            "longitude": "80.23761700",
            "clinic_name": "Grace",
            "clinic_info": {
                "address_id": 3,
                "id": 5,
                "pharmacy_list": [
                    "1",
                    "2",
                    "3"
                ],
                "laboratory_list": [
                    "1",
                    "2",
                    "3"
                ]
            }
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/doctor\/address?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/doctor\/address?page=1",
    "next_page_url": null,
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/doctor\/address",
    "per_page": 20,
    "prev_page_url": null,
    "to": 2,
    "total": 2
}
```
> Example response (404):

```json
{
    "message": "Address not found."
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/doctor/address`


<!-- END_222d7d5ad7b55dbc1e8ce7ed91efb026 -->

<!-- START_2306556c94d63abc5f9d27f58eb8679d -->
## Doctor get address by id

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/doctor/address/1?id=fuga" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/doctor/address/1"
);

let params = {
    "id": "fuga",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "id": 2,
    "address_type": "CLINIC",
    "street_name": "address 2",
    "city_village": "garden",
    "district": "kollam",
    "state": "kerala",
    "country": "India",
    "pincode": "680002",
    "country_code": "+91",
    "contact_number": "9876543210",
    "latitude": "13.06743900",
    "longitude": "80.23761700",
    "clinic_name": "Grace",
    "clinic_info": {
        "address_id": 2,
        "pharmacy_list": [
            "1",
            "2",
            "3"
        ],
        "laboratory_list": [
            "1",
            "2",
            "3"
        ]
    }
}
```
> Example response (404):

```json
{
    "message": "Address not found"
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/doctor/address/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of record

<!-- END_2306556c94d63abc5f9d27f58eb8679d -->

<!-- START_bbf0e42e59591acef4757181a3ece094 -->
## Doctor delete address

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X DELETE \
    "http://localhost/fms-api-laravel/public/api/doctor/address/1?id=animi" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/doctor/address/1"
);

let params = {
    "id": "animi",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "Address deleted successfully"
}
```
> Example response (404):

```json
{
    "message": "Address not found"
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`DELETE api/doctor/address/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of record

<!-- END_bbf0e42e59591acef4757181a3ece094 -->

<!-- START_c311ae4bcb34dd3c9b650bf2e2837edc -->
## Doctor check address has time slots

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/doctor/address/1/check?id=aut" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/doctor/address/1/check"
);

let params = {
    "id": "aut",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "Time slots found."
}
```
> Example response (404):

```json
{
    "message": "Time slots not found."
}
```
> Example response (404):

```json
{
    "message": "Address not found."
}
```

### HTTP Request
`GET api/doctor/address/{id}/check`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of address

<!-- END_c311ae4bcb34dd3c9b650bf2e2837edc -->

<!-- START_4c1e84c63bc872494f4252fef4e11b9e -->
## Doctor list Time slot

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/doctor/timeslot" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/doctor/timeslot"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
[
    {
        "id": 1,
        "day": "FRIDAY",
        "slot_start": "09:30:00",
        "slot_end": "10:30:00",
        "type": "ONLINE",
        "doctor_clinic_id": 1,
        "shift": "MORNING"
    },
    {
        "id": 2,
        "day": "MONDAY",
        "slot_start": "10:30:00",
        "slot_end": "10:45:00",
        "type": "ONLINE",
        "doctor_clinic_id": 1,
        "shift": "MORNING"
    },
    {
        "id": 3,
        "day": "WEDNESDAY",
        "slot_start": "11:00:00",
        "slot_end": "11:30:00",
        "type": "ONLINE",
        "doctor_clinic_id": 1,
        "shift": "MORNING"
    },
    {
        "id": 4,
        "day": "WEDNESDAY",
        "slot_start": "18:30:00",
        "slot_end": "18:40:00",
        "type": "ONLINE",
        "doctor_clinic_id": 3,
        "shift": "EVENING"
    }
]
```
> Example response (404):

```json
{
    "message": "Time slots not found."
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/doctor/timeslot`


<!-- END_4c1e84c63bc872494f4252fef4e11b9e -->

<!-- START_0cca0ed4cd9ecafcbd3a38b5ad27d664 -->
## Doctor get Time slot by id

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/doctor/timeslot/1?id=dolore" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/doctor/timeslot/1"
);

let params = {
    "id": "dolore",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "id": 1,
    "day": "MONDAY",
    "slot_start": "19:45:00",
    "slot_end": "19:55:00",
    "type": "ONLINE",
    "doctor_clinic_id": "1",
    "shift": "MORNING"
}
```
> Example response (404):

```json
{
    "message": "Time slot not found"
}
```

### HTTP Request
`GET api/doctor/timeslot/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of record

<!-- END_0cca0ed4cd9ecafcbd3a38b5ad27d664 -->

<!-- START_e30878bd75a1e5409842739157aa628c -->
## Doctor add / edit Time slot ABANDONED

Authorization: &quot;Bearer {access_token}&quot;

row = array with multiple objects of values

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/doctor/timeslot" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"row":[{"day":"molestiae","slot_start":"qui","slot_end":"nulla","type":"et","shift":"quod","doctor_clinic_id":15}]}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/doctor/timeslot"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "row": [
        {
            "day": "molestiae",
            "slot_start": "qui",
            "slot_end": "nulla",
            "type": "et",
            "shift": "quod",
            "doctor_clinic_id": 15
        }
    ]
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "row.1.day": [
            "The row.1.day field is required."
        ],
        "row.0.slot_start": [
            "The row.0.slot_start field has a duplicate value."
        ],
        "row.1.slot_start": [
            "The row.1.slot_start field has a duplicate value."
        ],
        "row.0.type": [
            "The row.0.type field is required."
        ],
        "row.0.shift": [
            "The row.0.shift field is required."
        ],
        "row.0.doctor_clinic_id": [
            "The row.0.doctor_clinic_id field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Time slots added \/ updated successfully"
}
```

### HTTP Request
`POST api/doctor/timeslot`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `row[0][day]` | string |  required  | anyone of ['MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY']
        `row[0][slot_start]` | time |  required  | format H:i format 24 hours
        `row[0][slot_end]` | time |  required  | format H:i format 24 hours
        `row[0][type]` | string |  required  | anyone of ['OFFLINE', 'ONLINE','BOTH']
        `row[0][shift]` | string |  required  | anyone of ['MORNING', 'AFTERNOON', 'EVENING', 'NIGHT']
        `row[0][doctor_clinic_id]` | integer |  required  | set id from clinic_info from api call https://api.doctor-app.alpha.logidots.com/docs/#doctor-list-address
    
<!-- END_e30878bd75a1e5409842739157aa628c -->

<!-- START_64fdf953818cb73412178f5a58ac5227 -->
## Doctor delete Time slot

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X DELETE \
    "http://localhost/fms-api-laravel/public/api/doctor/timeslot/1?id=voluptatem" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/doctor/timeslot/1"
);

let params = {
    "id": "voluptatem",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "Time slot deleted successfully"
}
```
> Example response (404):

```json
{
    "message": "Time slot not found"
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`DELETE api/doctor/timeslot/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of record

<!-- END_64fdf953818cb73412178f5a58ac5227 -->

<!-- START_651625c39f593b4b3cd44844c9e740e1 -->
## Doctor validate Timeslot to assign off days

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/doctor/validate/timeslot" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"date":"labore","slot_start":"aut","slot_end":"recusandae"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/doctor/validate/timeslot"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "date": "labore",
    "slot_start": "aut",
    "slot_end": "recusandae"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "date": [
            "The date does not match the format Y-m-d."
        ],
        "slot_start": [
            "The slot start field is required."
        ],
        "slot_end": [
            "The slot end does not match the format H:i."
        ]
    }
}
```
> Example response (200):

```json
[
    {
        "id": 1,
        "day": "FRIDAY",
        "slot_start": "09:30:00",
        "slot_end": "10:30:00",
        "type": "ONLINE",
        "doctor_clinic_id": 1,
        "shift": "MORNING"
    },
    {
        "id": 10,
        "day": "FRIDAY",
        "slot_start": "09:30:00",
        "slot_end": "10:30:00",
        "type": "ONLINE",
        "doctor_clinic_id": 2,
        "shift": "MORNING"
    }
]
```
> Example response (200):

```json
{
    "message": true
}
```

### HTTP Request
`POST api/doctor/validate/timeslot`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `date` | date |  required  | 
        `slot_start` | time |  required  | format H:i format 24 hours
        `slot_end` | time |  required  | format H:i format 24 hours
    
<!-- END_651625c39f593b4b3cd44844c9e740e1 -->

<!-- START_74a7b41d8f30172916161b8e1fde2713 -->
## Doctor schedule Offdays

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/doctor/schedule/offdays" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"row":[{"date":"et","slot_start":"ut","slot_end":"vel"}]}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/doctor/schedule/offdays"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "row": [
        {
            "date": "et",
            "slot_start": "ut",
            "slot_end": "vel"
        }
    ]
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (403):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "row.0.date": [
            "The row.0.date field is required."
        ],
        "row.0.slot_start": [
            "The row.0.slot_start does not match the format H:i."
        ],
        "row.0.slot_end": [
            "The row.0.slot_end does not match the format H:i."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Offdays scheduled successfully."
}
```
> Example response (404):

```json
{
    "message": "No inputs given."
}
```

### HTTP Request
`POST api/doctor/schedule/offdays`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `row[0][date]` | date |  required  | format Y-m-d
        `row[0][slot_start]` | time |  required  | format H:i format 24 hours for full dayoff send time as 00:01
        `row[0][slot_end]` | time |  required  | format H:i format 24 hours for full dayoff send time as 23:59
    
<!-- END_74a7b41d8f30172916161b8e1fde2713 -->

<!-- START_ec7a2e1bfe07adec9656f1903b22d386 -->
## Doctor list Offdays

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/doctor/schedule/offdays" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/doctor/schedule/offdays"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "user_id": 1,
            "date": "2020-09-18",
            "day": "FRIDAY",
            "slot_start": "09:30",
            "slot_end": "10:30"
        },
        {
            "id": 2,
            "user_id": 1,
            "date": "2020-09-23",
            "day": "WEDNESDAY",
            "slot_start": "00:01",
            "slot_end": "23:59"
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/doctor\/schedule\/offdays?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/doctor\/schedule\/offdays?page=1",
    "next_page_url": null,
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/doctor\/schedule\/offdays",
    "per_page": 15,
    "prev_page_url": null,
    "to": 2,
    "total": 2
}
```
> Example response (404):

```json
{
    "message": "Offdays not found."
}
```

### HTTP Request
`GET api/doctor/schedule/offdays`


<!-- END_ec7a2e1bfe07adec9656f1903b22d386 -->

<!-- START_130dd99d16192cf09a34e72cad2302bc -->
## Doctor delete Offday

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X DELETE \
    "http://localhost/fms-api-laravel/public/api/doctor/schedule/offdays/1?id=aut" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/doctor/schedule/offdays/1"
);

let params = {
    "id": "aut",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "Offday deleted successfully."
}
```
> Example response (404):

```json
{
    "message": "Offday not found."
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`DELETE api/doctor/schedule/offdays/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of record

<!-- END_130dd99d16192cf09a34e72cad2302bc -->

<!-- START_2863e9955191b5ccc4508fdf71a4c501 -->
## Doctor list Appointments

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/doctor/appointments?filter=dolorum&sortBy=molestiae&orderBy=sed&name=ut&start_date=doloribus&end_date=necessitatibus" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/doctor/appointments"
);

let params = {
    "filter": "dolorum",
    "sortBy": "molestiae",
    "orderBy": "sed",
    "name": "ut",
    "start_date": "doloribus",
    "end_date": "necessitatibus",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 114,
            "doctor_id": 44,
            "patient_id": 3,
            "appointment_unique_id": "AP0000114",
            "date": "2021-01-27",
            "time": "18:00:00",
            "consultation_type": "ONLINE",
            "shift": null,
            "payment_status": null,
            "transaction_id": null,
            "total": null,
            "is_cancelled": 0,
            "is_completed": 0,
            "followup_id": null,
            "booking_date": "2021-01-21",
            "current_patient_info": {
                "user": {
                    "first_name": "Test",
                    "middle_name": null,
                    "last_name": "Patient",
                    "email": "patient@logidots.com",
                    "country_code": "+91",
                    "mobile_number": "9876543210"
                },
                "case": 0,
                "info": {
                    "first_name": "Test",
                    "middle_name": null,
                    "last_name": "Patient",
                    "email": "patient@logidots.com",
                    "country_code": "+91",
                    "mobile_number": "9876543210",
                    "height": 1,
                    "weight": 0,
                    "gender": "MALE",
                    "age": 20
                },
                "address": {
                    "id": 77,
                    "street_name": "Villa",
                    "city_village": "street",
                    "district": "Pathanamthitta",
                    "state": "Kerala",
                    "country": "India",
                    "pincode": "689641",
                    "country_code": null,
                    "contact_number": null,
                    "latitude": null,
                    "longitude": null,
                    "clinic_name": null
                }
            },
            "clinic_address": {
                "id": 5,
                "street_name": "Lane",
                "city_village": "london",
                "district": "Pathanamthitta",
                "state": "Kerala",
                "country": "India",
                "pincode": "689641",
                "country_code": null,
                "contact_number": null,
                "latitude": null,
                "longitude": null,
                "clinic_name": null
            },
            "prescription": null
        },
        {
            "id": 113,
            "doctor_id": 44,
            "patient_id": 3,
            "appointment_unique_id": "AP0000113",
            "date": "2021-01-27",
            "time": "18:30:00",
            "consultation_type": "ONLINE",
            "shift": null,
            "payment_status": null,
            "transaction_id": null,
            "total": null,
            "is_cancelled": 0,
            "is_completed": 0,
            "followup_id": null,
            "booking_date": "2021-01-21",
            "current_patient_info": {
                "user": {
                    "first_name": "Test",
                    "middle_name": null,
                    "last_name": "Patient",
                    "email": "patient@logidots.com",
                    "country_code": "+91",
                    "mobile_number": "9876543210"
                },
                "case": 2,
                "info": {
                    "first_name": "Test",
                    "middle_name": null,
                    "last_name": "Patient",
                    "email": "patient@logidots.com",
                    "country_code": "+91",
                    "mobile_number": "9876543210",
                    "height": 1,
                    "weight": 0,
                    "gender": "MALE",
                    "age": 20
                },
                "address": {
                    "id": 77,
                    "street_name": "Villa",
                    "city_village": "street",
                    "district": "Pathanamthitta",
                    "state": "Kerala",
                    "country": "India",
                    "pincode": "689641",
                    "country_code": null,
                    "contact_number": null,
                    "latitude": null,
                    "longitude": null,
                    "clinic_name": null
                }
            },
            "clinic_address": {
                "id": 5,
                "street_name": "Lane",
                "city_village": "london",
                "district": "Pathanamthitta",
                "state": "Kerala",
                "country": "India",
                "pincode": "689641",
                "country_code": null,
                "contact_number": null,
                "latitude": null,
                "longitude": null,
                "clinic_name": null
            },
            "prescription": null
        },
        {
            "id": 111,
            "doctor_id": 44,
            "patient_id": 3,
            "appointment_unique_id": "AP0000111",
            "date": "2021-01-25",
            "time": "13:16:00",
            "consultation_type": "INCLINIC",
            "shift": null,
            "payment_status": null,
            "transaction_id": null,
            "total": null,
            "is_cancelled": 0,
            "is_completed": 0,
            "followup_id": null,
            "booking_date": "2021-01-21",
            "current_patient_info": {
                "user": {
                    "first_name": "Test",
                    "middle_name": null,
                    "last_name": "Patient",
                    "email": "patient@logidots.com",
                    "country_code": "+91",
                    "mobile_number": "9876543210"
                },
                "case": 1,
                "info": {
                    "first_name": "Test",
                    "middle_name": null,
                    "last_name": "Patient",
                    "email": "patient@logidots.com",
                    "country_code": "+91",
                    "mobile_number": "9876543210",
                    "height": 1,
                    "weight": 0,
                    "gender": "MALE",
                    "age": 20
                },
                "address": {
                    "id": 77,
                    "street_name": "Villa",
                    "city_village": "street",
                    "district": "Pathanamthitta",
                    "state": "Kerala",
                    "country": "India",
                    "pincode": "689641",
                    "country_code": null,
                    "contact_number": null,
                    "latitude": null,
                    "longitude": null,
                    "clinic_name": null
                }
            },
            "clinic_address": {
                "id": 5,
                "street_name": "Lane",
                "city_village": "london",
                "district": "Pathanamthitta",
                "state": "Kerala",
                "country": "India",
                "pincode": "689641",
                "country_code": null,
                "contact_number": null,
                "latitude": null,
                "longitude": null,
                "clinic_name": null
            },
            "prescription": {
                "id": 44,
                "appointment_id": 110,
                "unique_id": "PX0000044",
                "info": {
                    "age": "45",
                    "height": null,
                    "weight": null,
                    "address": null,
                    "symptoms": "some one else fever",
                    "body_temp": null,
                    "diagnosis": "some one else fever",
                    "pulse_rate": null,
                    "bp_systolic": null,
                    "test_search": null,
                    "bp_diastolic": null,
                    "case_summary": "some one else fever",
                    "medicine_search": null,
                    "note_to_patient": null,
                    "diet_instruction": null,
                    "despencing_details": null,
                    "investigation_followup": null
                },
                "created_at": "2021-01-21",
                "pdf_url": null,
                "status_medicine": "Dispensed.",
                "medicinelist": [
                    {
                        "id": 32,
                        "prescription_id": 44,
                        "medicine_id": 1,
                        "pharmacy_id": null,
                        "dosage": "1 - 0 - 0 - 0",
                        "instructions": "some one else fever",
                        "duration": "1 days",
                        "no_of_refill": "0",
                        "substitution_allowed": 0,
                        "medicine_status": "Dispensed at clinic.",
                        "medicine_name": "Ammu",
                        "medicine": {
                            "id": 1,
                            "category_id": 1,
                            "sku": "MED0000001",
                            "composition": "Paracetamol",
                            "weight": 50,
                            "weight_unit": "kg",
                            "name": "Ammu",
                            "manufacturer": "Ammu Corporation",
                            "medicine_type": "Capsules",
                            "drug_type": "Branded",
                            "qty_per_strip": 10,
                            "price_per_strip": 45,
                            "rate_per_unit": 4.5,
                            "rx_required": 0,
                            "short_desc": "This is a good product",
                            "long_desc": "This is a good product",
                            "cart_desc": "This is a good product",
                            "image_name": null,
                            "image_url": null
                        }
                    }
                ]
            }
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/doctor\/appointments?page=1",
    "from": 1,
    "last_page": 5,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/doctor\/appointments?page=5",
    "next_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/doctor\/appointments?page=2",
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/doctor\/appointments",
    "per_page": 4,
    "prev_page_url": null,
    "to": 4,
    "total": 18
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "filter.list": [
            "The selected filter.list is invalid."
        ],
        "orderBy": [
            "The selected order by is invalid."
        ]
    }
}
```
> Example response (404):

```json
{
    "message": "No records found."
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/doctor/appointments`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `filter` |  optional  | nullable array filter[list]=0 for today list filter[list]=1 for future list filter[list]=2 for past list
    `sortBy` |  optional  | nullable any one of (date,id,time)
    `orderBy` |  optional  | nullable any one of (asc,desc)
    `name` |  optional  | nullable string name of patient
    `start_date` |  optional  | nullable date format-> Y-m-d
    `end_date` |  optional  | nullable date format-> Y-m-d

<!-- END_2863e9955191b5ccc4508fdf71a4c501 -->

<!-- START_d53ab29fdaba6f60368a3fc81f0b1457 -->
## Doctor list Appointments by id

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/doctor/appointments/1?id=omnis" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/doctor/appointments/1"
);

let params = {
    "id": "omnis",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "id": 14,
    "doctor_id": 2,
    "patient_id": 3,
    "appointment_unique_id": "AP0000014",
    "date": "2021-01-20",
    "time": "12:05:00",
    "consultation_type": "ONLINE",
    "shift": null,
    "payment_status": null,
    "transaction_id": null,
    "total": null,
    "is_cancelled": 0,
    "is_completed": 0,
    "followup_id": null,
    "booking_date": "2021-01-07",
    "current_patient_info": {
        "user": {
            "first_name": "Test",
            "middle_name": null,
            "last_name": "Patient",
            "email": "patient@logidots.com",
            "country_code": "+91",
            "mobile_number": "9876543210"
        },
        "case": 1,
        "info": {
            "first_name": "Test",
            "middle_name": null,
            "last_name": "Patient",
            "email": "patient@logidots.com",
            "country_code": "+91",
            "mobile_number": "9876543210",
            "height": 1,
            "weight": 0,
            "gender": "MALE",
            "age": 20
        },
        "address": {
            "id": 77,
            "street_name": "Villa",
            "city_village": "street",
            "district": "Pathanamthitta",
            "state": "Kerala",
            "country": "India",
            "pincode": "689641",
            "country_code": null,
            "contact_number": null,
            "latitude": null,
            "longitude": null,
            "clinic_name": null
        }
    },
    "clinic_address": {
        "id": 5,
        "street_name": "Lane",
        "city_village": "london",
        "district": "Pathanamthitta",
        "state": "Kerala",
        "country": "India",
        "pincode": "689641",
        "country_code": null,
        "contact_number": null,
        "latitude": null,
        "longitude": null,
        "clinic_name": null
    },
    "prescription": {
        "id": 15,
        "appointment_id": 14,
        "unique_id": "PX0000015",
        "info": {
            "age": "98",
            "height": "150 cms",
            "weight": "70 Kg",
            "address": "23, Middle Lane, Kollam",
            "symptoms": "Fever",
            "body_temp": "98 C",
            "diagnosis": "Corono",
            "pulse_rate": null,
            "bp_systolic": "50",
            "bp_diastolic": "45",
            "case_summary": "Patient has corono",
            "note_to_Patient": "Drink plenty of water",
            "diet_instruction": "Take food on time",
            "despencing_details": "Despence all medicine",
            "investigation_followup": "f"
        },
        "created_at": "2021-01-12",
        "pdf_url": null,
        "status_medicine": "Dispensed.",
        "medicinelist": [
            {
                "id": 12,
                "prescription_id": 15,
                "medicine_id": 1,
                "quote_generated": 0,
                "dosage": "2",
                "instructions": "Have food",
                "duration": "2 days",
                "no_of_refill": "2",
                "substitution_allowed": 1,
                "medicine_status": "Dispensed at clinic.",
                "medicine_name": "Ammu",
                "medicine": {
                    "id": 1,
                    "category_id": 1,
                    "sku": "MED0000001",
                    "composition": "Paracetamol",
                    "weight": 50,
                    "weight_unit": "kg",
                    "name": "Ammu",
                    "manufacturer": "Ammu Corporation",
                    "medicine_type": "Capsules",
                    "drug_type": "Branded",
                    "qty_per_strip": 10,
                    "price_per_strip": 45,
                    "rate_per_unit": 4.5,
                    "rx_required": 0,
                    "short_desc": "This is a good product",
                    "long_desc": "This is a good product",
                    "cart_desc": "This is a good product",
                    "image_name": null,
                    "image_url": null
                }
            },
            {
                "id": 13,
                "prescription_id": 15,
                "medicine_id": 2,
                "quote_generated": 0,
                "dosage": "2",
                "instructions": "Have food",
                "duration": "2 days",
                "no_of_refill": "2",
                "substitution_allowed": 1,
                "medicine_status": "Dispensed at associated pharmacy.",
                "medicine_name": "test",
                "medicine": {
                    "id": 2,
                    "category_id": 1,
                    "sku": "MED0000002",
                    "composition": "water",
                    "weight": 12,
                    "weight_unit": "g",
                    "name": "test",
                    "manufacturer": "dndnd",
                    "medicine_type": "Capsules",
                    "drug_type": "Generic",
                    "qty_per_strip": 3,
                    "price_per_strip": 10,
                    "rate_per_unit": 12,
                    "rx_required": 0,
                    "short_desc": "good",
                    "long_desc": "null",
                    "cart_desc": "cart good",
                    "image_name": "medicine.png",
                    "image_url": null
                }
            }
        ]
    }
}
```
> Example response (404):

```json
{
    "message": "Appointment not found."
}
```

### HTTP Request
`GET api/doctor/appointments/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of appointment_id

<!-- END_d53ab29fdaba6f60368a3fc81f0b1457 -->

<!-- START_68a4a443df345a46c6c9a81a6f23a312 -->
## Doctor complete appointment by id

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/doctor/appointments/complete" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"appointment_id":"atque","comment":"dolor"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/doctor/appointments/complete"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "appointment_id": "atque",
    "comment": "dolor"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "appointment_id": [
            "The appointment id field is required."
        ],
        "comment": [
            "The comment field must be present."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Appointment completed successfully."
}
```
> Example response (403):

```json
{
    "message": "Appointment has been already cancelled."
}
```
> Example response (403):

```json
{
    "message": "Appointment has been already completed."
}
```

### HTTP Request
`POST api/doctor/appointments/complete`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `appointment_id` | required |  optional  | integer id of appointment
        `comment` | string |  optional  | comment present PNS,Completed
    
<!-- END_68a4a443df345a46c6c9a81a6f23a312 -->

<!-- START_1fbba4323c8e2bf390f67152e11cced8 -->
## Doctor get patient profile

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/doctor/patient/profile/1?id=sit" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/doctor/patient/profile/1"
);

let params = {
    "id": "sit",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "id": 1,
    "user_id": 3,
    "patient_unique_id": "P0000001",
    "title": "mr",
    "gender": "MALE",
    "date_of_birth": "1998-06-19",
    "age": 22,
    "blood_group": "B+ve",
    "height": null,
    "weight": null,
    "marital_status": null,
    "occupation": null,
    "alt_country_code": "+91",
    "alt_mobile_number": "5453",
    "current_medication": null,
    "bpl_file_number": null,
    "bpl_file_name": null,
    "first_name": "Ben",
    "middle_name": "john",
    "last_name": "phil",
    "email": "patient@logidots.com",
    "country_code": "+91",
    "mobile_number": "7591985089",
    "username": "patient",
    "patient_profile_photo": null,
    "address": [
        {
            "id": 75,
            "street_name": "Middle",
            "city_village": "lane",
            "district": "london",
            "state": "state",
            "country": "india",
            "pincode": "627354",
            "country_code": "+91",
            "contact_number": "0987654321",
            "latitude": null,
            "longitude": null,
            "clinic_name": null
        },
        {
            "id": 76,
            "street_name": "Middle",
            "city_village": "lane",
            "district": "london",
            "state": "state",
            "country": "india",
            "pincode": "627354",
            "country_code": "+91",
            "contact_number": "0987654321",
            "latitude": null,
            "longitude": null,
            "clinic_name": null
        }
    ]
}
```
> Example response (404):

```json
{
    "message": "No records found."
}
```

### HTTP Request
`GET api/doctor/patient/profile/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of patient

<!-- END_1fbba4323c8e2bf390f67152e11cced8 -->

<!-- START_de4fffbd8ac6ce9e2d681e1ac2171e8e -->
## Doctor list patient social history

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/doctor/patient/socialhistory?patient_id=id&appointment_id=corrupti&name=debitis&date=voluptatem" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/doctor/patient/socialhistory"
);

let params = {
    "patient_id": "id",
    "appointment_id": "corrupti",
    "name": "debitis",
    "date": "voluptatem",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "unique_id": "PSH0000001",
            "details": "This patient has covid 20",
            "date": "2020-10-29",
            "doctor_name": "Jos"
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/doctor\/patient\/socialhistory?page=1",
    "from": 1,
    "last_page": 2,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/doctor\/patient\/socialhistory?page=2",
    "next_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/doctor\/patient\/socialhistory?page=2",
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/doctor\/patient\/socialhistory",
    "per_page": 1,
    "prev_page_url": null,
    "to": 1,
    "total": 2
}
```
> Example response (404):

```json
{
    "message": "No records found."
}
```

### HTTP Request
`GET api/doctor/patient/socialhistory`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `patient_id` |  required  | integer
    `appointment_id` |  required  | integer
    `name` |  optional  | nullable string name of patient
    `date` |  optional  | nullable date format-> Y-m-d

<!-- END_de4fffbd8ac6ce9e2d681e1ac2171e8e -->

<!-- START_a5951f664841c1a9cd6aecfb9b17d379 -->
## Doctor list patient family history

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/doctor/patient/familyhistory?patient_id=quo&appointment_id=culpa&name=ratione&date=ipsa" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/doctor/patient/familyhistory"
);

let params = {
    "patient_id": "quo",
    "appointment_id": "culpa",
    "name": "ratione",
    "date": "ipsa",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "unique_id": "PFH0000001",
            "details": "This patient has covid 19",
            "date": "2020-10-29",
            "doctor_name": "Jos"
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/doctor\/patient\/familyhistory?page=1",
    "from": 1,
    "last_page": 2,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/doctor\/patient\/familyhistory?page=2",
    "next_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/doctor\/patient\/familyhistory?page=2",
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/doctor\/patient\/familyhistory",
    "per_page": 1,
    "prev_page_url": null,
    "to": 1,
    "total": 2
}
```
> Example response (404):

```json
{
    "message": "No records found."
}
```

### HTTP Request
`GET api/doctor/patient/familyhistory`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `patient_id` |  required  | integer
    `appointment_id` |  required  | integer
    `name` |  optional  | nullable string name of patient
    `date` |  optional  | nullable date format-> Y-m-d

<!-- END_a5951f664841c1a9cd6aecfb9b17d379 -->

<!-- START_2920e5ecc89e3e5bfa44980cf2f067d9 -->
## Doctor list patient allergic details

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/doctor/patient/allergicdetails?patient_id=animi&appointment_id=et&name=nostrum&date=a" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/doctor/patient/allergicdetails"
);

let params = {
    "patient_id": "animi",
    "appointment_id": "et",
    "name": "nostrum",
    "date": "a",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "unique_id": "PAD0000001",
            "details": "This patient has covid 19 up",
            "date": "2020-10-29",
            "doctor_name": "Jos"
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/doctor\/patient\/allergicdetails?page=1",
    "from": 1,
    "last_page": 2,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/doctor\/patient\/allergicdetails?page=2",
    "next_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/doctor\/patient\/allergicdetails?page=2",
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/doctor\/patient\/allergicdetails",
    "per_page": 1,
    "prev_page_url": null,
    "to": 1,
    "total": 2
}
```
> Example response (404):

```json
{
    "message": "No records found."
}
```

### HTTP Request
`GET api/doctor/patient/allergicdetails`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `patient_id` |  required  | integer
    `appointment_id` |  required  | integer
    `name` |  optional  | nullable string name of patient
    `date` |  optional  | nullable date format-> Y-m-d

<!-- END_2920e5ecc89e3e5bfa44980cf2f067d9 -->

<!-- START_5387fd4ba2bc259b55b14fb9f52027d0 -->
## Doctor add patient social history

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/doctor/patient/socialhistory" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"patient_id":13,"appointment_id":8,"details":"ut"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/doctor/patient/socialhistory"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "patient_id": 13,
    "appointment_id": 8,
    "details": "ut"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "patient_id": [
            "The patient id field is required."
        ],
        "appointment_id": [
            "The appointment id field is required."
        ],
        "details": [
            "The details field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Details saved successfully."
}
```

### HTTP Request
`POST api/doctor/patient/socialhistory`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `patient_id` | integer |  required  | 
        `appointment_id` | integer |  required  | 
        `details` | string |  required  | 
    
<!-- END_5387fd4ba2bc259b55b14fb9f52027d0 -->

<!-- START_0a9252199a3b10e8efca213775f846f4 -->
## Doctor add patient family history

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/doctor/patient/familyhistory" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"patient_id":5,"appointment_id":3,"details":"asperiores"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/doctor/patient/familyhistory"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "patient_id": 5,
    "appointment_id": 3,
    "details": "asperiores"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "patient_id": [
            "The patient id field is required."
        ],
        "appointment_id": [
            "The appointment id field is required."
        ],
        "details": [
            "The details field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Details saved successfully."
}
```

### HTTP Request
`POST api/doctor/patient/familyhistory`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `patient_id` | integer |  required  | 
        `appointment_id` | integer |  required  | 
        `details` | string |  required  | 
    
<!-- END_0a9252199a3b10e8efca213775f846f4 -->

<!-- START_ca94b53195379e3141d083a20a42456d -->
## Doctor add patient allergic details

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/doctor/patient/allergicdetails" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"patient_id":16,"appointment_id":15,"details":"quia"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/doctor/patient/allergicdetails"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "patient_id": 16,
    "appointment_id": 15,
    "details": "quia"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "patient_id": [
            "The patient id field is required."
        ],
        "appointment_id": [
            "The appointment id field is required."
        ],
        "details": [
            "The details field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Details saved successfully."
}
```

### HTTP Request
`POST api/doctor/patient/allergicdetails`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `patient_id` | integer |  required  | 
        `appointment_id` | integer |  required  | 
        `details` | string |  required  | 
    
<!-- END_ca94b53195379e3141d083a20a42456d -->

<!-- START_9c59e4f8f57057d5dab5ab440c1ae621 -->
## Doctor add Prescription

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/doctor/prescription" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"appointment_id":3,"info":{"address":"doloremque","body_temp":"ipsa","age":"repellat","pulse_rate":3,"bp_diastolic":"aperiam","bp_systolic":"enim","height":"repellat","weight":"dolores","case_summary":"fugiat","symptoms":"exercitationem","diagnosis":"omnis","note_to_patient":"laudantium","diet_instruction":"nesciunt","despencing_details":"atque","investigation_followup":"explicabo"},"medicine_list":[{"dosage":"nulla","no_of_refill":20,"duration":"illo","substitution_allowed":true,"instructions":"aperiam","medicine_id":9,"status":5,"pharmacy_id":"sed","note":"quia"}],"test_list":[{"status":5,"test_id":"deleniti","laboratory_id":"animi","instructions":"non","note":"quo"}],"followup_date":"esse"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/doctor/prescription"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "appointment_id": 3,
    "info": {
        "address": "doloremque",
        "body_temp": "ipsa",
        "age": "repellat",
        "pulse_rate": 3,
        "bp_diastolic": "aperiam",
        "bp_systolic": "enim",
        "height": "repellat",
        "weight": "dolores",
        "case_summary": "fugiat",
        "symptoms": "exercitationem",
        "diagnosis": "omnis",
        "note_to_patient": "laudantium",
        "diet_instruction": "nesciunt",
        "despencing_details": "atque",
        "investigation_followup": "explicabo"
    },
    "medicine_list": [
        {
            "dosage": "nulla",
            "no_of_refill": 20,
            "duration": "illo",
            "substitution_allowed": true,
            "instructions": "aperiam",
            "medicine_id": 9,
            "status": 5,
            "pharmacy_id": "sed",
            "note": "quia"
        }
    ],
    "test_list": [
        {
            "status": 5,
            "test_id": "deleniti",
            "laboratory_id": "animi",
            "instructions": "non",
            "note": "quo"
        }
    ],
    "followup_date": "esse"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "info.case_summary": [
            "The case summary field is required."
        ],
        "info.symptoms": [
            "The current symptoms field is required."
        ],
        "info.diagnosis": [
            "The diagnosis field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Prescription saved successfully."
}
```
> Example response (403):

```json
{
    "message": "Prescription can't be filled before appointment time."
}
```

### HTTP Request
`POST api/doctor/prescription`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `appointment_id` | integer |  required  | 
        `info` | array |  required  | 
        `info.address` | string |  optional  | nullable present
        `info.body_temp` | string |  optional  | nullable present
        `info.age` | string |  required  | 
        `info.pulse_rate` | integer |  optional  | nullable present
        `info.bp_diastolic` | string |  optional  | nullable present
        `info.bp_systolic` | string |  optional  | nullable present
        `info.height` | string |  optional  | nullable present
        `info.weight` | string |  optional  | nullable present
        `info.case_summary` | string |  required  | 
        `info.symptoms` | string |  required  | 
        `info.diagnosis` | string |  required  | 
        `info.note_to_patient` | string |  optional  | nullable present
        `info.diet_instruction` | string |  optional  | nullable present
        `info.despencing_details` | string |  optional  | nullable present
        `info.investigation_followup` | string |  optional  | nullable present
        `medicine_list` | array |  optional  | nullable present
        `medicine_list.*.dosage` | string |  required  | 
        `medicine_list.*.no_of_refill` | integer |  required  | 
        `medicine_list.*.duration` | string |  required  | 
        `medicine_list.*.substitution_allowed` | boolean |  required  | 0 or 1
        `medicine_list.*.instructions` | string |  optional  | nullable present
        `medicine_list.*.medicine_id` | integer |  required  | id of medicine
        `medicine_list.*.status` | integer |  required  | 0,1,2 where 0 => dispensed at clinic, 1 => dispensed at associated pharmacy, 2 => Dispensed outside
        `medicine_list.*.pharmacy_id` | required_if |  optional  | medicine_list.*.status is 1
        `medicine_list.*.note` | string |  optional  | nullable present
        `test_list` | array |  optional  | nullable present
        `test_list.*.status` | integer |  required  | 0,1,2 where 0 => dispensed at clinic, 1 => dispensed at associated laboratory, 2 => Dispensed outside
        `test_list.*.test_id` | interger |  required  | id of test
        `test_list.*.laboratory_id` | required_if |  optional  | test_list.*.status is 1
        `test_list.*.instructions` | string |  optional  | nullable present
        `test_list.*.note` | string |  optional  | nullable present
        `followup_date` | data |  optional  | present format -> Y-m-d
    
<!-- END_9c59e4f8f57057d5dab5ab440c1ae621 -->

<!-- START_91f96fb3f24deebf5ca97f9d501d1814 -->
## Doctor get associated Pharmacy

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/doctor/associated/pharmacy" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"address_id":"voluptatem"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/doctor/associated/pharmacy"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "address_id": "voluptatem"
}

fetch(url, {
    method: "GET",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
[
    {
        "id": 1,
        "pharmacy_name": "Pharmacy Name",
        "dl_file": null,
        "reg_certificate": null
    }
]
```
> Example response (404):

```json
{
    "message": "No records found."
}
```

### HTTP Request
`GET api/doctor/associated/pharmacy`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `address_id` | required |  optional  | integer id of Address
    
<!-- END_91f96fb3f24deebf5ca97f9d501d1814 -->

<!-- START_1153ec78883669f75b577314abf044c4 -->
## Doctor get associated Laboratory

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/doctor/associated/laboratory" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"address_id":"similique"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/doctor/associated/laboratory"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "address_id": "similique"
}

fetch(url, {
    method: "GET",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
[
    {
        "id": 1,
        "laboratory_name": "Laboratory Name",
        "lab_file": null
    }
]
```
> Example response (404):

```json
{
    "message": "No records found."
}
```

### HTTP Request
`GET api/doctor/associated/laboratory`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `address_id` | required |  optional  | integer id of Address
    
<!-- END_1153ec78883669f75b577314abf044c4 -->

<!-- START_8fe7c10eadd489d9dade48ad85f3f12a -->
## Doctor list payouts

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/doctor/payouts?paid=quo" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/doctor/payouts"
);

let params = {
    "paid": "quo",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "paid": [
            "The paid field must be present."
        ]
    }
}
```
> Example response (200):

```json
{
    "next_payout_period": "31 March 2021 11:59 PM",
    "current_page": 1,
    "data": [
        {
            "id": 3,
            "doctor_id": 2,
            "patient_id": 3,
            "appointment_unique_id": "AP0000003",
            "date": "2021-03-04",
            "time": "13:45:00",
            "consultation_type": "ONLINE",
            "shift": null,
            "payment_status": "Paid",
            "total": 606,
            "commission": 0,
            "tax": 0,
            "is_cancelled": 0,
            "is_completed": 1,
            "followup_id": null,
            "booking_date": "2021-03-04",
            "current_patient_info": {
                "user": {
                    "first_name": "Test",
                    "middle_name": "middle",
                    "last_name": "Patient",
                    "email": "patient@logidots.com",
                    "country_code": "+91",
                    "mobile_number": "9876543210",
                    "profile_photo_url": null
                },
                "case": 1,
                "info": {
                    "first_name": "Test",
                    "middle_name": "middle",
                    "last_name": "Patient",
                    "email": "patient@logidots.com",
                    "country_code": "+91",
                    "mobile_number": "9876543210",
                    "height": 0,
                    "weight": 0,
                    "gender": "MALE",
                    "age": 0
                },
                "address": {
                    "id": 16,
                    "street_name": "vekam",
                    "city_village": "alappuzha",
                    "district": "Alappuzha",
                    "state": "Kerala",
                    "country": "India",
                    "pincode": "688004",
                    "country_code": null,
                    "contact_number": "8281837601",
                    "land_mark": "near statue",
                    "latitude": null,
                    "longitude": null,
                    "clinic_name": null
                }
            },
            "payments": {
                "id": 3,
                "unique_id": "PAY0000003",
                "total_amount": 606,
                "payment_status": "Paid",
                "created_at": "2021-03-04 07:14:07 pm"
            }
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/doctor\/payouts?page=1",
    "from": 1,
    "last_page": 29,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/doctor\/payouts?page=29",
    "next_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/doctor\/payouts?page=2",
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/doctor\/payouts",
    "per_page": 1,
    "prev_page_url": null,
    "to": 1,
    "total": 29
}
```
> Example response (404):

```json
{
    "message": "No records found."
}
```

### HTTP Request
`GET api/doctor/payouts`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `paid` |  optional  | present integer 0 for unpaid , 1 for paid

<!-- END_8fe7c10eadd489d9dade48ad85f3f12a -->

<!-- START_f0c2aef8da00433c0e1a14dad6c764a4 -->
## Doctor list Working Hours

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/doctor/workinghours?day=pariatur" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/doctor/workinghours"
);

let params = {
    "day": "pariatur",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "day": [
            "The day field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "data": [
        {
            "shift": "EVENING",
            "type": "OFFLINE",
            "day": "TUESDAY",
            "working_hours": [
                {
                    "slot_end": "17:30",
                    "slot_start": "17:00"
                },
                {
                    "slot_end": "16:30",
                    "slot_start": "16:00"
                }
            ],
            "address": {
                "id": 1,
                "street_name": "South Road",
                "city_village": "Edamattom",
                "district": "Kottayam",
                "state": "Kerala",
                "country": "India",
                "pincode": "686575",
                "country_code": null,
                "contact_number": null,
                "land_mark": null,
                "latitude": "10.53034500",
                "longitude": "76.21472900",
                "clinic_name": "cronin",
                "laravel_through_key": 1
            }
        }
    ],
    "time_intravel": 10
}
```
> Example response (404):

```json
{
    "message": "Working Hours not found."
}
```

### HTTP Request
`GET api/doctor/workinghours`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `day` |  required  | string anyone of ['MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY']

<!-- END_f0c2aef8da00433c0e1a14dad6c764a4 -->

<!-- START_cbd2c10f74afe5a3d2f7b6e689354380 -->
## Doctor add / edit working hours

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/doctor/workinghours" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"day":"quia","shift":"sint","type":"iure","doctor_clinic_id":1,"working_hours":[{"slot_start":"aut","slot_end":"illum"}]}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/doctor/workinghours"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "day": "quia",
    "shift": "sint",
    "type": "iure",
    "doctor_clinic_id": 1,
    "working_hours": [
        {
            "slot_start": "aut",
            "slot_end": "illum"
        }
    ]
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "working_hours": [
            "The working hours field is required."
        ],
        "day": [
            "The day field is required."
        ],
        "shift": [
            "The shift field is required."
        ],
        "doctor_clinic_id": [
            "The doctor clinic id field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Working hours added \/ updated successfully."
}
```

### HTTP Request
`POST api/doctor/workinghours`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `day` | string |  required  | anyone of ['MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY']
        `shift` | string |  required  | anyone of ['MORNING', 'AFTERNOON', 'EVENING', 'NIGHT']
        `type` | string |  required  | anyone of ['OFFLINE', 'ONLINE','BOTH']
        `doctor_clinic_id` | integer |  required  | set id from clinic_info from api call https://api.doctor-app.alpha.logidots.com/docs/#doctor-list-address
        `working_hours[0][slot_start]` | time |  required  | format H:i format 24 hours
        `working_hours[0][slot_end]` | time |  required  | format H:i format 24 hours
    
<!-- END_cbd2c10f74afe5a3d2f7b6e689354380 -->

#Ecommerce


<!-- START_a90eda176f2a57b8e028b8970753aa97 -->
## Cart checkout

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/ecommerce/checkout" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"cart_id":10,"prescription_file":"adipisci"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/ecommerce/checkout"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "cart_id": 10,
    "prescription_file": "adipisci"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "cart_id": [
            "The cart id field is required."
        ],
        "prescription_file": [
            "The prescription file must be a file.",
            "The prescription file must be a file of type: jpg, jpeg, png, pdf."
        ]
    }
}
```
> Example response (200):

```json
{
    "prescription_id": 49
}
```
> Example response (422):

```json
{
    "message": "Something went wrong."
}
```

### HTTP Request
`POST api/ecommerce/checkout`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `cart_id` | integer |  required  | 
        `prescription_file` | file |  optional  | nullable File mime:pdf,jpg,jpeg,png size max 2mb
    
<!-- END_a90eda176f2a57b8e028b8970753aa97 -->

#Employee


<!-- START_122597330c0d1cd1b170c5dd5850855a -->
## Employee get profile details

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/employee/profile" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/employee/profile"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "id": 3,
    "unique_id": "EMP0000003",
    "father_first_name": "dad",
    "father_middle_name": "dad midle",
    "father_last_name": "dad last",
    "date_of_birth": "1995-10-10",
    "age": 25,
    "date_of_joining": "2020-10-10",
    "gender": "MALE",
    "user": {
        "id": 33,
        "first_name": "Employee",
        "middle_name": "middle",
        "last_name": "last",
        "email": "employee@logidots",
        "username": "Emp5f9c0972bf270",
        "country_code": "+91",
        "mobile_number": "9876543288",
        "user_type": "EMPLOYEE",
        "is_active": "0",
        "profile_photo_url": null
    },
    "address": [
        {
            "id": 75,
            "street_name": "Lane",
            "city_village": "land",
            "district": "CA",
            "state": "KL",
            "country": "IN",
            "pincode": "654321",
            "country_code": null,
            "contact_number": null,
            "latitude": null,
            "longitude": null,
            "clinic_name": null
        }
    ]
}
```
> Example response (404):

```json
{
    "message": "Details not found."
}
```

### HTTP Request
`GET api/employee/profile`


<!-- END_122597330c0d1cd1b170c5dd5850855a -->

#General


<!-- START_ea7a49b806e375f38de290c6805f7e9b -->
## List Category

Authorization: &quot;Bearer {access_token}&quot;

> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/guest/category?paginate=ex" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/guest/category"
);

let params = {
    "paginate": "ex",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "parent_id": null,
            "name": "Para"
        },
        {
            "id": 2,
            "parent_id": 1,
            "name": "Paracita"
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/admin\/category?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/admin\/category?page=1",
    "next_page_url": null,
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/admin\/category",
    "per_page": 10,
    "prev_page_url": null,
    "to": 2,
    "total": 2
}
```
> Example response (200):

```json
[
    {
        "id": 1,
        "parent_id": null,
        "name": "Para"
    },
    {
        "id": 2,
        "parent_id": 1,
        "name": "Paracita"
    }
]
```
> Example response (404):

```json
{
    "message": "Categories not found"
}
```

### HTTP Request
`GET api/guest/category`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `paginate` |  optional  | nullable integer nullable paginate = 0

<!-- END_ea7a49b806e375f38de290c6805f7e9b -->

<!-- START_eba8aab7a2d8e305b562c02e422b1edf -->
## Get Medicine details by Id

> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/medicine/1?id=consequatur" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/medicine/1"
);

let params = {
    "id": "consequatur",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "id": 11,
    "category_id": 1,
    "sku": "MED0000011",
    "composition": "paracet",
    "weight": 0.5,
    "weight_unit": "mg",
    "name": "Crocin",
    "manufacturer": "Inc",
    "medicine_type": "Tablet",
    "drug_type": "Generic",
    "qty_per_strip": 10,
    "price_per_strip": 200,
    "rate_per_unit": 10,
    "rx_required": 1,
    "short_desc": "Take for fever",
    "long_desc": null,
    "cart_desc": null,
    "image_name": null,
    "image_url": null,
    "category": {
        "id": 1,
        "parent_id": null,
        "name": "Tablet",
        "image_url": null
    }
}
```
> Example response (404):

```json
{
    "message": "Medicine not found."
}
```

### HTTP Request
`GET api/medicine/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of medicine

<!-- END_eba8aab7a2d8e305b562c02e422b1edf -->

<!-- START_0902f4c0ce3d9830f767b3984f812264 -->
## Download Prescription pdf

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/pdf/download?appointment_id=consequatur" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/pdf/download"
);

let params = {
    "appointment_id": "consequatur",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "file": "file downloads directly"
}
```
> Example response (404):

```json
{
    "message": "File not found."
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "appointment_id": [
            "The selected appointment id is invalid."
        ]
    }
}
```

### HTTP Request
`GET api/pdf/download`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `appointment_id` |  required  | integer id of appointment

<!-- END_0902f4c0ce3d9830f767b3984f812264 -->

<!-- START_5eeb012e5ff96226669b8e6a9175287e -->
## Get Pharamacies, Laboratory based on the given coordinates and distance

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/search/pharmacy" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"latitude":"dolorem","longitude":"aut","radius":"iusto"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/search/pharmacy"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "latitude": "dolorem",
    "longitude": "aut",
    "radius": "iusto"
}

fetch(url, {
    method: "GET",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 2,
            "street_name": "South Road",
            "city_village": "Edamattom",
            "district": "Kottayam",
            "state": "Kerala",
            "country": "India",
            "pincode": "686575",
            "distance": 5.583404514320457,
            "laboratory": {
                "id": 2,
                "laboratory_name": "Laboratory Name",
                "lab_file": null
            }
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/search\/laboratory?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/search\/laboratory?page=1",
    "next_page_url": null,
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/search\/laboratory",
    "per_page": 10,
    "prev_page_url": null,
    "to": 2,
    "total": 1
}
```

### HTTP Request
`GET api/search/pharmacy`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `latitude` | numeric |  required  | latitude
        `longitude` | numeric |  required  | longitude
        `radius` | numeric |  required  | send in meters
    
<!-- END_5eeb012e5ff96226669b8e6a9175287e -->

<!-- START_0a52dbddd7571bc886aa537f06ce37d4 -->
## Get Pharamacies, Laboratory based on the given coordinates and distance

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/search/laboratory" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"latitude":"et","longitude":"velit","radius":"facilis"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/search/laboratory"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "latitude": "et",
    "longitude": "velit",
    "radius": "facilis"
}

fetch(url, {
    method: "GET",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 2,
            "street_name": "South Road",
            "city_village": "Edamattom",
            "district": "Kottayam",
            "state": "Kerala",
            "country": "India",
            "pincode": "686575",
            "distance": 5.583404514320457,
            "laboratory": {
                "id": 2,
                "laboratory_name": "Laboratory Name",
                "lab_file": null
            }
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/search\/laboratory?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/search\/laboratory?page=1",
    "next_page_url": null,
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/search\/laboratory",
    "per_page": 10,
    "prev_page_url": null,
    "to": 2,
    "total": 1
}
```

### HTTP Request
`GET api/search/laboratory`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `latitude` | numeric |  required  | latitude
        `longitude` | numeric |  required  | longitude
        `radius` | numeric |  required  | send in meters
    
<!-- END_0a52dbddd7571bc886aa537f06ce37d4 -->

<!-- START_86af124455049c0bd92b0ce8d0e95082 -->
## Add profile photo

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/profile/photo" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"profile_photo":"ipsum"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/profile/photo"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "profile_photo": "ipsum"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "profile_photo": [
            "The profile photo field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Profile photo updated successfully."
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`POST api/profile/photo`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `profile_photo` | file |  optional  | nullable File mime:jpg,jpeg,png size max 2mb
    
<!-- END_86af124455049c0bd92b0ce8d0e95082 -->

<!-- START_2b014ca1b05621660a8d210731e050c9 -->
## Geocoding

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/geocoding" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"address":"est"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/geocoding"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "address": "est"
}

fetch(url, {
    method: "GET",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "latitude": 8.5847419,
    "longitude": 76.8376797
}
```
> Example response (422):

```json
{
    "message": "Maps API error."
}
```
> Example response (422):

```json
{
    "message": "The address given is invalid."
}
```

### HTTP Request
`GET api/geocoding`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `address` | string |  required  | 
    
<!-- END_2b014ca1b05621660a8d210731e050c9 -->

<!-- START_a040fa3cbe6285e36487b839ed20b218 -->
## Reverse Geocoding

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/reversegeocoding" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"type":"voluptas","latitude":"sit","longitude":"officiis"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/reversegeocoding"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "type": "voluptas",
    "latitude": "sit",
    "longitude": "officiis"
}

fetch(url, {
    method: "GET",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "country": "India",
    "state": "Kerala",
    "city": "Chalavara",
    "postal_code": "679335",
    "route": "Unnamed Road",
    "county": "Palakkad"
}
```
> Example response (422):

```json
{
    "message": "Maps API error."
}
```
> Example response (422):

```json
{
    "message": "The address given is invalid."
}
```

### HTTP Request
`GET api/reversegeocoding`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `type` | string |  required  | anyone of CLINIC,LABORATORY,PHARMACY
        `latitude` | numeric |  required  | latitude
        `longitude` | numeric |  required  | longitude
    
<!-- END_a040fa3cbe6285e36487b839ed20b218 -->

<!-- START_ebf23c86366103c793ed67de3f736ee6 -->
## Validate Address

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/address/validate" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"pincode":11,"street_name":"non","city_village":"qui","district":"animi","state":"repellendus","country_code":"et","latitude":1506.87690413,"longitude":17.961981}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/address/validate"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "pincode": 11,
    "street_name": "non",
    "city_village": "qui",
    "district": "animi",
    "state": "repellendus",
    "country_code": "et",
    "latitude": 1506.87690413,
    "longitude": 17.961981
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "pincode": [
            "The pincode field is required."
        ],
        "street_name": [
            "The street name field is required."
        ],
        "city_village": [
            "The city village field is required."
        ],
        "district": [
            "The district field is required."
        ],
        "state": [
            "The state field is required."
        ],
        "country": [
            "The country field is required."
        ],
        "latitude": [
            "The latitude field is required."
        ],
        "longitude": [
            "The longitude field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": true
}
```
> Example response (200):

```json
{
    "message": false
}
```
> Example response (422):

```json
{
    "message": "The address given is invalid."
}
```
> Example response (422):

```json
{
    "message": "Maps API error."
}
```
> Example response (422):

```json
{
    "message": "The address given is invalid."
}
```

### HTTP Request
`POST api/address/validate`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `pincode` | integer |  required  | length 6
        `street_name` | string |  required  | Street Name/ House No./ Area
        `city_village` | string |  required  | City/Village
        `district` | string |  required  | 
        `state` | string |  required  | 
        `country_code` | string |  optional  | nullable required if contact_number is filled
        `latitude` | float |  required  | 
        `longitude` | float |  required  | 
    
<!-- END_ebf23c86366103c793ed67de3f736ee6 -->

<!-- START_375eee5326d68004f193f6b42de328ac -->
## Get Doctor list for pharmacy and laboratory

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/list/doctor" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/list/doctor"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
[
    {
        "id": 2,
        "first_name": "Theophilus",
        "last_name": "Simeon",
        "middle_name": "Jos",
        "profile_photo_url": null
    },
    {
        "id": 31,
        "first_name": "Stephen",
        "middle_name": "Jos",
        "last_name": "Nedumaplly",
        "profile_photo_url": null
    }
]
```
> Example response (404):

```json
{
    "message": "No records found."
}
```

### HTTP Request
`GET api/list/doctor`


<!-- END_375eee5326d68004f193f6b42de328ac -->

<!-- START_7ce818fd5531f04c89d941b3479d533a -->
## List Taxes

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/tax?paginate=nisi" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/tax"
);

let params = {
    "paginate": "nisi",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "name": "GST",
            "percent": 18
        },
        {
            "id": 2,
            "name": "SGST",
            "percent": 9
        },
        {
            "id": 3,
            "name": "CGST",
            "percent": 9
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/admin\/tax?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/admin\/tax?page=1",
    "next_page_url": null,
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/admin\/tax",
    "per_page": 10,
    "prev_page_url": null,
    "to": 3,
    "total": 3
}
```
> Example response (404):

```json
{
    "message": "Taxes not found."
}
```

### HTTP Request
`GET api/tax`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `paginate` |  optional  | nullable integer nullable paginate = 0

<!-- END_7ce818fd5531f04c89d941b3479d533a -->

<!-- START_49adf837ec2c5a6b890f37ff5e4d8ad9 -->
## List Tax Service

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/taxservice?paginate=ipsa" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/taxservice"
);

let params = {
    "paginate": "ipsa",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
[
    {
        "id": 7,
        "unique_id": "TS0007",
        "name": "Lab test Lab",
        "taxes": null
    },
    {
        "id": 8,
        "unique_id": "TS0008",
        "name": "Offline charges",
        "taxes": [
            "1",
            "2"
        ]
    }
]
```
> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 7,
            "unique_id": "TS0007",
            "name": "Lab test Lab",
            "taxes": null
        },
        {
            "id": 8,
            "unique_id": "TS0008",
            "name": "Offline charges",
            "taxes": [
                "1",
                "2"
            ]
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/taxservice?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/taxservice?page=1",
    "next_page_url": null,
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/taxservice",
    "per_page": 10,
    "prev_page_url": null,
    "to": 8,
    "total": 8
}
```
> Example response (404):

```json
{
    "message": "Tax service not found"
}
```

### HTTP Request
`GET api/taxservice`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `paginate` |  optional  | nullable integer nullable paginate = 0

<!-- END_49adf837ec2c5a6b890f37ff5e4d8ad9 -->

<!-- START_fd7729c74b359d2b569723a35d95a4f1 -->
## List Commission

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/taxservice/commission?paginate=et" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/taxservice/commission"
);

let params = {
    "paginate": "et",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "commission": 2
        },
        {
            "id": 2,
            "commission": null
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/taxservice\/commission?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/taxservice\/commission?page=1",
    "next_page_url": null,
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/taxservice\/commission",
    "per_page": 10,
    "prev_page_url": null,
    "to": 7,
    "total": 7
}
```
> Example response (200):

```json
[
    {
        "id": 1,
        "commission": 2
    },
    {
        "id": 2,
        "commission": null
    }
]
```

### HTTP Request
`GET api/taxservice/commission`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `paginate` |  optional  | nullable integer nullable paginate = 0

<!-- END_fd7729c74b359d2b569723a35d95a4f1 -->

<!-- START_c2214ca6dd6f7e974bab1b0e4325e82d -->
## Send OTP for Email or mobile number

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/otp/send?email_or_mobile=consectetur&country_code=quaerat" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/otp/send"
);

let params = {
    "email_or_mobile": "consectetur",
    "country_code": "quaerat",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email_or_mobile": [
            "The email or mobile field is required."
        ],
        "country_code": [
            "The country code field must be present."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Email OTP sent successfully."
}
```
> Example response (200):

```json
{
    "message": "Mobile OTP resent successfully."
}
```
> Example response (422):

```json
{
    "message": "OTP send failed."
}
```

### HTTP Request
`POST api/otp/send`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `email_or_mobile` |  required  | string
    `country_code` |  optional  | present string

<!-- END_c2214ca6dd6f7e974bab1b0e4325e82d -->

<!-- START_e173bafa4104328eef4749859c627b93 -->
## Verify OTP for Email or mobile number

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/otp/verify?email_or_mobile=atque&otp=ab&country_code=temporibus" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/otp/verify"
);

let params = {
    "email_or_mobile": "atque",
    "otp": "ab",
    "country_code": "temporibus",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email_or_mobile": [
            "The email or mobile field is required."
        ],
        "country_code": [
            "The country code field must be present."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Email changed successfully."
}
```
> Example response (200):

```json
{
    "message": "Mobile number changed successfully."
}
```
> Example response (422):

```json
{
    "message": "Email OTP expired."
}
```
> Example response (422):

```json
{
    "message": "Incorrect Email OTP."
}
```
> Example response (404):

```json
{
    "message": "Email change request not found."
}
```
> Example response (422):

```json
{
    "message": "Mobile number OTP expired."
}
```
> Example response (422):

```json
{
    "message": "Incorrect Mobile number OTP."
}
```
> Example response (404):

```json
{
    "message": "Mobile number request not found."
}
```

### HTTP Request
`POST api/otp/verify`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `email_or_mobile` |  required  | string
    `otp` |  required  | integer
    `country_code` |  optional  | present string

<!-- END_e173bafa4104328eef4749859c627b93 -->

<!-- START_97768116aaa2423e1d9b6ad0d3db7e72 -->
## Get sales list

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/sales?type=est&name=consequatur&today=ipsam&last_30_days=sunt&financial_year=voluptatibus&custom[start_date]=et&custom[end_date]=est" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/sales"
);

let params = {
    "type": "est",
    "name": "consequatur",
    "today": "ipsam",
    "last_30_days": "sunt",
    "financial_year": "voluptatibus",
    "custom[start_date]": "et",
    "custom[end_date]": "est",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "type": [
            "The type field is required."
        ],
        "today": [
            "The today field must be present."
        ],
        "last_30_days": [
            "The last 30 days field must be present."
        ],
        "financial_year": [
            "The financial year field must be present."
        ],
        "custom": [
            "The custom must be an array."
        ],
        "custom.start_date": [
            "The custom.start date field must be present."
        ],
        "custom.end_date": [
            "The custom.end date field must be present."
        ]
    }
}
```
> Example response (200):

```json
{
    "earnings": 8060,
    "over_due": 4280,
    "total_sales": 8520,
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "payout_id": "SL0000001",
            "service": "direct",
            "total": 300,
            "tax_amount": 10,
            "earnings": 20,
            "payable_to_vendor": 270,
            "pdf_url": null,
            "created_at": "2021-02-02 19:33 PM",
            "patient": {
                "id": 3,
                "first_name": "Test",
                "middle_name": null,
                "last_name": "Patient",
                "profile_photo_url": null
            },
            "pharmacy": {
                "pharmacy_name": "Pharmacy Name",
                "dl_file": null,
                "reg_certificate": null
            }
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/sales?page=1",
    "from": 1,
    "last_page": 4,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/sales?page=4",
    "next_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/sales?page=2",
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/sales",
    "per_page": 1,
    "prev_page_url": null,
    "to": 1,
    "total": 4
}
```
> Example response (200):

```json
{
    "earnings": 1000,
    "over_due": 500,
    "total_sales": 1100,
    "current_page": 1,
    "data": [
        {
            "id": 6,
            "payout_id": "SL0000006",
            "service": "Direct",
            "total": 500,
            "tax_amount": 100,
            "earnings": 500,
            "payable_to_vendor": 200,
            "pdf_url": null,
            "created_at": "2021-02-16 06:25:02 pm",
            "patient": {
                "id": 3,
                "first_name": "Ben",
                "middle_name": null,
                "last_name": "Patient",
                "profile_photo_url": null
            },
            "doctor": {
                "id": 2,
                "first_name": "Theophilus",
                "middle_name": "Jos",
                "last_name": "Simeon",
                "profile_photo_url": null
            }
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/sales?page=1",
    "from": 1,
    "last_page": 2,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/sales?page=2",
    "next_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/sales?page=2",
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/sales",
    "per_page": 1,
    "prev_page_url": null,
    "to": 1,
    "total": 2
}
```
> Example response (200):

```json
{
    "earnings": 1000,
    "over_due": 500,
    "total_sales": 1100,
    "current_page": 1,
    "data": [
        {
            "id": 4,
            "payout_id": "SL0000004",
            "service": "Direct",
            "total": 600,
            "tax_amount": 100,
            "earnings": 500,
            "payable_to_vendor": 300,
            "pdf_url": null,
            "created_at": "2021-02-16 06:24:40 pm",
            "patient": {
                "id": 3,
                "first_name": "Ben",
                "middle_name": null,
                "last_name": "Patient",
                "profile_photo_url": null
            },
            "labortory": {
                "laboratory_name": "Laboratory Name",
                "lab_file": null
            }
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/sales?page=1",
    "from": 1,
    "last_page": 2,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/sales?page=2",
    "next_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/sales?page=2",
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/sales",
    "per_page": 1,
    "prev_page_url": null,
    "to": 1,
    "total": 2
}
```
> Example response (404):

```json
{
    "message": "No records found."
}
```

### HTTP Request
`GET api/sales`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `type` |  required  | string anyone of MED,LAB,DOC
    `name` |  optional  | present string pharmacy name
    `today` |  optional  | present numeric send value 1 to apply filter
    `last_30_days` |  optional  | present numeric send value 1 to apply filter
    `financial_year` |  optional  | present numeric send value 1 to apply filter
    `custom` |  optional  | present array
    `custom.start_date` |  optional  | string format:Y-m-d
    `custom.end_date` |  optional  | string format:Y-m-d

<!-- END_97768116aaa2423e1d9b6ad0d3db7e72 -->

<!-- START_10a50b053d47c6ffda10cd031639fd44 -->
## Get sales recent transaction

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/sales/recent?type=consequatur" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/sales/recent"
);

let params = {
    "type": "consequatur",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
[
    {
        "id": 4,
        "payout_id": "SL0000004",
        "service": "direct",
        "total": 300,
        "tax_amount": 10,
        "earnings": 10,
        "payable_to_vendor": 270,
        "pdf_url": null,
        "created_at": "2021-02-02 19:33 PM",
        "patient": {
            "id": 3,
            "first_name": "Test",
            "middle_name": null,
            "last_name": "Patient",
            "profile_photo_url": null
        },
        "pharmacy": {
            "pharmacy_name": "Pharmacy Name",
            "dl_file": null,
            "reg_certificate": null
        }
    },
    {
        "id": 3,
        "payout_id": "SL0000003",
        "service": "direct",
        "total": 300,
        "tax_amount": 10,
        "earnings": 10,
        "payable_to_vendor": 270,
        "pdf_url": null,
        "created_at": "2021-02-02 19:33 PM",
        "patient": {
            "id": 3,
            "first_name": "Test",
            "middle_name": null,
            "last_name": "Patient",
            "profile_photo_url": null
        },
        "pharmacy": {
            "pharmacy_name": "Pharmacy Name",
            "dl_file": null,
            "reg_certificate": null
        }
    }
]
```
> Example response (200):

```json
[
    {
        "id": 4,
        "payout_id": "SL0000004",
        "service": "Direct",
        "total": 600,
        "tax_amount": 100,
        "earnings": 500,
        "payable_to_vendor": 300,
        "pdf_url": null,
        "created_at": "2021-02-16 06:24:40 pm",
        "patient": {
            "id": 3,
            "first_name": "Ben",
            "middle_name": null,
            "last_name": "Patient",
            "profile_photo_url": null
        },
        "labortory": {
            "laboratory_name": "Laboratory Name",
            "lab_file": null
        }
    },
    {
        "id": 3,
        "payout_id": "SL0000003",
        "service": "Direct",
        "total": 500,
        "tax_amount": 100,
        "earnings": 500,
        "payable_to_vendor": 200,
        "pdf_url": null,
        "created_at": "2021-02-16 06:24:28 pm",
        "patient": {
            "id": 3,
            "first_name": "Ben",
            "middle_name": null,
            "last_name": "Patient",
            "profile_photo_url": null
        },
        "labortory": {
            "laboratory_name": "Laboratory Name",
            "lab_file": null
        }
    }
]
```
> Example response (200):

```json
[
    {
        "id": 6,
        "payout_id": "SL0000006",
        "service": "Direct",
        "total": 500,
        "tax_amount": 100,
        "earnings": 500,
        "payable_to_vendor": 200,
        "pdf_url": null,
        "created_at": "2021-02-16 06:25:02 pm",
        "patient": {
            "id": 3,
            "first_name": "Ben",
            "middle_name": null,
            "last_name": "Patient",
            "profile_photo_url": null
        },
        "doctor": {
            "id": 2,
            "first_name": "Theophilus",
            "middle_name": "Jos",
            "last_name": "Simeon",
            "profile_photo_url": null
        }
    },
    {
        "id": 5,
        "payout_id": "SL0000005",
        "service": "Direct",
        "total": 600,
        "tax_amount": 100,
        "earnings": 500,
        "payable_to_vendor": 300,
        "pdf_url": null,
        "created_at": "2021-02-16 06:24:50 pm",
        "patient": {
            "id": 3,
            "first_name": "Ben",
            "middle_name": null,
            "last_name": "Patient",
            "profile_photo_url": null
        },
        "doctor": {
            "id": 2,
            "first_name": "Theophilus",
            "middle_name": "Jos",
            "last_name": "Simeon",
            "profile_photo_url": null
        }
    }
]
```
> Example response (404):

```json
{
    "message": "No records found."
}
```

### HTTP Request
`GET api/sales/recent`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `type` |  required  | string anyone of MED,LAB,DOC

<!-- END_10a50b053d47c6ffda10cd031639fd44 -->

<!-- START_9b1563935e7f006a65bb3f99f3e24d48 -->
## Get sales chart data

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/sales/chart?type=quisquam" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/sales/chart"
);

let params = {
    "type": "quisquam",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
[
    {
        "total_amount": 7020,
        "earnings": 6560,
        "month": "February 2021",
        "month_key": "02"
    },
    {
        "total_amount": 1000,
        "earnings": 1000,
        "month": "May 2021",
        "month_key": "05"
    },
    {
        "total_amount": 500,
        "earnings": 500,
        "month": "April 2021",
        "month_key": "04"
    },
    {
        "total_amount": 500,
        "earnings": 500,
        "month": "March 2021",
        "month_key": "03"
    }
]
```
> Example response (404):

```json
{
    "message": "No data found."
}
```

### HTTP Request
`GET api/sales/chart`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `type` |  required  | string anyone of MED,LAB,DOC

<!-- END_9b1563935e7f006a65bb3f99f3e24d48 -->

<!-- START_2c88128c15445658ca1ac6a46623fc9d -->
## Get payout list by user

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/payout/user?type=doloribus&today=nostrum&last_30_days=eum&financial_year=repellendus&custom[start_date]=eos&custom[end_date]=libero" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/payout/user"
);

let params = {
    "type": "doloribus",
    "today": "nostrum",
    "last_30_days": "eum",
    "financial_year": "repellendus",
    "custom[start_date]": "eos",
    "custom[end_date]": "libero",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "payout_id": "PY0000001",
            "cycle": "WEEKLY",
            "period": "22 March 2021 - 28 March 2021",
            "total_sales": 8116.04,
            "earnings": 1145.54,
            "total_payable": 6970.5,
            "total_paid": 0,
            "balance": 0,
            "status": 0,
            "previous_due": 0,
            "time": "2021-03-25 07:33:28 pm",
            "current_due": 0
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/payout\/user?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/payout\/user?page=1",
    "next_page_url": null,
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/payout\/user",
    "per_page": 10,
    "prev_page_url": null,
    "to": 1,
    "total": 1
}
```
> Example response (404):

```json
{
    "message": "No records found."
}
```

### HTTP Request
`GET api/payout/user`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `type` |  required  | string anyone of MED,LAB,DOC
    `today` |  optional  | present numeric send value 1 to apply filter
    `last_30_days` |  optional  | present numeric send value 1 to apply filter
    `financial_year` |  optional  | present numeric send value 1 to apply filter
    `custom` |  optional  | present array
    `custom.start_date` |  optional  | string format:Y-m-d
    `custom.end_date` |  optional  | string format:Y-m-d

<!-- END_2c88128c15445658ca1ac6a46623fc9d -->

<!-- START_6fb27c64a8675b704435c28fdbeb6016 -->
## Get payout list by user - Payout Id

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/payout/user/record?type=sit&id=impedit" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/payout/user/record"
);

let params = {
    "type": "sit",
    "id": "impedit",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "type": [
            "The type field is required."
        ],
        "id": [
            "The id field is required."
        ]
    }
}
```
> Example response (200):

```json
[
    {
        "id": 1,
        "payout_id": "PY0000001",
        "cycle": "WEEKLY",
        "period": "22 March 2021 - 28 March 2021",
        "total_sales": 8116.04,
        "earnings": 1145.54,
        "total_payable": 6970.5,
        "total_paid": 0,
        "balance": 0,
        "status": 0,
        "previous_due": 0,
        "time": "2021-03-25 07:33:28 pm",
        "current_due": 0,
        "records": [
            {
                "unique_id": "AP0000340",
                "tax": 26.35,
                "commission": 55,
                "total": 576.35
            },
            {
                "unique_id": "AP0000369",
                "tax": 13.46,
                "commission": 28.1,
                "total": 294.46
            },
            {
                "unique_id": "AP0000372",
                "tax": 17.1,
                "commission": 35.7,
                "total": 374.1
            }
        ]
    }
]
```
> Example response (404):

```json
{
    "message": "No records found."
}
```

### HTTP Request
`GET api/payout/user/record`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `type` |  required  | string anyone of MED,LAB,DOC
    `id` |  required  | integer id of payouts

<!-- END_6fb27c64a8675b704435c28fdbeb6016 -->

<!-- START_91410692f9b5faa17cb40bf0f4e79259 -->
## Get payout list

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/payout?type=et&name=dicta&status=sit" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/payout"
);

let params = {
    "type": "et",
    "name": "dicta",
    "status": "sit",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "earnings": 3914.73,
    "total_payable": 25211.16,
    "total_paid": 3549.14,
    "balance": 900,
    "current_page": 1,
    "data": [
        {
            "id": 2,
            "payout_id": "PY0000002",
            "cycle": "WEEKLY",
            "period": "Feb 08,2021 - Feb 15,2021",
            "total_sales": 1000,
            "earnings": 300,
            "total_payable": 700,
            "total_paid": 0,
            "balance": 0,
            "status": 0,
            "previous_due": 500,
            "current_due": 500,
            "time": "2021-02-08 09:14:33 pm",
            "pharmacy": {
                "pharmacy_name": "Pharmacy Name",
                "dl_file": null,
                "reg_certificate": null
            },
            "bank_account_details": {
                "id": 4,
                "bank_account_number": "BANK12345",
                "bank_account_holder": "BANKER",
                "bank_name": "BANK",
                "bank_city": "India",
                "bank_ifsc": "IFSC4509899",
                "bank_account_type": "SAVINGS"
            },
            "address": {
                "id": 4,
                "street_name": "East Road",
                "city_village": "Edamon",
                "district": "Kollam",
                "state": "Kerala",
                "country": "India",
                "pincode": "691307",
                "country_code": null,
                "contact_number": null,
                "latitude": "10.53034500",
                "longitude": "76.21472900",
                "clinic_name": null
            },
            "payout_history_latest": null
        },
        {
            "id": 1,
            "payout_id": "PY0000001",
            "cycle": "WEEKLY",
            "period": "Feb 08,2021 - Feb 15,2021",
            "total_sales": 1000,
            "earnings": 300,
            "total_payable": 700,
            "total_paid": 200,
            "balance": 500,
            "status": 0,
            "previous_due": 0,
            "current_due": 500,
            "time": "2021-02-08 09:14:33 pm",
            "pharmacy": {
                "pharmacy_name": "Pharmacy Name",
                "dl_file": null,
                "reg_certificate": null
            },
            "bank_account_details": {
                "id": 4,
                "bank_account_number": "BANK12345",
                "bank_account_holder": "BANKER",
                "bank_name": "BANK",
                "bank_city": "India",
                "bank_ifsc": "IFSC4509899",
                "bank_account_type": "SAVINGS"
            },
            "address": {
                "id": 4,
                "street_name": "East Road",
                "city_village": "Edamon",
                "district": "Kollam",
                "state": "Kerala",
                "country": "India",
                "pincode": "691307",
                "country_code": null,
                "contact_number": null,
                "latitude": "10.53034500",
                "longitude": "76.21472900",
                "clinic_name": null
            },
            "payout_history_latest": null
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/payout?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/payout?page=1",
    "next_page_url": null,
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/payout",
    "per_page": 10,
    "prev_page_url": null,
    "to": 2,
    "total": 2
}
```
> Example response (200):

```json
{
    "earnings": 3914.73,
    "total_payable": 25211.16,
    "total_paid": 3549.14,
    "balance": 900,
    "current_page": 1,
    "data": [
        {
            "id": 3,
            "payout_id": "PY0000003",
            "cycle": "WEEKLY",
            "period": "Feb 08,2021 - Feb 15,2021",
            "total_sales": 7000,
            "earnings": 2000,
            "total_payable": 5000,
            "total_paid": 0,
            "balance": null,
            "status": 0,
            "previous_due": 700,
            "current_due": 500,
            "time": "2021-02-16 07:23:03 pm",
            "labortory": {
                "laboratory_name": "Laboratory Name",
                "lab_file": null
            },
            "bank_account_details": {
                "id": 3,
                "bank_account_number": "12345677",
                "bank_account_holder": "BANKER",
                "bank_name": "BANK",
                "bank_city": "India",
                "bank_ifsc": "IFSC4509845",
                "bank_account_type": "SAVINGS"
            },
            "address": {
                "id": 3,
                "street_name": "East Road",
                "city_village": "Edamon",
                "district": "Kollam",
                "state": "Kerala",
                "country": "India",
                "pincode": "691307",
                "country_code": null,
                "contact_number": null,
                "latitude": "10.53034500",
                "longitude": "76.21472900",
                "clinic_name": null
            },
            "payout_history_latest": {
                "id": 12,
                "payout_id": 1,
                "amount": 220,
                "reference": "GHH",
                "comment": "FJJKL",
                "created_at": "2021-02-11 11:20:44 pm"
            }
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/payout?page=1",
    "from": 1,
    "last_page": 2,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/payout?page=2",
    "next_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/payout?page=2",
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/payout",
    "per_page": 1,
    "prev_page_url": null,
    "to": 1,
    "total": 2
}
```
> Example response (200):

```json
{
    "earnings": 3914.73,
    "total_payable": 25211.16,
    "total_paid": 3549.14,
    "balance": 900,
    "current_page": 1,
    "data": [
        {
            "id": 5,
            "payout_id": "PY0000005",
            "cycle": "WEEKLY",
            "period": "Feb 08,2021 - Feb 15,2021",
            "total_sales": 7000,
            "earnings": 2000,
            "total_payable": 2000,
            "total_paid": 0,
            "balance": null,
            "status": 0,
            "previous_due": 5000,
            "current_due": 500,
            "time": "2021-02-16 07:23:29 pm",
            "doctor": {
                "id": 2,
                "first_name": "Theophilus",
                "middle_name": "Jos",
                "last_name": "Simeon",
                "profile_photo_url": null
            },
            "bank_account_details": {
                "id": 1,
                "bank_account_number": "123456",
                "bank_account_holder": "Theo",
                "bank_name": "jcujsejdfecs",
                "bank_city": "Nagercoil",
                "bank_ifsc": "IFSC123456",
                "bank_account_type": "SAVINGS"
            },
            "address": {
                "id": 1,
                "street_name": "South Road",
                "city_village": "Edamatto",
                "district": "Kottayam",
                "state": "Kerala",
                "country": "India",
                "pincode": "686575",
                "country_code": null,
                "contact_number": "9786200983",
                "latitude": "10.53034500",
                "longitude": "76.21472900",
                "clinic_name": "Neo clinic"
            },
            "payout_history_latest": {
                "id": 12,
                "payout_id": 1,
                "amount": 220,
                "reference": "GHH",
                "comment": "FJJKL",
                "created_at": "2021-02-11 11:20:44 pm"
            }
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/payout?page=1",
    "from": 1,
    "last_page": 2,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/payout?page=2",
    "next_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/payout?page=2",
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/payout",
    "per_page": 1,
    "prev_page_url": null,
    "to": 1,
    "total": 2
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "type": [
            "The type field is required."
        ],
        "name": [
            "The name field must be present."
        ],
        "status": [
            "The selected status is invalid."
        ]
    }
}
```
> Example response (404):

```json
{
    "message": "No records found."
}
```

### HTTP Request
`GET api/payout`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `type` |  required  | string anyone of MED,LAB,DOC
    `name` |  optional  | present string pharmacy name
    `status` |  optional  | present send 0 for unpaid 1 for paid

<!-- END_91410692f9b5faa17cb40bf0f4e79259 -->

<!-- START_cecd4f4f16cd986ecd987ba3103a098f -->
## Get payout recent transaction

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/payout/recent?type=eligendi" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/payout/recent"
);

let params = {
    "type": "eligendi",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
[
    {
        "id": 2,
        "payout_id": "PY0000002",
        "cycle": "WEEKLY",
        "period": "Feb 08,2021 - Feb 15,2021",
        "total_sales": 1000,
        "earnings": 300,
        "total_payable": 700,
        "total_paid": 0,
        "balance": null,
        "status": 0,
        "previous_due": 700,
        "current_due": 500,
        "created_at": "2021-02-04 19:03 PM",
        "pharmacy": {
            "pharmacy_name": "Pharmacy Name",
            "dl_file": null,
            "reg_certificate": null
        }
    },
    {
        "id": 1,
        "payout_id": "PY0000001",
        "cycle": "WEEKLY",
        "period": "Feb 01,2021 - Feb 07,2021",
        "total_sales": 1000,
        "earnings": 300,
        "total_payable": 700,
        "total_paid": 0,
        "balance": null,
        "status": 0,
        "previous_due": 700,
        "current_due": 500,
        "created_at": "2021-02-04 19:01 PM",
        "pharmacy": {
            "pharmacy_name": "Pharmacy Name",
            "dl_file": null,
            "reg_certificate": null
        }
    }
]
```
> Example response (200):

```json
[
    {
        "id": 3,
        "payout_id": "PY0000003",
        "cycle": "WEEKLY",
        "period": "Feb 08,2021 - Feb 15,2021",
        "total_sales": 7000,
        "earnings": 2000,
        "total_payable": 5000,
        "total_paid": 0,
        "balance": null,
        "status": 0,
        "previous_due": 700,
        "current_due": 500,
        "time": "2021-02-16 07:23:03 pm",
        "labortory": {
            "laboratory_name": "Laboratory Name",
            "lab_file": null
        }
    },
    {
        "id": 2,
        "payout_id": "PY0000002",
        "cycle": "WEEKLY",
        "period": "Feb 08,2021 - Feb 15,2021",
        "total_sales": 1000,
        "earnings": 300,
        "total_payable": 700,
        "total_paid": 0,
        "balance": null,
        "status": 0,
        "previous_due": 0,
        "current_due": 500,
        "time": "2021-02-16 07:22:17 pm",
        "labortory": {
            "laboratory_name": "Laboratory Name",
            "lab_file": null
        }
    }
]
```
> Example response (200):

```json
[
    {
        "id": 5,
        "payout_id": "PY0000005",
        "cycle": "WEEKLY",
        "period": "Feb 08,2021 - Feb 15,2021",
        "total_sales": 7000,
        "earnings": 2000,
        "total_payable": 2000,
        "total_paid": 0,
        "balance": null,
        "status": 0,
        "previous_due": 5000,
        "current_due": 500,
        "time": "2021-02-16 07:23:29 pm",
        "doctor": {
            "id": 2,
            "first_name": "Theophilus",
            "middle_name": "Jos",
            "last_name": "Simeon",
            "profile_photo_url": null
        }
    },
    {
        "id": 4,
        "payout_id": "PY0000004",
        "cycle": "WEEKLY",
        "period": "Feb 08,2021 - Feb 15,2021",
        "total_sales": 7000,
        "earnings": 2000,
        "total_payable": 5000,
        "total_paid": 0,
        "balance": null,
        "status": 0,
        "previous_due": 0,
        "current_due": 500,
        "time": "2021-02-16 07:23:13 pm",
        "doctor": {
            "id": 2,
            "first_name": "Theophilus",
            "middle_name": "Jos",
            "last_name": "Simeon",
            "profile_photo_url": null
        }
    }
]
```
> Example response (404):

```json
{
    "message": "No records found."
}
```

### HTTP Request
`GET api/payout/recent`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `type` |  required  | string anyone of MED,LAB,DOC

<!-- END_cecd4f4f16cd986ecd987ba3103a098f -->

<!-- START_cf5973e66f16ff1a62294fb7fa7d09fc -->
## Get payout histories

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/payout/payment?type=esse&payout_id=qui" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/payout/payment"
);

let params = {
    "type": "esse",
    "payout_id": "qui",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
[
    {
        "id": 1,
        "payout_id": "PY0000001",
        "cycle": "WEEKLY",
        "period": "Feb 01,2021 - Feb 07,2021",
        "total_sales": 1000,
        "earnings": 300,
        "total_payable": 700,
        "total_paid": 0,
        "balance": null,
        "status": 0,
        "created_at": "2021-02-04 19:01 PM",
        "payout_history": [
            {
                "id": 1,
                "payout_id": 1,
                "amount": 300,
                "reference": "REFLKM",
                "comment": "No comments",
                "created_at": "2021-02-05 19:19 PM"
            },
            {
                "id": 2,
                "payout_id": 1,
                "amount": 100,
                "reference": "REFLKM",
                "comment": "Payment 2",
                "created_at": "2021-02-05 19:50 PM"
            }
        ]
    }
]
```
> Example response (404):

```json
{
    "message": "No records found."
}
```

### HTTP Request
`GET api/payout/payment`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `type` |  required  | string anyone of MED,LAB,DOC
    `payout_id` |  required  | id of payout list

<!-- END_cf5973e66f16ff1a62294fb7fa7d09fc -->

<!-- START_bf27066d9049e3777a4533eee4d4a898 -->
## Single payout

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/payout/payment/single" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"payout_id":10,"amount":"cumque","reference":"et","comment":"qui"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/payout/payment/single"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "payout_id": 10,
    "amount": "cumque",
    "reference": "et",
    "comment": "qui"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "payout_id": [
            "The payout id field is required."
        ],
        "amount": [
            "The amount field is required."
        ],
        "reference": [
            "The reference field is required."
        ],
        "comment": [
            "The comment field must be present."
        ]
    }
}
```
> Example response (403):

```json
{
    "message": "Payable amount is higher than current due."
}
```
> Example response (200):

```json
{
    "message": "Payment successfull."
}
```

### HTTP Request
`POST api/payout/payment/single`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `payout_id` | integer |  required  | id from payout list
        `amount` | numeric |  required  | 
        `reference` | string |  required  | 
        `comment` | string |  optional  | nullable present
    
<!-- END_bf27066d9049e3777a4533eee4d4a898 -->

<!-- START_2475fcfeab57b579a0b8935e1fa3f1a2 -->
## Bulk payout

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/payout/payment/bulk" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"file":"dolorum"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/payout/payment/bulk"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "file": "dolorum"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "file": [
            "The file must be a file of type: csv, xls, xlsx."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "File uploaded successfully."
}
```
> Example response (422):

```json
{
    "message": "All headers are not found."
}
```
> Example response (422):

```json
{
    "message": "Headers are not in order."
}
```
> Example response (422):

```json
{
    "message": "Invalid File Format."
}
```

### HTTP Request
`POST api/payout/payment/bulk`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `file` | file |  required  | file type -> xlsx,csv
    
<!-- END_2475fcfeab57b579a0b8935e1fa3f1a2 -->

<!-- START_d0a0a0f6dd7ba88f9a4e0b80f46ddda1 -->
## Pharmacy, Laboratory edit dispense request

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/depense/request/update" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"quote_request_id":3,"bill_number":"reprehenderit","bill_amount":"odit","bill_date":"perferendis"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/depense/request/update"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "quote_request_id": 3,
    "bill_number": "reprehenderit",
    "bill_amount": "odit",
    "bill_date": "perferendis"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "quote_request_id": [
            "The quote request id field is required."
        ],
        "bill_number": [
            "The bill number field must be present."
        ],
        "bill_amount": [
            "The bill amount must be a number."
        ],
        "bill_date": [
            "The bill date does not match the format Y-m-d."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Record updated successfully."
}
```

### HTTP Request
`POST api/depense/request/update`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `quote_request_id` | integer |  required  | id of quote request
        `bill_number` | string |  optional  | present
        `bill_amount` | numeric |  optional  | present
        `bill_date` | date |  optional  | present format -> Y-m-d
    
<!-- END_d0a0a0f6dd7ba88f9a4e0b80f46ddda1 -->

<!-- START_6c560cb463cae69ddba197afa896608b -->
## Add comment

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/comments" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"to_id":20,"comment":"temporibus"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/comments"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "to_id": 20,
    "comment": "temporibus"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "to_user_id": [
            "The selected to user id is invalid."
        ],
        "comment": [
            "The comment field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Comment created successfully."
}
```

### HTTP Request
`POST api/comments`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `to_id` | integer |  required  | id of to_user
        `comment` | string |  optional  | nullable present
    
<!-- END_6c560cb463cae69ddba197afa896608b -->

<!-- START_38702aa9c6f225b36ff53e89358992ea -->
## List comment

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/comments?paginate=qui&to_user_id=at" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/comments"
);

let params = {
    "paginate": "qui",
    "to_user_id": "at",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "comment": "First comment",
            "to_user": {
                "id": 3,
                "first_name": "Test",
                "middle_name": null,
                "last_name": "Patient",
                "profile_photo_url": null
            },
            "from_user": {
                "id": 15,
                "first_name": "Walker",
                "middle_name": "Kimberly",
                "last_name": "S",
                "profile_photo_url": null
            }
        },
        {
            "id": 2,
            "comment": "Send comment",
            "to_user": {
                "id": 3,
                "first_name": "Test",
                "middle_name": null,
                "last_name": "Patient",
                "profile_photo_url": null
            },
            "from_user": {
                "id": 15,
                "first_name": "Walker",
                "middle_name": "Kimberly",
                "last_name": "S",
                "profile_photo_url": null
            }
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/comments?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/comments?page=1",
    "next_page_url": null,
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/comments",
    "per_page": 10,
    "prev_page_url": null,
    "to": 2,
    "total": 2
}
```

### HTTP Request
`GET api/comments`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `paginate` |  optional  | nullable integer paginate = 0
    `to_user_id` |  optional  | nullable integer id of to_user

<!-- END_38702aa9c6f225b36ff53e89358992ea -->

<!-- START_a446ee5cc043f690570906c492c40786 -->
## Delete comment

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X DELETE \
    "http://localhost/fms-api-laravel/public/api/comments/1?id=et" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/comments/1"
);

let params = {
    "id": "et",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (404):

```json
{
    "message": "Comment not found."
}
```
> Example response (200):

```json
{
    "message": "Comment deleted successfully."
}
```

### HTTP Request
`DELETE api/comments/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of record

<!-- END_a446ee5cc043f690570906c492c40786 -->

<!-- START_cc89ec9f9e7fb340e5498f155a377b19 -->
## Activate user

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/admin/action/activate" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"user_id":17}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/action/activate"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "user_id": 17
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "user_id": [
            "The user id field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "User activated successfully."
}
```

### HTTP Request
`POST api/admin/action/activate`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `user_id` | integer |  required  | id of user
    
<!-- END_cc89ec9f9e7fb340e5498f155a377b19 -->

#Health Associate


<!-- START_d6deb062c0d16a1e5615d4ad75d1154a -->
## Health Associate get profile details

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/healthassociate/profile" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/healthassociate/profile"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "id": 4,
    "unique_id": "EMP0000004",
    "father_first_name": "sdcjsj",
    "father_middle_name": null,
    "father_last_name": "hdfh",
    "date_of_birth": "2020-12-28",
    "age": 0,
    "date_of_joining": "2021-01-05",
    "gender": "MALE",
    "user": {
        "id": 52,
        "first_name": "hjsjda",
        "middle_name": null,
        "last_name": "nhdhsh",
        "email": "krishnan5.ak@gmail.com",
        "username": "emp60080cfadb6e9",
        "country_code": "+91",
        "mobile_number": "8281837600",
        "user_type": "HEALTHASSOCIATE",
        "is_active": "1",
        "role": [
            8
        ],
        "currency_code": null,
        "approved_date": "2021-01-21",
        "profile_photo_url": null
    },
    "address": [
        {
            "id": 65,
            "street_name": "d",
            "city_village": "q",
            "district": "Alappuzha",
            "state": "Kerala",
            "country": "India",
            "pincode": "688004",
            "country_code": null,
            "contact_number": null,
            "latitude": null,
            "longitude": null,
            "clinic_name": null
        }
    ]
}
```
> Example response (404):

```json
{
    "message": "Details not found."
}
```

### HTTP Request
`GET api/healthassociate/profile`


<!-- END_d6deb062c0d16a1e5615d4ad75d1154a -->

<!-- START_ec4edfa4a9859320dfd66bf3e76e303a -->
## Health Associate edit profile details

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/healthassociate/profile" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"country_code":"deleniti","mobile_number":"id","email":"nobis"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/healthassociate/profile"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "country_code": "deleniti",
    "mobile_number": "id",
    "email": "nobis"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": [
            "The email field is required."
        ],
        "mobile_number": [
            "The mobile number field is required."
        ],
        "country_code": [
            "The country code field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Details updated successfully."
}
```

### HTTP Request
`POST api/healthassociate/profile`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `country_code` | string |  required  | 
        `mobile_number` | string |  required  | 
        `email` | string |  required  | 
    
<!-- END_ec4edfa4a9859320dfd66bf3e76e303a -->

<!-- START_9218ba0f4bb75e3fb714f9dcdaaf5256 -->
## Health Associate edit address

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/healthassociate/address" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"address_id":14,"pincode":9,"street_name":"consequatur","city_village":"consequatur","district":"non","state":"est","country":"alias"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/healthassociate/address"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "address_id": 14,
    "pincode": 9,
    "street_name": "consequatur",
    "city_village": "consequatur",
    "district": "non",
    "state": "est",
    "country": "alias"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "address_id": [
            "The address id field is required."
        ],
        "pincode": [
            "The pincode field is required."
        ],
        "street_name": [
            "The street name field is required."
        ],
        "city_village": [
            "The city village field is required."
        ],
        "district": [
            "The district field is required."
        ],
        "state": [
            "The state field is required."
        ],
        "country": [
            "The country field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Address updated successfully."
}
```

### HTTP Request
`POST api/healthassociate/address`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `address_id` | integer |  required  | id from address object
        `pincode` | integer |  required  | length 6
        `street_name` | string |  required  | Street Name/ House No./ Area
        `city_village` | string |  required  | City/Village
        `district` | string |  required  | 
        `state` | string |  required  | 
        `country` | string |  required  | 
    
<!-- END_9218ba0f4bb75e3fb714f9dcdaaf5256 -->

#Laboratory


<!-- START_2957cf3f4b3f3d3ab05e460ed7938518 -->
## Laboratory get profile details

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/laboratory/profile" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/laboratory/profile"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "id": 1,
    "laboratory_unique_id": "LAB0000001",
    "laboratory_name": "Laboratory Name",
    "alt_mobile_number": null,
    "alt_country_code": null,
    "gstin": "GSTN49598E4",
    "lab_reg_number": "LAB12345",
    "lab_issuing_authority": "AIMS",
    "lab_date_of_issue": "2020-10-15",
    "lab_valid_upto": "2030-10-15",
    "sample_collection": 0,
    "order_amount": null,
    "payout_period": 0,
    "lab_file": null,
    "user": {
        "id": 30,
        "first_name": "Darby Watsica",
        "middle_name": "Jadyn Wehner",
        "last_name": "Prof. Edwina O'Connell",
        "email": "labortory@logidots.com",
        "username": "laboratory",
        "country_code": "+91",
        "mobile_number": "+1.986.227.1219",
        "user_type": "LABORATORY",
        "is_active": "1",
        "currency_code": "INR",
        "profile_photo_url": null
    },
    "address": [
        {
            "id": 73,
            "street_name": "East Road",
            "city_village": "Edamon",
            "district": "Kollam",
            "state": "Kerala",
            "country": "India",
            "pincode": "691307",
            "country_code": null,
            "contact_number": null,
            "latitude": "10.53034500",
            "longitude": "76.21472900",
            "clinic_name": null
        }
    ],
    "bank_account_details": [
        {
            "id": 25,
            "bank_account_number": "BANK12345",
            "bank_account_holder": "BANKER",
            "bank_name": "BANK",
            "bank_city": "India",
            "bank_ifsc": "IFSC45098",
            "bank_account_type": "SAVINGS"
        }
    ]
}
```
> Example response (404):

```json
{
    "message": "profile details not found."
}
```

### HTTP Request
`GET api/laboratory/profile`


<!-- END_2957cf3f4b3f3d3ab05e460ed7938518 -->

<!-- START_4ac7eedb6cff8989d0309166a4c9c127 -->
## Laboratory edit profile details

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/laboratory/profile" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"laboratory_name":"rerum","country_code":"vel","mobile_number":"autem","email":"qui","alt_mobile_number":"sunt","alt_country_code":"aliquid","gstin":"quo","lab_reg_number":"cum","lab_issuing_authority":"voluptatem","lab_date_of_issue":"est","lab_valid_upto":"non","payout_period":false,"lab_file":"et","pincode":1,"street_name":"officia","city_village":"esse","district":"repellendus","state":"ratione","country":"ratione","sample_collection":false,"order_amount":"commodi","currency_code":"vel","latitude":10.55531,"longitude":1804295.232,"bank_account_number":"quos","bank_account_holder":"non","bank_name":"quaerat","bank_city":"non","bank_ifsc":"vero","bank_account_type":"harum"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/laboratory/profile"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "laboratory_name": "rerum",
    "country_code": "vel",
    "mobile_number": "autem",
    "email": "qui",
    "alt_mobile_number": "sunt",
    "alt_country_code": "aliquid",
    "gstin": "quo",
    "lab_reg_number": "cum",
    "lab_issuing_authority": "voluptatem",
    "lab_date_of_issue": "est",
    "lab_valid_upto": "non",
    "payout_period": false,
    "lab_file": "et",
    "pincode": 1,
    "street_name": "officia",
    "city_village": "esse",
    "district": "repellendus",
    "state": "ratione",
    "country": "ratione",
    "sample_collection": false,
    "order_amount": "commodi",
    "currency_code": "vel",
    "latitude": 10.55531,
    "longitude": 1804295.232,
    "bank_account_number": "quos",
    "bank_account_holder": "non",
    "bank_name": "quaerat",
    "bank_city": "non",
    "bank_ifsc": "vero",
    "bank_account_type": "harum"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "laboratory_name": [
            "The laboratory name field is required."
        ],
        "country_code": [
            "The country code field is required."
        ],
        "mobile_number": [
            "The mobile number field is required."
        ],
        "email": [
            "The email field is required."
        ],
        "gstin": [
            "The gstin field is required."
        ],
        "lab_reg_number": [
            "The lab reg number field is required."
        ],
        "lab_issuing_authority": [
            "The lab issuing authority field is required."
        ],
        "lab_date_of_issue": [
            "The lab date of issue field is required."
        ],
        "lab_valid_upto": [
            "The lab valid upto field is required."
        ],
        "lab_file": [
            "The lab file field is required."
        ],
        "pincode": [
            "The pincode field is required."
        ],
        "street_name": [
            "The street name field is required."
        ],
        "city_village": [
            "The city village field is required."
        ],
        "district": [
            "The district field is required."
        ],
        "state": [
            "The state field is required."
        ],
        "country": [
            "The country field is required."
        ],
        "sample_collection": [
            "The sample collection field is required."
        ],
        "latitude": [
            "The latitude field is required."
        ],
        "longitude": [
            "The longitude field is required."
        ],
        "data_id": [
            "The data id field is required."
        ],
        "bank_account_number": [
            "The bank account number field is required."
        ],
        "bank_account_holder": [
            "The bank account holder field is required."
        ],
        "bank_name": [
            "The bank name field is required."
        ],
        "bank_city": [
            "The bank city field is required."
        ],
        "bank_ifsc": [
            "The bank ifsc field is required."
        ],
        "bank_account_type": [
            "The bank account type field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Details saved successfully."
}
```
> Example response (422):

```json
{
    "message": "Something went wrong."
}
```

### HTTP Request
`POST api/laboratory/profile`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `laboratory_name` | string |  required  | 
        `country_code` | string |  required  | 
        `mobile_number` | string |  required  | 
        `email` | string |  required  | 
        `alt_mobile_number` | string |  optional  | nullable
        `alt_country_code` | string |  required  | when alt_mobile_number is present
        `gstin` | string |  required  | 
        `lab_reg_number` | string |  required  | 
        `lab_issuing_authority` | string |  required  | 
        `lab_date_of_issue` | date |  required  | format:Y-m-d
        `lab_valid_upto` | date |  required  | format:Y-m-d
        `payout_period` | boolean |  required  | 0 or 1
        `lab_file` | image |  optional  | nullable mime:jpg,jpeg,png size max 2mb
        `pincode` | integer |  required  | length 6
        `street_name` | string |  required  | Street Name/ House No./ Area
        `city_village` | string |  required  | City/Village
        `district` | string |  required  | 
        `state` | string |  required  | 
        `country` | string |  required  | 
        `sample_collection` | boolean |  required  | 0 or 1
        `order_amount` | decimal |  optional  | nullable required if home_delivery is filled
        `currency_code` | stirng |  required  | 
        `latitude` | float |  required  | 
        `longitude` | float |  required  | 
        `bank_account_number` | string |  required  | 
        `bank_account_holder` | string |  required  | 
        `bank_name` | string |  required  | 
        `bank_city` | string |  required  | 
        `bank_ifsc` | string |  required  | 
        `bank_account_type` | string |  required  | 
    
<!-- END_4ac7eedb6cff8989d0309166a4c9c127 -->

<!-- START_758aeeca2447b9c0fae1da4ceb8e873f -->
## Laboratory get test list

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/laboratory/test" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/laboratory/test"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "lab_tests": [
        {
            "id": "1",
            "sample_collect": "1"
        },
        {
            "id": "2",
            "sample_collect": "1"
        }
    ]
}
```
> Example response (404):

```json
{
    "message": "Record not found."
}
```

### HTTP Request
`GET api/laboratory/test`


<!-- END_758aeeca2447b9c0fae1da4ceb8e873f -->

<!-- START_178e97b74f55adbab68aa53849354c5e -->
## Laboratory edit test list

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/laboratory/test" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"lab_tests":[{"id":15,"sample_collect":false}]}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/laboratory/test"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "lab_tests": [
        {
            "id": 15,
            "sample_collect": false
        }
    ]
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "Record saved successfully."
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "lab_tests.0.id": [
            "The lab_tests.0.id field is required."
        ],
        "lab_tests.0.sample_collect": [
            "The lab_tests.0.sample_collect field is required."
        ]
    }
}
```

### HTTP Request
`POST api/laboratory/test`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `lab_tests` | array |  optional  | nullable
        `lab_tests.*.id` | integer |  required  | test list ids
        `lab_tests.*.sample_collect` | boolean |  required  | 0 or 1
    
<!-- END_178e97b74f55adbab68aa53849354c5e -->

<!-- START_7915903e1d1067fba9ed6c19ce36cad0 -->
## Laboratory get Quotes Request

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/laboratory/quote/request?filter[search]=maiores&filter[doctor]=cupiditate&filter[status]=ex&dispense_request=8" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/laboratory/quote/request"
);

let params = {
    "filter[search]": "maiores",
    "filter[doctor]": "cupiditate",
    "filter[status]": "ex",
    "dispense_request": "8",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 60,
            "unique_id": "QR0000060",
            "prescription_id": 89,
            "quote_reply": null,
            "status": "0",
            "submission_date": null,
            "file_path": null,
            "created_at": "2021-02-10 09:55:20 pm",
            "test_list": [
                {
                    "id": 1,
                    "prescription_id": 2,
                    "lab_test_id": 1,
                    "quote_generated": 0,
                    "instructions": null,
                    "test_status": "Dispensed at associated laboratory.",
                    "test_name": "Blood New",
                    "test": {
                        "id": 1,
                        "name": "Blood New",
                        "unique_id": "LAT0000001",
                        "price": 555,
                        "currency_code": "INR",
                        "code": "BL New Test.",
                        "image": null
                    }
                }
            ],
            "prescription": {
                "id": 89,
                "appointment_id": 248,
                "unique_id": "PX0000087",
                "created_at": "2021-02-10",
                "pdf_url": "http:\/\/localhost\/fms-api-laravel\/public\/storage\/uploads\/prescription\/89-1612974321.pdf",
                "status_medicine": "Yet to dispense.",
                "patient": {
                    "id": 22,
                    "first_name": "Vishnu",
                    "middle_name": "S",
                    "last_name": "Sharma",
                    "email": "vishnusharmatest123@yopmail.com",
                    "country_code": "+91",
                    "mobile_number": "3736556464",
                    "profile_photo_url": null
                },
                "appointment": {
                    "id": 248,
                    "doctor_id": 2,
                    "patient_id": 47,
                    "appointment_unique_id": "AP0000248",
                    "date": "2021-02-11",
                    "time": "12:05:00",
                    "consultation_type": "ONLINE",
                    "shift": null,
                    "payment_status": null,
                    "transaction_id": null,
                    "total": null,
                    "is_cancelled": 0,
                    "is_completed": 1,
                    "followup_id": null,
                    "booking_date": "2021-02-10",
                    "current_patient_info": {
                        "user": {
                            "first_name": "Diana",
                            "middle_name": "Princess",
                            "last_name": "Wales",
                            "email": "diana@gmail.com",
                            "country_code": "+91",
                            "mobile_number": "7878787878",
                            "profile_photo_url": null
                        },
                        "case": 1,
                        "info": {
                            "first_name": "Diana",
                            "middle_name": "Princess",
                            "last_name": "Wales",
                            "email": "diana@gmail.com",
                            "country_code": "+91",
                            "mobile_number": "7878787878",
                            "height": 156,
                            "weight": 55,
                            "gender": "FEMALE",
                            "age": 23
                        },
                        "address": {
                            "id": 132,
                            "street_name": "Vadakkaparampill",
                            "city_village": "PATHANAMTHITTA",
                            "district": "Pathanamthitta",
                            "state": "Kerala",
                            "country": "India",
                            "pincode": "689667",
                            "country_code": null,
                            "contact_number": "+917591985087",
                            "latitude": null,
                            "longitude": null,
                            "clinic_name": null
                        }
                    },
                    "doctor": {
                        "id": 2,
                        "first_name": "Theophilus",
                        "middle_name": "Jos",
                        "last_name": "Simeon",
                        "email": "theophilus@logidots.com",
                        "username": "theo",
                        "country_code": "+91",
                        "mobile_number": "8940330536",
                        "user_type": "DOCTOR",
                        "is_active": "1",
                        "role": null,
                        "currency_code": "INR",
                        "approved_date": "2021-01-04",
                        "profile_photo_url": null
                    },
                    "clinic_address": {
                        "id": 1,
                        "street_name": "South Road",
                        "city_village": "Edamatto",
                        "district": "Kottayam",
                        "state": "Kerala",
                        "country": "India",
                        "pincode": "686575",
                        "country_code": null,
                        "contact_number": "9786200983",
                        "latitude": "10.53034500",
                        "longitude": "76.21472900",
                        "clinic_name": "Neo clinic"
                    }
                }
            }
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/laboratory\/quote\/request?page=1",
    "from": 1,
    "last_page": 11,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/laboratory\/quote\/request?page=11",
    "next_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/laboratory\/quote\/request?page=2",
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/laboratory\/quote\/request",
    "per_page": 1,
    "prev_page_url": null,
    "to": 1,
    "total": 11
}
```
> Example response (404):

```json
{
    "message": "Quotes request not found."
}
```

### HTTP Request
`GET api/laboratory/quote/request`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `filter` |  optional  | nullable array
    `filter.search` |  optional  | nullable string present
    `filter.doctor` |  optional  | nullable string present
    `filter.status` |  optional  | nullable boolean present 0 or 1
    `dispense_request` |  optional  | nullable number send 1

<!-- END_7915903e1d1067fba9ed6c19ce36cad0 -->

<!-- START_85d827e8524a371ffb47ff45e89ff2e0 -->
## Laboratory get Quotes Request by Id

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/laboratory/quote/request/1?quote_request_id=pariatur" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/laboratory/quote/request/1"
);

let params = {
    "quote_request_id": "pariatur",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "id": 2,
    "unique_id": "QR0000002",
    "prescription_id": 1,
    "quote_reply": null,
    "status": "0",
    "submission_date": null,
    "file_path": null,
    "created_at": "2021-01-15 18:55 PM",
    "test_list": [
        {
            "id": 1,
            "prescription_id": 1,
            "lab_test_id": 1,
            "laboratory_id": null,
            "instructions": "Need report on this test",
            "test_status": "Dispensed outside.",
            "test_name": "Test 2",
            "test": {
                "id": 1,
                "name": "Test 2",
                "unique_id": "LAT0000001",
                "price": 300,
                "currency_code": "INR",
                "code": "ECO",
                "image": "http:\/\/localhost\/fms-api-laravel\/public\/storage\/uploads\/labtest\/1610715571tiger.jpg"
            }
        }
    ],
    "prescription": {
        "pdf_url": "http:\/\/localhost\/fms-api-laravel\/public\/storage\/uploads\/prescription\/1-1610717145.pdf",
        "prescription_unique_id": "PX0000001"
    },
    "appointment": {
        "id": 1,
        "doctor_id": 2,
        "patient_id": 3,
        "appointment_unique_id": "AP0000001",
        "date": "2021-01-18",
        "time": "15:00:00",
        "consultation_type": "ONLINE",
        "shift": "MORNING",
        "payment_status": null,
        "transaction_id": null,
        "total": null,
        "is_cancelled": 0,
        "is_completed": 1,
        "followup_id": null,
        "patient_info": {
            "id": "1",
            "case": "1",
            "email": "james@gmail.com",
            "mobile": "876543210",
            "last_name": "Bond",
            "first_name": "James",
            "middle_name": "007",
            "mobile_code": "+91",
            "patient_mobile": "987654321",
            "patient_mobile_code": "+91"
        },
        "laravel_through_key": 1,
        "booking_date": "2021-01-15",
        "doctor": {
            "id": 2,
            "first_name": "Theophilus",
            "middle_name": "Jos",
            "last_name": "Simeon",
            "email": "theophilus@logidots.com",
            "username": "theo",
            "country_code": "+91",
            "mobile_number": "8940330536",
            "user_type": "DOCTOR",
            "is_active": "1",
            "role": null,
            "currency_code": null,
            "approved_date": "2021-01-15",
            "profile_photo_url": null
        },
        "clinic_address": {
            "id": 1,
            "street_name": "South Road",
            "city_village": "Edamattom",
            "district": "Kottayam",
            "state": "Kerala",
            "country": "India",
            "pincode": "686575",
            "country_code": null,
            "contact_number": null,
            "latitude": "10.53034500",
            "longitude": "76.21472900",
            "clinic_name": "romaguera"
        }
    }
}
```
> Example response (404):

```json
{
    "message": "Record not found."
}
```

### HTTP Request
`GET api/laboratory/quote/request/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `quote_request_id` |  required  | integer id of quote_request object

<!-- END_85d827e8524a371ffb47ff45e89ff2e0 -->

<!-- START_54aa2e51754cb849cce95b653247c5e1 -->
## Laboratory edit Quotes Request by Id

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/laboratory/quote/request" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"quote_request_id":"quia","status":"ducimus","bill_number":"voluptatem","bill_amount":"eum","bill_date":"omnis"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/laboratory/quote/request"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "quote_request_id": "quia",
    "status": "ducimus",
    "bill_number": "voluptatem",
    "bill_amount": "eum",
    "bill_date": "omnis"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "Updated successfully."
}
```

### HTTP Request
`POST api/laboratory/quote/request`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `quote_request_id` | required |  optional  | integer id of quote request
        `status` | required |  optional  | string send -> Dispensed
        `bill_number` | string |  optional  | present
        `bill_amount` | numeric |  optional  | present
        `bill_date` | date |  optional  | present format -> Y-m-d
    
<!-- END_54aa2e51754cb849cce95b653247c5e1 -->

<!-- START_d955139db805e71d099c64fa46efbb27 -->
## Laboratory add Quote

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/laboratory/quote" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"quote_request_id":16,"test_list":[{"test_id":13,"price":"voluptas","instructions":"et"}],"total":"similique","discount":"est","delivery_charge":"cumque","valid_till":"perspiciatis"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/laboratory/quote"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "quote_request_id": 16,
    "test_list": [
        {
            "test_id": 13,
            "price": "voluptas",
            "instructions": "et"
        }
    ],
    "total": "similique",
    "discount": "est",
    "delivery_charge": "cumque",
    "valid_till": "perspiciatis"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "quote_request_id": [
            "The quote request id field is required."
        ],
        "total": [
            "The total field is required."
        ],
        "test_list.0.test_id": [
            "The test id field is required."
        ],
        "test_list.0.price": [
            "The price field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Quotes saved successfully."
}
```

### HTTP Request
`POST api/laboratory/quote`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `quote_request_id` | integer |  required  | 
        `test_list` | array |  required  | 
        `test_list.*.test_id` | integer |  required  | test id
        `test_list.*.price` | decimal |  required  | 
        `test_list.*.instructions` | string |  required  | 
        `total` | decimal |  required  | 
        `discount` | decimal |  optional  | present nullable price
        `delivery_charge` | present |  optional  | nullable price
        `valid_till` | required |  optional  | date format-> Y-m-d
    
<!-- END_d955139db805e71d099c64fa46efbb27 -->

<!-- START_8c3336a1f95439e82fed1ab1d0e1f485 -->
## Laboratory get Quotes by QuoteRequest Id

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/laboratory/quote/1/request?quote_request_id=occaecati" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/laboratory/quote/1/request"
);

let params = {
    "quote_request_id": "occaecati",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "id": 2,
    "quote_request_id": 2,
    "status": "0",
    "test": {
        "total": "055",
        "discount": "1",
        "delivery_charge": "1",
        "test_list": [
            {
                "price": "55",
                "test_id": 1,
                "test": {
                    "id": 1,
                    "name": "Blood New",
                    "unique_id": "LAT0000001",
                    "price": 555,
                    "currency_code": "INR",
                    "code": "BL New Test.",
                    "image": null
                }
            }
        ]
    },
    "prescription": {
        "id": 14,
        "appointment_id": 26,
        "unique_id": "PX0000014",
        "created_at": "2021-01-12",
        "pdf_url": null,
        "patient": {
            "id": 22,
            "first_name": "Vishnu",
            "middle_name": "S",
            "last_name": "Sharma",
            "email": "vishnusharmatest123@yopmail.com",
            "country_code": "+91",
            "mobile_number": "3736556464",
            "profile_photo_url": null
        },
        "status_medicine": "Dispensed.",
        "appointment": {
            "id": 26,
            "doctor_id": 2,
            "patient_id": 3,
            "appointment_unique_id": "AP0000026",
            "date": "2021-01-14",
            "time": "12:05:00",
            "consultation_type": "ONLINE",
            "shift": "AFTERNOON",
            "payment_status": null,
            "transaction_id": null,
            "total": null,
            "is_cancelled": 0,
            "is_completed": 1,
            "followup_id": null,
            "booking_date": "2021-01-12",
            "current_patient_info": {
                "user": {
                    "first_name": "Test",
                    "middle_name": null,
                    "last_name": "Patient",
                    "email": "patient@logidots.com",
                    "country_code": "+91",
                    "mobile_number": "9876543210",
                    "profile_photo_url": null
                },
                "case": "1",
                "info": {
                    "first_name": "Test",
                    "middle_name": null,
                    "last_name": "Patient",
                    "email": "patient@logidots.com",
                    "country_code": "+91",
                    "mobile_number": "9876543210",
                    "height": 1,
                    "weight": 0,
                    "gender": "MALE",
                    "age": 20
                },
                "address": {
                    "id": 36,
                    "street_name": "Sreekariyam",
                    "city_village": "Trivandrum",
                    "district": "Alappuzha",
                    "state": "Kerala",
                    "country": "India",
                    "pincode": "688001",
                    "country_code": null,
                    "contact_number": null,
                    "latitude": null,
                    "longitude": null,
                    "clinic_name": null
                }
            },
            "doctor": {
                "id": 2,
                "first_name": "Theophilus",
                "middle_name": "Jos",
                "last_name": "Simeon",
                "email": "theophilus@logidots.com",
                "username": "theo",
                "country_code": "+91",
                "mobile_number": "8940330536",
                "user_type": "DOCTOR",
                "is_active": "1",
                "role": null,
                "currency_code": "INR",
                "approved_date": "2021-01-04",
                "profile_photo_url": null
            }
        }
    }
}
```
> Example response (404):

```json
{
    "message": "No record found."
}
```

### HTTP Request
`GET api/laboratory/quote/{id}/request`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `quote_request_id` |  required  | id of Quote request list

<!-- END_8c3336a1f95439e82fed1ab1d0e1f485 -->

<!-- START_cedd28765d2871f50baa7663924d1fc4 -->
## Laboratory get Quotes

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/laboratory/quote" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/laboratory/quote"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 72,
            "type": "LAB",
            "created_at": "2021-03-01 03:46:59 pm",
            "unique_id": "QT0000073",
            "quote_request": {
                "created_at": "2021-02-26 11:58:03 pm",
                "quote_type": "Added by doctor."
            },
            "order": {
                "id": 9,
                "user_id": 125,
                "tax": 10,
                "subtotal": 20,
                "discount": 2,
                "delivery_charge": 2,
                "total": 500.49,
                "shipping_address_id": 1,
                "payment_status": "Not Paid",
                "delivery_status": "Open",
                "delivery_info": null,
                "created_at": "2021-03-08 03:16:16 pm"
            },
            "prescription": {
                "id": 251,
                "appointment_id": 462,
                "unique_id": "PX0000251",
                "created_at": "2021-02-26",
                "pdf_url": null,
                "status_medicine": "Quote not generated.",
                "patient": {
                    "id": 22,
                    "first_name": "Vishnu",
                    "middle_name": "S",
                    "last_name": "Sharma",
                    "email": "vishnusharmatest123@yopmail.com",
                    "country_code": "+91",
                    "mobile_number": "3736556464",
                    "profile_photo_url": null
                },
                "appointment": {
                    "id": 462,
                    "doctor_id": 121,
                    "patient_id": 123,
                    "appointment_unique_id": "AP0000462",
                    "date": "2021-02-26",
                    "time": "18:18:00",
                    "start_time": "18:18:00",
                    "end_time": "18:20:00",
                    "consultation_type": "ONLINE",
                    "shift": null,
                    "payment_status": null,
                    "transaction_id": null,
                    "total": null,
                    "tax": null,
                    "is_cancelled": 0,
                    "is_completed": 1,
                    "followup_id": null,
                    "booking_date": "2021-02-26",
                    "current_patient_info": {
                        "user": {
                            "first_name": "Beny",
                            "middle_name": "K",
                            "last_name": "Sebastian",
                            "email": "benyseba@gmail.com",
                            "country_code": "+91",
                            "mobile_number": "9090871555",
                            "profile_photo_url": null
                        },
                        "case": 1,
                        "info": {
                            "first_name": "Beny",
                            "middle_name": "K",
                            "last_name": "Sebastian",
                            "email": "benyseba@gmail.com",
                            "country_code": "+91",
                            "mobile_number": "9090871555",
                            "height": 150,
                            "weight": 60,
                            "gender": "MALE",
                            "age": 34
                        },
                        "address": {
                            "id": 162,
                            "street_name": "Gandhi nagar",
                            "city_village": "Central city",
                            "district": "Hyderabad",
                            "state": "Telangana",
                            "country": "India",
                            "pincode": "500001",
                            "country_code": null,
                            "contact_number": null,
                            "land_mark": null,
                            "latitude": null,
                            "longitude": null,
                            "clinic_name": null
                        }
                    },
                    "doctor": {
                        "id": 121,
                        "first_name": "Joji",
                        "middle_name": "S",
                        "last_name": "Thilak",
                        "email": "jojidev@gmail.com",
                        "username": "Joji",
                        "country_code": "+91",
                        "mobile_number": "8890786512",
                        "user_type": "DOCTOR",
                        "is_active": "1",
                        "role": null,
                        "currency_code": "INR",
                        "approved_date": "2021-02-12",
                        "profile_photo_url": null
                    }
                }
            }
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/laboratory\/quote?page=1",
    "from": 1,
    "last_page": 3,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/laboratory\/quote?page=3",
    "next_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/laboratory\/quote?page=2",
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/laboratory\/quote",
    "per_page": 1,
    "prev_page_url": null,
    "to": 1,
    "total": 3
}
```
> Example response (404):

```json
{
    "message": "Quotes not found."
}
```

### HTTP Request
`GET api/laboratory/quote`


<!-- END_cedd28765d2871f50baa7663924d1fc4 -->

<!-- START_9d5971042bb0841018d20957b7479a91 -->
## Laboratory get Quotes by Id

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/laboratory/quote/1?id=sit" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/laboratory/quote/1"
);

let params = {
    "id": "sit",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "id": 71,
    "type": "LAB",
    "created_at": "2021-02-27 01:34:17 am",
    "unique_id": "QT0000072",
    "order": {
        "id": 8,
        "user_id": 125,
        "tax": 10,
        "subtotal": 20,
        "discount": 2,
        "delivery_charge": 2,
        "total": 500.49,
        "shipping_address_id": 1,
        "payment_status": "Not Paid",
        "delivery_status": "Open",
        "delivery_info": null,
        "created_at": "2021-03-08 03:05:07 pm",
        "billing_address": [
            {
                "id": 1,
                "street_name": "South Road",
                "city_village": "Edamatto",
                "district": "Kottayam",
                "state": "Kerala",
                "country": "India",
                "pincode": "686575",
                "country_code": null,
                "contact_number": "9786200983",
                "land_mark": null,
                "latitude": "10.53034500",
                "longitude": "76.21472900",
                "clinic_name": "Neo clinic"
            }
        ],
        "payments": {
            "id": 5,
            "unique_id": "PAY0000005",
            "total_amount": 500.49,
            "payment_status": "Not Paid",
            "created_at": "2021-03-08 03:05:07 pm"
        }
    },
    "prescription": {
        "id": 257,
        "appointment_id": 460,
        "unique_id": "PX0000257",
        "created_at": "2021-02-26",
        "pdf_url": null,
        "patient": {
            "id": 22,
            "first_name": "Vishnu",
            "middle_name": "S",
            "last_name": "Sharma",
            "email": "vishnusharmatest123@yopmail.com",
            "country_code": "+91",
            "mobile_number": "3736556464",
            "profile_photo_url": null
        },
        "status_medicine": "Quote generated.",
        "appointment": {
            "id": 460,
            "doctor_id": 121,
            "patient_id": 123,
            "appointment_unique_id": "AP0000460",
            "date": "2021-02-26",
            "time": "18:43:00",
            "start_time": "18:43:00",
            "end_time": "18:45:00",
            "consultation_type": "ONLINE",
            "shift": null,
            "payment_status": null,
            "transaction_id": null,
            "total": null,
            "tax": null,
            "is_cancelled": 0,
            "is_completed": 1,
            "followup_id": null,
            "booking_date": "2021-02-26",
            "current_patient_info": {
                "user": {
                    "first_name": "Beny",
                    "middle_name": "K",
                    "last_name": "Sebastian",
                    "email": "benyseba@gmail.com",
                    "country_code": "+91",
                    "mobile_number": "9090871555",
                    "profile_photo_url": null
                },
                "case": 1,
                "info": {
                    "first_name": "Beny",
                    "middle_name": "K",
                    "last_name": "Sebastian",
                    "email": "benyseba@gmail.com",
                    "country_code": "+91",
                    "mobile_number": "9090871555",
                    "height": 150,
                    "weight": 60,
                    "gender": "MALE",
                    "age": 34
                }
            },
            "doctor": {
                "id": 121,
                "first_name": "Joji",
                "middle_name": "S",
                "last_name": "Thilak",
                "email": "jojidev@gmail.com",
                "username": "Joji",
                "country_code": "+91",
                "mobile_number": "8890786512",
                "user_type": "DOCTOR",
                "is_active": "1",
                "role": null,
                "currency_code": "INR",
                "approved_date": "2021-02-12",
                "profile_photo_url": null
            }
        }
    }
}
```
> Example response (404):

```json
{
    "message": "Record not found."
}
```

### HTTP Request
`GET api/laboratory/quote/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of quote

<!-- END_9d5971042bb0841018d20957b7479a91 -->

<!-- START_aaea7cbd2896d97674d96697aa1835ab -->
## Laboratory list payouts

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/laboratory/payouts?paid=magnam" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/laboratory/payouts"
);

let params = {
    "paid": "magnam",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "paid": [
            "The paid field must be present."
        ]
    }
}
```
> Example response (200):

```json
{
    "next_payout_period": "28 March 2021 11:59 PM",
    "current_page": 1,
    "data": [
        {
            "id": 64,
            "unique_id": "ORD0000064",
            "user_id": 3,
            "tax": 1.8,
            "subtotal": 200,
            "discount": 5,
            "delivery_charge": 10,
            "total": 206.8,
            "commission": 10,
            "shipping_address_id": 75,
            "payment_status": "Paid",
            "delivery_status": "Open",
            "delivery_info": null,
            "created_at": "2021-03-23 06:08:39 pm",
            "user": {
                "id": 3,
                "first_name": "Test",
                "middle_name": "middle",
                "last_name": "Patient",
                "email": "patient@logidots.com",
                "country_code": "+91",
                "mobile_number": "9876543210",
                "profile_photo_url": null
            },
            "payments": {
                "id": 285,
                "unique_id": "PAY0000285",
                "total_amount": 206.8,
                "payment_status": "Paid",
                "created_at": "2021-03-23 06:08:39 pm"
            }
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/pharmacy\/payouts?page=1",
    "from": 1,
    "last_page": 7,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/pharmacy\/payouts?page=7",
    "next_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/pharmacy\/payouts?page=2",
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/pharmacy\/payouts",
    "per_page": 1,
    "prev_page_url": null,
    "to": 1,
    "total": 7
}
```
> Example response (404):

```json
{
    "message": "No records found."
}
```

### HTTP Request
`GET api/laboratory/payouts`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `paid` |  optional  | present integer 0 for unpaid , 1 for paid

<!-- END_aaea7cbd2896d97674d96697aa1835ab -->

#Lab test


<!-- START_b88ac28aad34e8c461c3e61c165307e5 -->
## List Laboratory tests

> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/guest/labtest?paginate=rerum" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/guest/labtest"
);

let params = {
    "paginate": "rerum",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
[
    {
        "id": 1,
        "name": "Eco",
        "unique_id": "LAT0000001",
        "price": 300,
        "currency_code": "INR",
        "code": "ECO",
        "image": "http:\/\/localhost\/fms-api-laravel\/public\/storage\/uploads\/labtest\/1608825075tiger.jpg"
    }
]
```
> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "name": "Eco",
            "unique_id": "LAT0000001",
            "price": 300,
            "currency_code": "INR",
            "code": "ECO",
            "image": "http:\/\/localhost\/fms-api-laravel\/public\/storage\/uploads\/labtest\/1608825075tiger.jpg"
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/guest\/labtest?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/guest\/labtest?page=1",
    "next_page_url": null,
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/guest\/labtest",
    "per_page": 10,
    "prev_page_url": null,
    "to": 1,
    "total": 1
}
```
> Example response (404):

```json
{
    "message": "No records found."
}
```

### HTTP Request
`GET api/guest/labtest`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `paginate` |  optional  | integer nullable paginate = 0

<!-- END_b88ac28aad34e8c461c3e61c165307e5 -->

<!-- START_edd5071f35ea6c8ee39ef97da9524f9c -->
## Search Laboratory tests

> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/guest/search/labtest?paginate=minus&name=nobis" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/guest/search/labtest"
);

let params = {
    "paginate": "minus",
    "name": "nobis",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "paginate": [
            "The selected paginate is invalid."
        ]
    }
}
```

### HTTP Request
`GET api/guest/search/labtest`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `paginate` |  optional  | integer nullable paginate = 0
    `name` |  optional  | nullable string

<!-- END_edd5071f35ea6c8ee39ef97da9524f9c -->

<!-- START_af8ec42a02f46f11adf3719b8d078810 -->
## Admin add Laboratory test

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/admin/labtest" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"qui","image":"tenetur","code":"alias","price":5923,"currency_code":"voluptates"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/labtest"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "qui",
    "image": "tenetur",
    "code": "alias",
    "price": 5923,
    "currency_code": "voluptates"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "name": [
            "The name field is required."
        ],
        "price": [
            "The price field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Saved successfully."
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "name": [
            "The name has already been taken."
        ]
    }
}
```

### HTTP Request
`POST api/admin/labtest`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `name` | string |  required  | 
        `image` | file |  optional  | nullable mimes:jpg,jpeg,png max:2mb
        `code` | string |  optional  | nullable
        `price` | float |  required  | 
        `currency_code` | string |  optional  | nullable
    
<!-- END_af8ec42a02f46f11adf3719b8d078810 -->

<!-- START_40cc86421180e2db2ec74a871d397fcb -->
## Admin update Laboratory test

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/admin/labtest/1?id=accusantium" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"vel","price":43.977862013,"currency_code":"placeat","image":"ut","code":"quis"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/labtest/1"
);

let params = {
    "id": "accusantium",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "vel",
    "price": 43.977862013,
    "currency_code": "placeat",
    "image": "ut",
    "code": "quis"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (404):

```json
{
    "message": "Record not found."
}
```
> Example response (200):

```json
{
    "message": "Record updated successfully."
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "name": [
            "The name has already been taken."
        ]
    }
}
```

### HTTP Request
`POST api/admin/labtest/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of record
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `name` | string |  required  | 
        `price` | float |  required  | 
        `currency_code` | string |  optional  | nullable
        `image` | file |  optional  | nullable mimes:jpg,jpeg,png max:2mb
        `code` | string |  optional  | nullable
    
<!-- END_40cc86421180e2db2ec74a871d397fcb -->

<!-- START_f2a4a9e2983df6d3b896ea88a0d21209 -->
## Admin delete Laboratory test

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X DELETE \
    "http://localhost/fms-api-laravel/public/api/admin/labtest/1?id=similique" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/labtest/1"
);

let params = {
    "id": "similique",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (404):

```json
{
    "message": "Record not found."
}
```
> Example response (200):

```json
{
    "message": "Record deleted successfully."
}
```

### HTTP Request
`DELETE api/admin/labtest/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of record

<!-- END_f2a4a9e2983df6d3b896ea88a0d21209 -->

<!-- START_531843d90841c5e8c51a3b16e361ff4d -->
## Admin get Laboratory test by id

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/admin/labtest/1?id=iste" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/admin/labtest/1"
);

let params = {
    "id": "iste",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "id": 1,
    "name": "Chloroform",
    "unique_id": "LAB0000001",
    "code": null,
    "image": null
}
```
> Example response (404):

```json
{
    "message": "Record not found."
}
```

### HTTP Request
`GET api/admin/labtest/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of record

<!-- END_531843d90841c5e8c51a3b16e361ff4d -->

#Orders


<!-- START_e5925bec046cd9987068c51d8235f102 -->
## User place order

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/orders/checkout" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"quote_id":6,"tax":0,"subtotal":39.2246,"discount":2.1,"delivery_charge":0.394549,"total":110.792062641,"commission":2663.7,"shipping_address_id":6,"pharma_lab_id":19,"type":20,"order_items":[{"item_id":20,"price":5.39975,"quantity":4}]}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/orders/checkout"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "quote_id": 6,
    "tax": 0,
    "subtotal": 39.2246,
    "discount": 2.1,
    "delivery_charge": 0.394549,
    "total": 110.792062641,
    "commission": 2663.7,
    "shipping_address_id": 6,
    "pharma_lab_id": 19,
    "type": 20,
    "order_items": [
        {
            "item_id": 20,
            "price": 5.39975,
            "quantity": 4
        }
    ]
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "tax": [
            "The tax field is required."
        ],
        "subtotal": [
            "The subtotal field is required."
        ],
        "discount": [
            "The discount field is required."
        ],
        "delivery_charge": [
            "The delievery charge field is required."
        ],
        "total": [
            "The total field is required."
        ],
        "shipping_address_id": [
            "The shipping address id field is required."
        ],
        "pharma_lab_id": [
            "The pharma lab id field is required."
        ],
        "type": [
            "The type field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "razorpay_order_id": "order_GhKYoQJVtCf928",
    "currency": "INR",
    "order_id": 2,
    "total": "140",
    "name": "James Anderson",
    "email": "james.andersontest66@yopmail.com"
}
```

### HTTP Request
`POST api/orders/checkout`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `quote_id` | integer |  required  | 
        `tax` | float |  required  | 
        `subtotal` | float |  required  | 
        `discount` | float |  required  | 
        `delivery_charge` | float |  required  | 
        `total` | float |  required  | 
        `commission` | float |  required  | 
        `shipping_address_id` | integer |  required  | id of selected address
        `pharma_lab_id` | integer |  required  | pharmacy or laboratory id from  quote_from object
        `type` | integer |  required  | MED,LAB -> returned from  quote_from object
        `order_items` | array |  required  | 
        `order_items.*.item_id` | integer |  required  | 
        `order_items.*.price` | float |  required  | 
        `order_items.*.quantity` | integer |  required  | 
    
<!-- END_e5925bec046cd9987068c51d8235f102 -->

<!-- START_a2d775a2df639e0362d2f5c5c7bd0f3d -->
## User confirm payment

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/orders/confirmpayment" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"razorpay_payment_id":"provident","razorpay_order_id":"ducimus","razorpay_signature":"architecto"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/orders/confirmpayment"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "razorpay_payment_id": "provident",
    "razorpay_order_id": "ducimus",
    "razorpay_signature": "architecto"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "razorpay_payment_id": [
            "The razorpay payment id field is required."
        ],
        "razorpay_order_id": [
            "The razorpay order id field is required."
        ],
        "razorpay_signature": [
            "The razorpay signature field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Payment successfull."
}
```
> Example response (422):

```json
{
    "message": "Invalid signature passed."
}
```
> Example response (422):

```json
{
    "message": "OrderId not found."
}
```

### HTTP Request
`POST api/orders/confirmpayment`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `razorpay_payment_id` | string |  required  | 
        `razorpay_order_id` | string |  required  | 
        `razorpay_signature` | string |  required  | 
    
<!-- END_a2d775a2df639e0362d2f5c5c7bd0f3d -->

<!-- START_f9301c03a9281c0847565f96e6f723de -->
## Get order list Patient, Pharmacy, Laboratory

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/orders?type=et&delivery_status=doloremque" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/orders"
);

let params = {
    "type": "et",
    "delivery_status": "doloremque",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 6,
            "unique_id": null,
            "user_id": 3,
            "tax": 10,
            "subtotal": 20,
            "discount": 2,
            "delivery_charge": 2,
            "total": 500.49,
            "shipping_address_id": 1,
            "payment_status": "Paid",
            "delivery_status": "Pending",
            "delivery_info": null,
            "created_at": "2021-03-04 10:25:40 am",
            "quote": {
                "quote_from": {
                    "id": 1,
                    "name": "Pharmacy Name",
                    "address": [
                        {
                            "id": 4,
                            "street_name": "50\/23",
                            "city_village": "Tirunelveli",
                            "district": "Tirunelveli",
                            "state": "Tamil Nadu",
                            "country": "India",
                            "pincode": "627354",
                            "country_code": null,
                            "contact_number": null,
                            "land_mark": null,
                            "latitude": "8.55160940",
                            "longitude": "77.76987023",
                            "clinic_name": null
                        }
                    ]
                }
            }
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/orders?page=1",
    "from": 1,
    "last_page": 6,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/orders?page=6",
    "next_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/orders?page=2",
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/orders",
    "per_page": 1,
    "prev_page_url": null,
    "to": 1,
    "total": 6
}
```
> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 9,
            "unique_id": null,
            "user_id": 3,
            "tax": 10,
            "subtotal": 20,
            "discount": 2,
            "delivery_charge": 2,
            "total": 500.49,
            "shipping_address_id": 1,
            "payment_status": "Not Paid",
            "delivery_status": "Pending",
            "delivery_info": null,
            "created_at": "2021-03-08 03:16:16 pm",
            "quote": {
                "quote_from": {
                    "id": 11,
                    "name": "Lifeline Labs Pvt ltd",
                    "address": [
                        {
                            "id": 164,
                            "street_name": "Near sunshine Apartments",
                            "city_village": "Telengana",
                            "district": "Hyderabad",
                            "state": "Telangana",
                            "country": "India",
                            "pincode": "500001",
                            "country_code": null,
                            "contact_number": null,
                            "land_mark": null,
                            "latitude": "17.38743640",
                            "longitude": "78.47217290",
                            "clinic_name": null
                        }
                    ]
                }
            }
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/orders?page=1",
    "from": 1,
    "last_page": 2,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/orders?page=2",
    "next_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/orders?page=2",
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/orders",
    "per_page": 1,
    "prev_page_url": null,
    "to": 1,
    "total": 2
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "type": [
            "The type field is required."
        ]
    }
}
```
> Example response (404):

```json
{
    "message": "Orders not found."
}
```

### HTTP Request
`GET api/orders`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `type` |  required  | string MED for orders from pharmacy , LAB for orders from laboratory. SEND THIS PARAM ONLY FOR REQUEST FROM PATIENT LOGIN.
    `delivery_status` |  optional  | nullable string values -> Pending,In-Progress,Completed SEND THIS PARAM ONLY FOR REQUEST FROM PATIENT LOGIN.

<!-- END_f9301c03a9281c0847565f96e6f723de -->

<!-- START_b411f4cf8f5665cfcdf08fa028d739e7 -->
## Get order details by Id  Patient, Pharmacy, Laboratory

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/orders/1?id=sint" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/orders/1"
);

let params = {
    "id": "sint",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "id": 9,
    "unique_id": null,
    "user_id": 3,
    "tax": 10,
    "subtotal": 20,
    "discount": 2,
    "delivery_charge": 2,
    "total": 500.49,
    "shipping_address_id": 1,
    "payment_status": "Not Paid",
    "delivery_status": "Pending",
    "delivery_info": null,
    "created_at": "2021-03-08 03:16:16 pm",
    "quote": {
        "created_at": "2021-03-01 03:46:59 pm",
        "quote_from": {
            "id": 11,
            "name": "Lifeline Labs Pvt ltd",
            "address": [
                {
                    "id": 164,
                    "street_name": "Near sunshine Apartments",
                    "city_village": "Telengana",
                    "district": "Hyderabad",
                    "state": "Telangana",
                    "country": "India",
                    "pincode": "500001",
                    "country_code": null,
                    "contact_number": null,
                    "land_mark": null,
                    "latitude": "17.38743640",
                    "longitude": "78.47217290",
                    "clinic_name": null
                }
            ]
        }
    },
    "quote_contact": {
        "id": 1,
        "country_code": "+91",
        "mobile_number": "8610025593",
        "profile_photo_url": null
    },
    "order_items": [
        {
            "id": 7,
            "item_id": 1,
            "price": 10,
            "quantity": 1,
            "item_details": {
                "id": 1,
                "name": "Blood New",
                "unique_id": "LAT0000001",
                "price": 555,
                "currency_code": "INR",
                "code": "BL New Test.",
                "image": null
            }
        }
    ],
    "billing_address": [
        {
            "id": 1,
            "street_name": "South Road",
            "city_village": "Edamatto",
            "district": "Kottayam",
            "state": "Kerala",
            "country": "India",
            "pincode": "686575",
            "country_code": null,
            "contact_number": "9786200983",
            "land_mark": null,
            "latitude": "10.53034500",
            "longitude": "76.21472900",
            "clinic_name": "Neo clinic"
        }
    ]
}
```
> Example response (200):

```json
{
    "id": 1,
    "user_id": 3,
    "tax": 10,
    "subtotal": 20,
    "discount": 2,
    "delivery_charge": 2,
    "total": 500.49,
    "shipping_address_id": 1,
    "payment_status": "Not Paid",
    "delivery_status": "Pending",
    "delivery_info": null,
    "created_at": "2021-03-02 06:29:02 pm",
    "order_items": [
        {
            "id": 1,
            "item_id": 1,
            "price": 10,
            "quantity": 1,
            "item_details": {
                "id": 1,
                "category_id": 1,
                "sku": "MED0000001",
                "composition": "Paracetamol",
                "weight": 50,
                "weight_unit": "kg",
                "name": "Ammu",
                "manufacturer": "Ammu Corporation",
                "medicine_type": "Drops",
                "drug_type": "Branded",
                "qty_per_strip": 10,
                "price_per_strip": 45,
                "rate_per_unit": 4.5,
                "rx_required": 0,
                "short_desc": "This is a good product",
                "long_desc": "This is a good product",
                "cart_desc": "This is a good product",
                "image_name": null,
                "image_url": null
            }
        }
    ]
}
```
> Example response (404):

```json
{
    "message": "OrderId not found."
}
```

### HTTP Request
`GET api/orders/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of order

<!-- END_b411f4cf8f5665cfcdf08fa028d739e7 -->

<!-- START_ff07237b5ede60d2c55fb0cd3a3aacc0 -->
## Edit order details by Id

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/orders/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"delivery_status":"qui","delivery_info":"non","sample":{"date":"voluptas","time":"autem","name":"qui"}}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/orders/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "delivery_status": "qui",
    "delivery_info": "non",
    "sample": {
        "date": "voluptas",
        "time": "autem",
        "name": "qui"
    }
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "delivery_status": [
            "The delivery status field is required."
        ],
        "sample.date": [
            "The sample.date field is required."
        ],
        "sample.time": [
            "The sample.time does not match the format h:i A."
        ],
        "sample.name": [
            "The sample.name field is required."
        ]
    }
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "delivery_status": [
            "The delivery status field is required."
        ],
        "delivery_info": [
            "The delivery info field must be present."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "order updated successfully."
}
```
> Example response (404):

```json
{
    "message": "Order not found."
}
```

### HTTP Request
`POST api/orders/{id}`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `delivery_status` | string |  required  | In-Progress or Completed
        `delivery_info` | string |  required  | 
        `sample` | array |  required  | 
        `sample.date` | date |  required  | format-> Y-m-d
        `sample.time` | string |  required  | format 10:30 AM
        `sample.name` | string |  required  | 
    
<!-- END_ff07237b5ede60d2c55fb0cd3a3aacc0 -->

#Patient


<!-- START_d03e51c9d2346dc974a8cd8e858d187b -->
## Cancel order by Id

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/orders/cancel" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"order_id":15}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/orders/cancel"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "order_id": 15
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "order_id": [
            "The selected order id is invalid."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "order cancelled successfully."
}
```
> Example response (404):

```json
{
    "message": "Order can't be cancelled."
}
```

### HTTP Request
`POST api/orders/cancel`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `order_id` | integer |  required  | id of order
    
<!-- END_d03e51c9d2346dc974a8cd8e858d187b -->

<!-- START_373c2d74a6e37d4e06c1abb8f042fc98 -->
## Patient get profile details

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/patient/profile" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/patient/profile"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "title": "mr",
    "gender": "MALE",
    "date_of_birth": "1998-06-19",
    "age": 27,
    "blood_group": "B+ve",
    "height": null,
    "weight": null,
    "marital_status": null,
    "occupation": null,
    "alt_mobile_number": "8610025593",
    "first_name": "theo",
    "middle_name": "ben",
    "last_name": "phil",
    "email": "theophilus@logidots.com",
    "alt_country_code": "+91",
    "mobile_number": "8610025593",
    "country_code": "+91",
    "username": "user12345",
    "national_health_id": "HEAT-9887"
}
```
> Example response (404):

```json
{
    "message": "Profile details not found"
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/patient/profile`


<!-- END_373c2d74a6e37d4e06c1abb8f042fc98 -->

<!-- START_54cebaeaa208fac791824e4788a34480 -->
## Patient edit profile details

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/patient/profile" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"title":"earum","first_name":"hic","middle_name":"blanditiis","last_name":"neque","gender":"voluptas","date_of_birth":"esse","age":259849.8,"blood_group":"quaerat","height":488.431035,"weight":536332806.1176605,"marital_status":"qui","occupation":"nisi","alt_mobile_number":"accusantium","alt_country_code":"nulla","email":"magni","mobile_number":"voluptatem","country_code":"necessitatibus","profile_photo":"laborum","national_health_id":"et"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/patient/profile"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "title": "earum",
    "first_name": "hic",
    "middle_name": "blanditiis",
    "last_name": "neque",
    "gender": "voluptas",
    "date_of_birth": "esse",
    "age": 259849.8,
    "blood_group": "quaerat",
    "height": 488.431035,
    "weight": 536332806.1176605,
    "marital_status": "qui",
    "occupation": "nisi",
    "alt_mobile_number": "accusantium",
    "alt_country_code": "nulla",
    "email": "magni",
    "mobile_number": "voluptatem",
    "country_code": "necessitatibus",
    "profile_photo": "laborum",
    "national_health_id": "et"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "title": [
            "The title field is required."
        ],
        "first_name": [
            "The first name field is required."
        ],
        "last_name": [
            "The last name field is required."
        ],
        "gender": [
            "The gender field is required."
        ],
        "date_of_birth": [
            "The date of birth field is required."
        ],
        "age": [
            "The age field is required."
        ],
        "blood_group": [
            "The blood group field is required."
        ],
        "height": [
            "The height field is required."
        ],
        "weight": [
            "The weight field is required."
        ],
        "marital_status": [
            "The marital status field is required."
        ],
        "occupation": [
            "The occupation field is required."
        ],
        "alt_mobile_number": [
            "The alt mobile number field is required."
        ],
        "email": [
            "The email field is required."
        ],
        "mobile_number": [
            "The mobile number field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Details saved successfully."
}
```

### HTTP Request
`POST api/patient/profile`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `title` | string |  required  | 
        `first_name` | string |  required  | 
        `middle_name` | string |  optional  | nullable
        `last_name` | string |  required  | 
        `gender` | string |  required  | any one of ['MALE', 'FEMALE', 'OTHERS']
        `date_of_birth` | date |  required  | format -> Y-m-d
        `age` | float |  required  | 
        `blood_group` | string |  optional  | nullable
        `height` | float |  optional  | nullable
        `weight` | float |  optional  | nullable
        `marital_status` | string |  optional  | nullable, if filled, any one of ['SINGLE', 'MARRIED', 'DIVORCED', 'WIDOWED']
        `occupation` | string |  optional  | nullable
        `alt_mobile_number` | string |  optional  | nullable
        `alt_country_code` | string |  optional  | nullable required if alt_mobile_number is filled
        `email` | email |  required  | if edited verify using OTP
        `mobile_number` | string |  required  | if edited verify using OTP
        `country_code` | string |  required  | if mobile_number is edited
        `profile_photo` | file |  optional  | nullable File mime:jpg,jpeg,png size max 2mb
        `national_health_id` | string |  optional  | nullable
    
<!-- END_54cebaeaa208fac791824e4788a34480 -->

<!-- START_c2853559dbf83a47c142cdf1fce792f9 -->
## Patient add BPL info and Emergency contact details.

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/patient/contact/emergency" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"current_medication":"aliquam","bpl_file_number":"est","bpl_file":"sit","first_name_primary":"tempora","middle_name_primary":"magni","last_name_primary":"perferendis","mobile_number_primary":"rerum","country_code_primary":"labore","relationship_primary":"numquam","first_name_secondary":"sunt","middle_name_secondary":"repellendus","last_name_secondary":"quia","mobile_number_secondary":"ut","country_code_secondary":"similique","relationship_secondary":"et"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/patient/contact/emergency"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "current_medication": "aliquam",
    "bpl_file_number": "est",
    "bpl_file": "sit",
    "first_name_primary": "tempora",
    "middle_name_primary": "magni",
    "last_name_primary": "perferendis",
    "mobile_number_primary": "rerum",
    "country_code_primary": "labore",
    "relationship_primary": "numquam",
    "first_name_secondary": "sunt",
    "middle_name_secondary": "repellendus",
    "last_name_secondary": "quia",
    "mobile_number_secondary": "ut",
    "country_code_secondary": "similique",
    "relationship_secondary": "et"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "Details saved successfully."
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "bpl_file": [
            "The bpl file field is required when bpl file number is present."
        ],
        "first_name_primary": [
            "The first name primary field is required."
        ],
        "middle_name_primary": [
            "The middle name primary field is required."
        ],
        "last_name_primary": [
            "The last name primary field is required."
        ],
        "mobile_number_primary": [
            "The mobile number primary field is required."
        ],
        "relationship_primary": [
            "The selected relationship primary is invalid."
        ]
    }
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`POST api/patient/contact/emergency`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `current_medication` | string |  optional  | nullable
        `bpl_file_number` | string |  optional  | nullable
        `bpl_file` | file |  optional  | nullable if bpl_file_number is filled required File mime:pdf,jpg,jpeg,png size max 2mb
        `first_name_primary` | string |  required  | 
        `middle_name_primary` | string |  optional  | nullable
        `last_name_primary` | string |  required  | 
        `mobile_number_primary` | string |  required  | 
        `country_code_primary` | string |  required  | 
        `relationship_primary` | string |  required  | ['FATHER', 'MOTHER', 'DAUGHTER', 'SON', 'HUSBAND', 'WIFE', 'GRANDFATHER', 'GRANDMOTHER','BROTHER', 'OTHERS']
        `first_name_secondary` | string |  optional  | nullable
        `middle_name_secondary` | string |  optional  | nullable
        `last_name_secondary` | string |  optional  | nullable
        `mobile_number_secondary` | string |  optional  | nullable
        `country_code_secondary` | string |  optional  | nullable if mobile_number_secondary is filled
        `relationship_secondary` | string |  optional  | nullable if filled, any one of ['FATHER', 'MOTHER', 'DAUGHTER', 'SON', 'HUSBAND', 'WIFE', 'GRANDFATHER', 'GRANDMOTHER','BROTHER', 'OTHERS']
    
<!-- END_c2853559dbf83a47c142cdf1fce792f9 -->

<!-- START_ff25f122b4f326bfd7462bd9c1e89f02 -->
## Patient get BPL info and Emergency contact details.

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/patient/contact/emergency" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/patient/contact/emergency"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "first_name_primary": "THEO",
    "middle_name_primary": "BEN",
    "last_name_primary": "PHIL",
    "country_code_primary": "+91",
    "mobile_number_primary": "+914867857682",
    "relationship_primary": "SON",
    "first_name_secondary": "",
    "middle_name_secondary": "",
    "last_name_secondary": "",
    "country_code_secondary": "+91",
    "mobile_number_secondary": "",
    "relationship_secondary": "",
    "current_medication": "No",
    "bpl_file_number": "123456",
    "bpl_file": "HLD- FMS_V1.pdf"
}
```
> Example response (404):

```json
{
    "message": "No records found."
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/patient/contact/emergency`


<!-- END_ff25f122b4f326bfd7462bd9c1e89f02 -->

<!-- START_28dd6bfac245244daee9927aa6fb4042 -->
## Patient get BPL file to download

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/patient/profile/bplfile" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/patient/profile/bplfile"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "file": "file downloads directly"
}
```
> Example response (404):

```json
{
    "message": "File not found."
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/patient/profile/bplfile`


<!-- END_28dd6bfac245244daee9927aa6fb4042 -->

<!-- START_8b1e33e6edea4456727c986186d2ad63 -->
## Patient add address

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/patient/address" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"pincode":6,"street_name":"est","city_village":"doloremque","district":"inventore","state":"officiis","country":"adipisci","contact_number":"recusandae","country_code":"dolore","land_mark":"aut","address_type":"cum"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/patient/address"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "pincode": 6,
    "street_name": "est",
    "city_village": "doloremque",
    "district": "inventore",
    "state": "officiis",
    "country": "adipisci",
    "contact_number": "recusandae",
    "country_code": "dolore",
    "land_mark": "aut",
    "address_type": "cum"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "pincode": [
            "The pincode field is required."
        ],
        "street_name": [
            "The street name field is required."
        ],
        "city_village": [
            "The city village field is required."
        ],
        "district": [
            "The district field is required."
        ],
        "state": [
            "The state field is required."
        ],
        "country": [
            "The country field is required."
        ],
        "address_type": [
            "The address type field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Address added successfully"
}
```

### HTTP Request
`POST api/patient/address`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `pincode` | integer |  required  | length 6
        `street_name` | string |  required  | Street Name/ House No./ Area
        `city_village` | string |  required  | City/Village
        `district` | string |  required  | 
        `state` | string |  required  | 
        `country` | string |  required  | 
        `contact_number` | string |  required  | 
        `country_code` | string |  required  | 
        `land_mark` | string |  required  | 
        `address_type` | string |  required  | anyone of ['HOME', 'WORK', 'OTHERS']
    
<!-- END_8b1e33e6edea4456727c986186d2ad63 -->

<!-- START_b0a8e410ca439402365bb6f79379adf4 -->
## Patient edit address

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/patient/address/1?id=perspiciatis" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"pincode":"ex","street_name":"illo","city_village":"officia","district":"nam","state":"voluptatem","country":"consequatur","address_type":"suscipit","contact_number":"vitae","country_code":"sed","land_mark":"vero"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/patient/address/1"
);

let params = {
    "id": "perspiciatis",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "pincode": "ex",
    "street_name": "illo",
    "city_village": "officia",
    "district": "nam",
    "state": "voluptatem",
    "country": "consequatur",
    "address_type": "suscipit",
    "contact_number": "vitae",
    "country_code": "sed",
    "land_mark": "vero"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "pincode": [
            "The pincode field is required."
        ],
        "street_name": [
            "The street name field is required."
        ],
        "city_village": [
            "The city village field is required."
        ],
        "district": [
            "The district field is required."
        ],
        "state": [
            "The state field is required."
        ],
        "country": [
            "The country field is required."
        ],
        "address_type": [
            "The address type field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Address updated successfully"
}
```
> Example response (404):

```json
{
    "message": "Address not found"
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`POST api/patient/address/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of record
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `pincode` | string |  required  | 
        `street_name` | string |  required  | Street Name/ House No./ Area
        `city_village` | string |  required  | City/Village
        `district` | string |  required  | 
        `state` | string |  required  | 
        `country` | string |  required  | 
        `address_type` | string |  required  | anyone of ['HOME', 'WORK', 'OTHERS']
        `contact_number` | string |  required  | 
        `country_code` | string |  required  | 
        `land_mark` | string |  required  | 
    
<!-- END_b0a8e410ca439402365bb6f79379adf4 -->

<!-- START_19f02540227923d8a5b9b38e04af4c68 -->
## Patient list address

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/patient/address" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/patient/address"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "address_type": "WORK",
            "street_name": "Middle",
            "city_village": "lane",
            "district": "london",
            "state": "state",
            "country": "india",
            "pincode": "627354",
            "country_code": "+91",
            "contact_number": "987654321"
        },
        {
            "id": 2,
            "address_type": "WORK",
            "street_name": "Middle",
            "city_village": "lane",
            "district": "london",
            "state": "state",
            "country": "india",
            "pincode": "627354",
            "country_code": "+91",
            "contact_number": "987654321"
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/listaddress?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/listaddress?page=1",
    "next_page_url": null,
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/listaddress",
    "per_page": 20,
    "prev_page_url": null,
    "to": 2,
    "total": 2
}
```
> Example response (404):

```json
{
    "message": "No records found."
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/patient/address`


<!-- END_19f02540227923d8a5b9b38e04af4c68 -->

<!-- START_c3ea63e74e65f2937f6888111d66aafe -->
## Patient get address by id

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/patient/address/1?id=dolor" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/patient/address/1"
);

let params = {
    "id": "dolor",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "id": 1,
    "address_type": "WORK",
    "street_name": "Middle",
    "city_village": "lane",
    "district": "london",
    "state": "state",
    "country": "india",
    "pincode": "627001",
    "country_code": "+91",
    "contact_number": "987654321"
}
```
> Example response (404):

```json
{
    "message": "Address not found"
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/patient/address/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of record

<!-- END_c3ea63e74e65f2937f6888111d66aafe -->

<!-- START_c38bcee2286a66ae83ceff95b6eb559c -->
## Patient delete address

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X DELETE \
    "http://localhost/fms-api-laravel/public/api/patient/address/1?id=ipsa" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/patient/address/1"
);

let params = {
    "id": "ipsa",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "Address deleted successfully."
}
```
> Example response (404):

```json
{
    "message": "Address not found."
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`DELETE api/patient/address/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of record

<!-- END_c38bcee2286a66ae83ceff95b6eb559c -->

<!-- START_dd9919e801fdacc9b83d1d964435fe4e -->
## Patient add family member

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/patient/family" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"title":"nihil","first_name":"quia","middle_name":"ipsam","last_name":"et","gender":"rerum","date_of_birth":"sed","age":5.228909,"height":252.8831,"weight":7580196.251079,"marital_status":"et","relationship":"corporis","occupation":"molestiae","current_medication":"facilis","country_code":"et","contact_number":"consequatur","national_health_id":"quibusdam"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/patient/family"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "title": "nihil",
    "first_name": "quia",
    "middle_name": "ipsam",
    "last_name": "et",
    "gender": "rerum",
    "date_of_birth": "sed",
    "age": 5.228909,
    "height": 252.8831,
    "weight": 7580196.251079,
    "marital_status": "et",
    "relationship": "corporis",
    "occupation": "molestiae",
    "current_medication": "facilis",
    "country_code": "et",
    "contact_number": "consequatur",
    "national_health_id": "quibusdam"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "title": [
            "The title field is required."
        ],
        "first_name": [
            "The first name field is required."
        ],
        "last_name": [
            "The last name field is required."
        ],
        "gender": [
            "The gender field is required."
        ],
        "date_of_birth": [
            "The date of birth field is required."
        ],
        "age": [
            "The age field is required."
        ],
        "relationship": [
            "The selected relationship is invalid."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Family member added successfully."
}
```
> Example response (404):

```json
{
    "message": "Patient not found."
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```
> Example response (422):

```json
{
    "message": "Duplicate entry found."
}
```

### HTTP Request
`POST api/patient/family`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `title` | string |  required  | 
        `first_name` | string |  required  | 
        `middle_name` | string |  optional  | nullable
        `last_name` | string |  required  | 
        `gender` | string |  required  | any one of ['MALE', 'FEMALE', 'OTHERS']
        `date_of_birth` | date |  required  | format -> Y-m-d
        `age` | float |  required  | 
        `height` | float |  optional  | nullable
        `weight` | float |  optional  | nullable
        `marital_status` | string |  optional  | nullable, if filled, any one of ['SINGLE', 'MARRIED', 'DIVORCED', 'WIDOWED']
        `relationship` | string |  required  | any one of ['FATHER', 'MOTHER', 'DAUGHTER', 'SON', 'HUSBAND', 'WIFE', 'GRANDFATHER', 'GRANDMOTHER','BROTHER', 'OTHERS']
        `occupation` | string |  optional  | nullable
        `current_medication` | string |  optional  | nullable
        `country_code` | string |  optional  | nullable
        `contact_number` | string |  optional  | nullable
        `national_health_id` | string |  optional  | nullable
    
<!-- END_dd9919e801fdacc9b83d1d964435fe4e -->

<!-- START_0a71301ee2e2509b77b4bba915bd7974 -->
## Patient edit family member

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/patient/family/1?id=corrupti" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"title":"voluptas","first_name":"eos","middle_name":"a","last_name":"a","gender":"nesciunt","date_of_birth":"repellat","age":3875.73684996,"height":79.434,"weight":1367.9,"marital_status":"possimus","relationship":"doloribus","occupation":"voluptas","current_medication":"dolorem","country_code":"asperiores","contact_number":"deserunt","national_health_id":"nulla"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/patient/family/1"
);

let params = {
    "id": "corrupti",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "title": "voluptas",
    "first_name": "eos",
    "middle_name": "a",
    "last_name": "a",
    "gender": "nesciunt",
    "date_of_birth": "repellat",
    "age": 3875.73684996,
    "height": 79.434,
    "weight": 1367.9,
    "marital_status": "possimus",
    "relationship": "doloribus",
    "occupation": "voluptas",
    "current_medication": "dolorem",
    "country_code": "asperiores",
    "contact_number": "deserunt",
    "national_health_id": "nulla"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "title": [
            "The title field is required."
        ],
        "first_name": [
            "The first name field is required."
        ],
        "last_name": [
            "The last name field is required."
        ],
        "gender": [
            "The gender field is required."
        ],
        "date_of_birth": [
            "The date of birth field is required."
        ],
        "age": [
            "The age field is required."
        ],
        "relationship": [
            "The selected relationship is invalid."
        ]
    }
}
```
> Example response (404):

```json
{
    "message": "Family member not found."
}
```
> Example response (200):

```json
{
    "message": "Family member updated successfully."
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```
> Example response (422):

```json
{
    "message": "Duplicate entry found."
}
```

### HTTP Request
`POST api/patient/family/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of record
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `title` | string |  required  | 
        `first_name` | string |  required  | 
        `middle_name` | string |  optional  | nullable
        `last_name` | string |  required  | 
        `gender` | string |  required  | any one of ['MALE', 'FEMALE', 'OTHERS']
        `date_of_birth` | date |  required  | format -> Y-m-d
        `age` | float |  required  | 
        `height` | float |  optional  | nullable
        `weight` | float |  optional  | nullable
        `marital_status` | string |  optional  | nullable, if filled, any one of ['SINGLE', 'MARRIED', 'DIVORCED', 'WIDOWED']
        `relationship` | string |  required  | any one of ['FATHER', 'MOTHER', 'DAUGHTER', 'SON', 'HUSBAND', 'WIFE', 'GRANDFATHER', 'GRANDMOTHER','BROTHER', 'OTHERS']
        `occupation` | string |  optional  | nullable
        `current_medication` | string |  optional  | nullable
        `country_code` | string |  optional  | nullable
        `contact_number` | string |  optional  | nullable
        `national_health_id` | string |  optional  | nullable
    
<!-- END_0a71301ee2e2509b77b4bba915bd7974 -->

<!-- START_35fdbdaf747a09563ec0a92db5027869 -->
## Patient list family member

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/patient/family?paginate=tempora" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/patient/family"
);

let params = {
    "paginate": "tempora",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "patient_family_id": "P0000001F01",
            "title": "Mr",
            "first_name": "ben",
            "middle_name": "M",
            "last_name": "ten",
            "gender": "MALE",
            "date_of_birth": "1998-06-19",
            "age": 27,
            "height": 160,
            "weight": 90,
            "marital_status": "SINGLE",
            "occupation": "no work",
            "relationship": "SON",
            "country_code": null,
            "contact_number": null,
            "current_medication": "fever"
        },
        {
            "id": 2,
            "patient_family_id": "P0000001F12",
            "title": "Mr",
            "first_name": "ben",
            "middle_name": "M",
            "last_name": "ten",
            "gender": "MALE",
            "date_of_birth": "1998-06-19",
            "age": 27,
            "height": 160,
            "weight": 90,
            "marital_status": "SINGLE",
            "occupation": "no work",
            "relationship": "SON",
            "country_code": null,
            "contact_number": null,
            "current_medication": "fever"
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/family?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/family?page=1",
    "next_page_url": null,
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/family",
    "per_page": 20,
    "prev_page_url": null,
    "to": 5,
    "total": 5
}
```
> Example response (404):

```json
{
    "message": "Family members not found."
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/patient/family`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `paginate` |  optional  | nullable integer nullable paginate = 0

<!-- END_35fdbdaf747a09563ec0a92db5027869 -->

<!-- START_c80a130775359406153a7fd737c2c955 -->
## Patient get family memeber by id

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/patient/family/1?id=enim" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/patient/family/1"
);

let params = {
    "id": "enim",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "id": 1,
    "patient_family_id": "P0000001F01",
    "title": "Mr",
    "first_name": "ben",
    "middle_name": "M",
    "last_name": "ten",
    "gender": "MALE",
    "date_of_birth": "1998-06-19",
    "age": 27,
    "height": 160,
    "weight": 90,
    "marital_status": "SINGLE",
    "occupation": "no work",
    "relationship": "SON",
    "country_code": null,
    "contact_number": null,
    "current_medication": "fever"
}
```
> Example response (404):

```json
{
    "message": "Family member not found."
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/patient/family/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of record

<!-- END_c80a130775359406153a7fd737c2c955 -->

<!-- START_89e5811bfbf232c97a45f71c55c2f65f -->
## Patient delete family member

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X DELETE \
    "http://localhost/fms-api-laravel/public/api/patient/family/1?id=nisi" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/patient/family/1"
);

let params = {
    "id": "nisi",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "Family member deleted successfully"
}
```
> Example response (404):

```json
{
    "message": "Family member not found"
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`DELETE api/patient/family/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of record

<!-- END_89e5811bfbf232c97a45f71c55c2f65f -->

<!-- START_77e78ede0c46c4082a89c2a282550f07 -->
## Patient list Appointments

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/patient/appointments?filter=ut&sortBy=aperiam&orderBy=expedita&name=beatae&start_date=dolor&end_date=id" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/patient/appointments"
);

let params = {
    "filter": "ut",
    "sortBy": "aperiam",
    "orderBy": "expedita",
    "name": "beatae",
    "start_date": "dolor",
    "end_date": "id",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 369,
            "doctor_id": 2,
            "patient_id": 3,
            "appointment_unique_id": "AP0000369",
            "date": "2021-02-15",
            "time": "09:29:00",
            "consultation_type": "INCLINIC",
            "shift": null,
            "payment_status": null,
            "transaction_id": null,
            "total": null,
            "is_cancelled": 0,
            "is_completed": 1,
            "followup_id": null,
            "booking_date": "2021-02-15",
            "current_patient_info": {
                "user": {
                    "first_name": "Ben",
                    "middle_name": null,
                    "last_name": "Patient",
                    "email": "patient@logidots.com",
                    "country_code": "+91",
                    "mobile_number": "9876543210",
                    "profile_photo_url": null
                },
                "case": 2,
                "info": {
                    "first_name": "father",
                    "middle_name": null,
                    "last_name": "father",
                    "email": "patient@logidots.com",
                    "country_code": "+91",
                    "mobile_number": 9786200983,
                    "height": 0,
                    "weight": 0,
                    "gender": "MALE",
                    "age": 29
                },
                "address": {
                    "id": 36,
                    "street_name": "Sreekariyam",
                    "city_village": "Trivandrum",
                    "district": "Alappuzha",
                    "state": "Kerala",
                    "country": "India",
                    "pincode": "688001",
                    "country_code": null,
                    "contact_number": null,
                    "latitude": null,
                    "longitude": null,
                    "clinic_name": null
                }
            },
            "doctor": {
                "id": 2,
                "first_name": "Theophilus",
                "middle_name": "Jos",
                "last_name": "Simeon",
                "profile_photo_url": null
            },
            "clinic_address": {
                "id": 5,
                "street_name": "Lane",
                "city_village": "london",
                "district": "Pathanamthitta",
                "state": "Kerala",
                "country": "India",
                "pincode": "689641",
                "country_code": null,
                "contact_number": null,
                "latitude": null,
                "longitude": null,
                "clinic_name": null
            },
            "prescription": {
                "id": 222,
                "appointment_id": 369,
                "unique_id": "PX0000222",
                "info": {
                    "age": 29,
                    "height": null,
                    "weight": null,
                    "address": "Sreekariyam, Trivandrum, Alappuzha, Kerala, India - 688001",
                    "symptoms": "xyz",
                    "body_temp": null,
                    "diagnosis": "xyz",
                    "pulse_rate": null,
                    "bp_systolic": null,
                    "test_search": null,
                    "bp_diastolic": null,
                    "case_summary": "This guy is an infection hub",
                    "medicine_search": null,
                    "note_to_patient": null,
                    "diet_instruction": null,
                    "despencing_details": null,
                    "investigation_followup": null
                },
                "created_at": "2021-02-15",
                "pdf_url": null,
                "status_medicine": "Yet to dispense.",
                "medicinelist": [
                    {
                        "id": 323,
                        "prescription_id": 222,
                        "medicine_id": 9,
                        "quote_generated": 1,
                        "dosage": "1 - 0 - 0 - 1",
                        "instructions": "xyz123",
                        "duration": "4 days",
                        "no_of_refill": "9",
                        "substitution_allowed": 0,
                        "medicine_status": "Dispensed at clinic.",
                        "medicine_name": "Calpol 650",
                        "medicine": {
                            "id": 9,
                            "category_id": 1,
                            "sku": "MED0000009",
                            "composition": "Paracetamol",
                            "weight": 650,
                            "weight_unit": "mg",
                            "name": "Calpol 650",
                            "manufacturer": "Raptakos Brett & Co",
                            "medicine_type": "Capsules",
                            "drug_type": "Branded",
                            "qty_per_strip": 10,
                            "price_per_strip": 50,
                            "rate_per_unit": 5,
                            "rx_required": 0,
                            "short_desc": "Symptoms of common cold and headache can also be controlled and treated through the use of this medicine",
                            "long_desc": null,
                            "cart_desc": "Treatment and control of fever",
                            "image_name": "lote.jpg",
                            "image_url": null
                        }
                    }
                ],
                "testlist": [
                    {
                        "id": 174,
                        "prescription_id": 222,
                        "lab_test_id": 4,
                        "quote_generated": 0,
                        "instructions": null,
                        "test_status": "To be dispensed.",
                        "test_name": "Comphrensive Metabolic panel",
                        "test": {
                            "id": 4,
                            "name": "Comphrensive Metabolic panel",
                            "unique_id": "LAT0000004",
                            "price": 300.5,
                            "currency_code": "INR",
                            "code": "CMP",
                            "image": null
                        }
                    }
                ]
            }
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/appointments?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/appointments?page=1",
    "next_page_url": null,
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/appointments",
    "per_page": 10,
    "prev_page_url": null,
    "to": 1,
    "total": 1
}
```
> Example response (404):

```json
{
    "message": "No records found."
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/patient/appointments`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `filter` |  optional  | nullable array filter[upcoming]=1 for future appointments filter[completed]= 1 for completed appointments
    `sortBy` |  optional  | nullable any one of (date,id)
    `orderBy` |  optional  | nullable any one of (asc,desc)
    `name` |  optional  | nullable string name of doctor
    `start_date` |  optional  | nullable date format-> Y-m-d
    `end_date` |  optional  | nullable date format-> Y-m-d

<!-- END_77e78ede0c46c4082a89c2a282550f07 -->

<!-- START_4924dc1038e01c3e1027486eceac53a8 -->
## Patient list Appointments by id

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/patient/appointments/1?id=ratione" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/patient/appointments/1"
);

let params = {
    "id": "ratione",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "id": 369,
    "doctor_id": 2,
    "patient_id": 3,
    "appointment_unique_id": "AP0000369",
    "date": "2021-02-15",
    "time": "09:29:00",
    "consultation_type": "INCLINIC",
    "shift": null,
    "payment_status": null,
    "transaction_id": null,
    "total": null,
    "is_cancelled": 0,
    "is_completed": 1,
    "followup_id": null,
    "booking_date": "2021-02-15",
    "current_patient_info": {
        "user": {
            "first_name": "Ben",
            "middle_name": null,
            "last_name": "Patient",
            "email": "patient@logidots.com",
            "country_code": "+91",
            "mobile_number": "9876543210",
            "profile_photo_url": null
        },
        "case": 2,
        "info": {
            "first_name": "father",
            "middle_name": null,
            "last_name": "father",
            "email": "patient@logidots.com",
            "country_code": "+91",
            "mobile_number": 9786200983,
            "height": 0,
            "weight": 0,
            "gender": "MALE",
            "age": 29
        },
        "address": {
            "id": 36,
            "street_name": "Sreekariyam",
            "city_village": "Trivandrum",
            "district": "Alappuzha",
            "state": "Kerala",
            "country": "India",
            "pincode": "688001",
            "country_code": null,
            "contact_number": null,
            "latitude": null,
            "longitude": null,
            "clinic_name": null
        }
    },
    "doctor": {
        "id": 2,
        "first_name": "Theophilus",
        "middle_name": "Jos",
        "last_name": "Simeon",
        "profile_photo_url": null
    },
    "clinic_address": {
        "id": 5,
        "street_name": "Lane",
        "city_village": "london",
        "district": "Pathanamthitta",
        "state": "Kerala",
        "country": "India",
        "pincode": "689641",
        "country_code": null,
        "contact_number": null,
        "latitude": null,
        "longitude": null,
        "clinic_name": null
    },
    "prescription": {
        "id": 222,
        "appointment_id": 369,
        "unique_id": "PX0000222",
        "info": {
            "age": 29,
            "height": null,
            "weight": null,
            "address": "Sreekariyam, Trivandrum, Alappuzha, Kerala, India - 688001",
            "symptoms": "xyz",
            "body_temp": null,
            "diagnosis": "xyz",
            "pulse_rate": null,
            "bp_systolic": null,
            "test_search": null,
            "bp_diastolic": null,
            "case_summary": "This guy is an infection hub",
            "medicine_search": null,
            "note_to_patient": null,
            "diet_instruction": null,
            "despencing_details": null,
            "investigation_followup": null
        },
        "created_at": "2021-02-15",
        "pdf_url": null,
        "status_medicine": "Yet to dispense.",
        "medicinelist": [
            {
                "id": 323,
                "prescription_id": 222,
                "medicine_id": 9,
                "quote_generated": 1,
                "dosage": "1 - 0 - 0 - 1",
                "instructions": "xyz123",
                "duration": "4 days",
                "no_of_refill": "9",
                "substitution_allowed": 0,
                "medicine_status": "Dispensed at clinic.",
                "medicine_name": "Calpol 650",
                "medicine": {
                    "id": 9,
                    "category_id": 1,
                    "sku": "MED0000009",
                    "composition": "Paracetamol",
                    "weight": 650,
                    "weight_unit": "mg",
                    "name": "Calpol 650",
                    "manufacturer": "Raptakos Brett & Co",
                    "medicine_type": "Capsules",
                    "drug_type": "Branded",
                    "qty_per_strip": 10,
                    "price_per_strip": 50,
                    "rate_per_unit": 5,
                    "rx_required": 0,
                    "short_desc": "Symptoms of common cold and headache can also be controlled and treated through the use of this medicine",
                    "long_desc": null,
                    "cart_desc": "Treatment and control of fever",
                    "image_name": "lote.jpg",
                    "image_url": null
                }
            }
        ],
        "testlist": [
            {
                "id": 174,
                "prescription_id": 222,
                "lab_test_id": 4,
                "quote_generated": 0,
                "instructions": null,
                "test_status": "To be dispensed.",
                "test_name": "Comphrensive Metabolic panel",
                "test": {
                    "id": 4,
                    "name": "Comphrensive Metabolic panel",
                    "unique_id": "LAT0000004",
                    "price": 300.5,
                    "currency_code": "INR",
                    "code": "CMP",
                    "image": null
                }
            }
        ]
    }
}
```
> Example response (404):

```json
{
    "message": "Appointment not found."
}
```

### HTTP Request
`GET api/patient/appointments/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of appointment_id

<!-- END_4924dc1038e01c3e1027486eceac53a8 -->

<!-- START_5ebfe56c8a27eeaf9ce515eaec154c81 -->
## Patient cancel appointment

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/patient/appointments/cancel/1?id=illo" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/patient/appointments/cancel/1"
);

let params = {
    "id": "illo",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "Appointment cancelled successfully."
}
```
> Example response (404):

```json
{
    "message": "Appointment not found."
}
```
> Example response (403):

```json
{
    "message": "Appointment can't be cancelled."
}
```

### HTTP Request
`GET api/patient/appointments/cancel/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of Appointment

<!-- END_5ebfe56c8a27eeaf9ce515eaec154c81 -->

<!-- START_8fe6e53fcaf55818cddd587a209d8464 -->
## Patient reschedule appointment

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/patient/appointments/reschedule" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"appointment_id":"molestiae","consultation_type":"cum","shift":"illo","date":"quia","doctor_time_slots_id":"quam"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/patient/appointments/reschedule"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "appointment_id": "molestiae",
    "consultation_type": "cum",
    "shift": "illo",
    "date": "quia",
    "doctor_time_slots_id": "quam"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "appointment_id": [
            "The appointment id field is required."
        ],
        "date": [
            "The date field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Appointment rescheduled successfully."
}
```
> Example response (404):

```json
{
    "message": "Appointment not found."
}
```
> Example response (403):

```json
{
    "message": "Appointment can't be rescheduled."
}
```
> Example response (403):

```json
{
    "message": "Previous appointment consultation type is not equal to current input."
}
```

### HTTP Request
`POST api/patient/appointments/reschedule`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `appointment_id` | required |  optional  | integer id of Appointment
        `consultation_type` | string |  required  | anyone of INCLINIC,ONLINE,EMERGENCY
        `shift` | string |  optional  | nullable anyone of MORNING,AFTERNOON,EVENING,NIGHT required_if consultation_type is EMERGENCY
        `date` | required |  optional  | date format Y-m-d
        `doctor_time_slots_id` | required |  optional  | id of timeslot
    
<!-- END_8fe6e53fcaf55818cddd587a209d8464 -->

<!-- START_6e6d0f61964045c8d6ae774e08765ead -->
## Patient List followups

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/patient/followups?name=dolores&start_date=nulla&end_date=tempora" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/patient/followups"
);

let params = {
    "name": "dolores",
    "start_date": "nulla",
    "end_date": "tempora",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "doctor_id": 2,
            "last_vist_date": "2020-12-23",
            "followup_date": "2020-12-31",
            "is_cancelled": 0,
            "is_completed": 0,
            "enable_followup": false,
            "doctor": {
                "id": 2,
                "first_name": "Theophilus",
                "middle_name": "Jos",
                "last_name": "Simeon",
                "profile_photo_url": null
            },
            "appointment": {
                "id": 1,
                "doctor_id": 2,
                "patient_id": 3,
                "appointment_unique_id": "AP0000001",
                "date": "2020-12-18",
                "time": "15:00:00",
                "consultation_type": "ONLINE",
                "shift": "MORNING",
                "payment_status": null,
                "transaction_id": null,
                "total": null,
                "is_cancelled": 0,
                "is_completed": 0,
                "patient_info": {
                    "id": "1",
                    "case": "1",
                    "email": "james@gmail.com",
                    "mobile": "876543210",
                    "last_name": "Bond",
                    "first_name": "James",
                    "middle_name": "007",
                    "mobile_code": "+91",
                    "patient_mobile": "987654321",
                    "patient_mobile_code": "+91"
                },
                "booking_date": "2020-12-24"
            },
            "clinic_address": {
                "id": 1,
                "street_name": "South Road",
                "city_village": "Edamattom",
                "district": "Kottayam",
                "state": "Kerala",
                "country": "India",
                "pincode": "686575",
                "country_code": null,
                "contact_number": null,
                "latitude": "10.53034500",
                "longitude": "76.21472900",
                "clinic_name": "dach"
            }
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/followups?page=1",
    "from": 1,
    "last_page": 2,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/followups?page=2",
    "next_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/followups?page=2",
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/followups",
    "per_page": 1,
    "prev_page_url": null,
    "to": 1,
    "total": 2
}
```
> Example response (404):

```json
{
    "message": "No records found."
}
```

### HTTP Request
`GET api/patient/followups`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `name` |  optional  | nullable string name of patient
    `start_date` |  optional  | nullable date format-> Y-m-d
    `end_date` |  optional  | nullable date format-> Y-m-d

<!-- END_6e6d0f61964045c8d6ae774e08765ead -->

<!-- START_5153feb5e6e8a8a3f6abac5d35598470 -->
## Patient cancel followup

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/patient/followups/cancel/1?id=placeat" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/patient/followups/cancel/1"
);

let params = {
    "id": "placeat",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (404):

```json
{
    "message": "Followup not found."
}
```
> Example response (200):

```json
{
    "message": "Followup cancelled successfully."
}
```

### HTTP Request
`POST api/patient/followups/cancel/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of record followup

<!-- END_5153feb5e6e8a8a3f6abac5d35598470 -->

<!-- START_885aa55a3bc8e616864c9cbbf8c5e61f -->
## Patient list prescription

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/patient/prescription" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/patient/prescription"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 9,
            "appointment_id": 12,
            "unique_id": "PX0000009",
            "created_at": "2021-01-11",
            "pdf_url": null,
            "status_medicine": "Dispensed.",
            "doctor": {
                "id": 2,
                "first_name": "Theophilus",
                "middle_name": "Jos",
                "last_name": "Simeon",
                "email": "theophilus@logidots.com",
                "username": "theo",
                "country_code": "+91",
                "mobile_number": "8940330536",
                "user_type": "DOCTOR",
                "is_active": "1",
                "role": null,
                "currency_code": null,
                "approved_date": "2021-01-04",
                "laravel_through_key": 12,
                "profile_photo_url": null
            },
            "appointment": {
                "id": 12,
                "appointment_unique_id": "AP0000012",
                "booking_date": "2021-01-21",
                "current_patient_info": []
            }
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/prescription?page=1",
    "from": 1,
    "last_page": 4,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/prescription?page=4",
    "next_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/prescription?page=2",
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/prescription",
    "per_page": 1,
    "prev_page_url": null,
    "to": 1,
    "total": 4
}
```
> Example response (404):

```json
{
    "message": "No records found."
}
```

### HTTP Request
`GET api/patient/prescription`


<!-- END_885aa55a3bc8e616864c9cbbf8c5e61f -->

<!-- START_2ec47b54e241e5d12f5af58f0dae0759 -->
## Patient list prescription medicine list

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/patient/prescription/medicine?id=magnam" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/patient/prescription/medicine"
);

let params = {
    "id": "magnam",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "prescription_id": 1,
            "quote_generated": 0,
            "medicine_id": 1,
            "dosage": "2",
            "instructions": "Have food",
            "duration": "2 days",
            "no_of_refill": "2",
            "substitution_allowed": 1,
            "medicine_status": "Dispensed at associated pharmacy.",
            "medicine_name": "Dolo"
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/prescription\/medicine?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/prescription\/medicine?page=1",
    "next_page_url": null,
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/prescription\/medicine",
    "per_page": 10,
    "prev_page_url": null,
    "to": 1,
    "total": 1
}
```
> Example response (404):

```json
{
    "message": "No records found."
}
```

### HTTP Request
`GET api/patient/prescription/medicine`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of record prescription

<!-- END_2ec47b54e241e5d12f5af58f0dae0759 -->

<!-- START_17fd219473cb1a8222b7e0bb0e3c73f6 -->
## Patient list prescription test list

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/patient/prescription/test?id=mollitia" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/patient/prescription/test"
);

let params = {
    "id": "mollitia",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "prescription_id": 1,
            "quote_generated": 0,
            "lab_test_id": 1,
            "instructions": "Need report on this test",
            "test_status": "Dispensed outside.",
            "test_name": "Test 2"
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/prescription\/test?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/prescription\/test?page=1",
    "next_page_url": null,
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/prescription\/test",
    "per_page": 10,
    "prev_page_url": null,
    "to": 1,
    "total": 1
}
```
> Example response (404):

```json
{
    "message": "No records found."
}
```

### HTTP Request
`GET api/patient/prescription/test`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of record prescription

<!-- END_17fd219473cb1a8222b7e0bb0e3c73f6 -->

<!-- START_05d2cbc97a57a2598c045812f68ef440 -->
## Patient Request Quote to pharmacy

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/patient/sendquote/pharmacy" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"prescription_id":7,"pharmacy_id":[2],"medicine_list":[3]}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/patient/sendquote/pharmacy"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "prescription_id": 7,
    "pharmacy_id": [
        2
    ],
    "medicine_list": [
        3
    ]
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "prescription_id": [
            "The prescription id field is required."
        ],
        "pharmacy_id": [
            "The pharmacy id field is required."
        ],
        "medicine_list.0": [
            "The medicine_list.0 field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Quote request sent successfully."
}
```

### HTTP Request
`POST api/patient/sendquote/pharmacy`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `prescription_id` | integer |  required  | 
        `pharmacy_id` | array |  required  | 
        `pharmacy_id.*` | integer |  required  | pharmacy id
        `medicine_list` | array |  required  | 
        `medicine_list.*` | integer |  required  | medicine id
    
<!-- END_05d2cbc97a57a2598c045812f68ef440 -->

<!-- START_80413bd45fde0ebe14574e91c52cabfb -->
## Patient Request Quote to laboratory

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/patient/sendquote/laboratory" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"prescription_id":5,"laboratory_id":[15],"test_list":[15]}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/patient/sendquote/laboratory"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "prescription_id": 5,
    "laboratory_id": [
        15
    ],
    "test_list": [
        15
    ]
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "prescription_id": [
            "The prescription id field is required."
        ],
        "test_list": [
            "The test list field is required."
        ],
        "laboratory_id": [
            "The laboratory id field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Quote request sent successfully."
}
```

### HTTP Request
`POST api/patient/sendquote/laboratory`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `prescription_id` | integer |  required  | 
        `laboratory_id` | array |  required  | 
        `laboratory_id.*` | integer |  required  | laboratory id
        `test_list` | array |  required  | 
        `test_list.*` | integer |  required  | test id
    
<!-- END_80413bd45fde0ebe14574e91c52cabfb -->

<!-- START_8809818d73774eea59ff7347a5eec07f -->
## Patient get Quotes

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/patient/quote?type=rem" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/patient/quote"
);

let params = {
    "type": "rem",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "type": [
            "The type field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 41,
            "status": "0",
            "created_at": "2021-02-23 08:30:39 pm",
            "unique_id": "QOOOOOO1",
            "quote_from": {
                "id": 1,
                "name": "Pharmacy Name",
                "address": [
                    {
                        "id": 4,
                        "street_name": "East Road",
                        "city_village": "Edamon",
                        "district": "Kollam",
                        "state": "Kerala",
                        "country": "India",
                        "pincode": "691307",
                        "country_code": null,
                        "contact_number": null,
                        "land_mark": null,
                        "latitude": "10.53034500",
                        "longitude": "76.21472900",
                        "clinic_name": null
                    }
                ]
            },
            "quote_request": {
                "id": 1,
                "created_at": "2021-01-12 12:54:30 am",
                "type": "MED",
                "quote_type": null
            },
            "grant_total": 161.67
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/quote?page=1",
    "from": 1,
    "last_page": 6,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/quote?page=6",
    "next_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/quote?page=2",
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/quote",
    "per_page": 1,
    "prev_page_url": null,
    "to": 1,
    "total": 6
}
```
> Example response (404):

```json
{
    "message": "Quotes not found."
}
```

### HTTP Request
`GET api/patient/quote`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `type` |  required  | string send MED for phamarcy quote list, LAB for laboratory quote list

<!-- END_8809818d73774eea59ff7347a5eec07f -->

<!-- START_844ebe40df23adf0b7f52fb518655e85 -->
## Patient get quote by id

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/patient/quote/1?id=architecto" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/patient/quote/1"
);

let params = {
    "id": "architecto",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "id": 75,
    "created_at": "2021-03-02 09:12:58 pm",
    "unique_id": "QT0000076",
    "medicine": {
        "total": 200,
        "discount": "80",
        "delivery_charge": "40",
        "medicine_list": [
            {
                "unit": "3",
                "price": 60,
                "dosage": "1 - 0 - 0 - 0",
                "duration": "2 days",
                "medicine_id": 8,
                "instructions": "James Bond New outside",
                "no_of_refill": "0",
                "medicine": {
                    "id": 8,
                    "category_id": 3,
                    "sku": "MED0000008",
                    "composition": "Syrup",
                    "weight": 250,
                    "weight_unit": "mcg",
                    "name": "Febrex 125",
                    "manufacturer": "Pentamark Organics",
                    "medicine_type": "Capsules",
                    "drug_type": "Branded",
                    "qty_per_strip": 6,
                    "price_per_strip": 60,
                    "rate_per_unit": 10,
                    "rx_required": 1,
                    "short_desc": "Febrex 125 is used to temporarily relieve fever and mild to moderate pain such as muscle ache, headache, toothache, and backache.",
                    "long_desc": null,
                    "cart_desc": "Febrex 125",
                    "image_name": "febrex.jpg",
                    "image_url": null
                }
            },
            {
                "unit": "2",
                "price": 30,
                "dosage": "1 - 0 - 0 - 0",
                "duration": "2 days",
                "medicine_id": 7,
                "instructions": "James Bond New outside",
                "no_of_refill": "0",
                "medicine": {
                    "id": 7,
                    "category_id": 1,
                    "sku": "MED0000007",
                    "composition": "Paracetamol",
                    "weight": 5,
                    "weight_unit": "g",
                    "name": "Pyremol 650",
                    "manufacturer": "Alembic Ltd",
                    "medicine_type": "Capsules",
                    "drug_type": "Branded",
                    "qty_per_strip": 10,
                    "price_per_strip": 30,
                    "rate_per_unit": 3,
                    "rx_required": 0,
                    "short_desc": "This medicine should be used with caution in patients with liver diseases due to the increased risk of severe adverse effects.",
                    "long_desc": null,
                    "cart_desc": "The pain relieving effect of this medicine can be observed within an hour of administration. For fever reduction, the time taken to show the effect is about 30 minutes.",
                    "image_name": "pyremol.jpg",
                    "image_url": null
                }
            }
        ]
    },
    "test": [],
    "quote_from": {
        "id": 1,
        "name": "Pharmacy Name",
        "address": [
            {
                "id": 4,
                "street_name": "50\/23",
                "city_village": "Tirunelveli",
                "district": "Tirunelveli",
                "state": "Tamil Nadu",
                "country": "India",
                "pincode": "627354",
                "country_code": null,
                "contact_number": null,
                "land_mark": null,
                "latitude": "8.55160940",
                "longitude": "77.76987023",
                "clinic_name": null
            }
        ]
    },
    "order": {
        "id": 1,
        "user_id": 3,
        "tax": 10,
        "subtotal": 20,
        "discount": 2,
        "delivery_charge": 2,
        "total": 500.49,
        "shipping_address_id": 1,
        "payment_status": "Not Paid",
        "delivery_status": "Open",
        "delivery_info": null
    },
    "quote_request": {
        "id": 125,
        "created_at": "2021-02-12 12:01:26 am",
        "quote_type": null,
        "type": "MED"
    },
    "grant_total": 161.67,
    "tax_percent": 0,
    "commission": 0
}
```
> Example response (404):

```json
{
    "message": "Quote not found."
}
```

### HTTP Request
`GET api/patient/quote/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of quote

<!-- END_844ebe40df23adf0b7f52fb518655e85 -->

<!-- START_c9b5957d5870ff01b52db37e19369230 -->
## Patient delete quote by id

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X DELETE \
    "http://localhost/fms-api-laravel/public/api/patient/quote/1?id=illo" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/patient/quote/1"
);

let params = {
    "id": "illo",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "Quote deleted successfully."
}
```
> Example response (404):

```json
{
    "message": "Quote not found."
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`DELETE api/patient/quote/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of quote

<!-- END_c9b5957d5870ff01b52db37e19369230 -->

<!-- START_b820ab723ab5015f9ab21c080915bbb3 -->
## Patient Get orders

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/patient/orders?type=ex" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/patient/orders"
);

let params = {
    "type": "ex",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 74,
            "unique_id": "ORD0000074",
            "user_id": 3,
            "tax": 3.57,
            "subtotal": 396.5,
            "discount": 10,
            "delivery_charge": 50,
            "total": 440.07,
            "shipping_address_id": 75,
            "payment_status": "Paid",
            "delivery_status": "Pending",
            "delivery_info": null,
            "created_at": "2021-03-24 02:17:11 pm",
            "order_items": [
                {
                    "id": 77,
                    "item_id": 6,
                    "price": 65.5,
                    "quantity": 3,
                    "item_details": {
                        "id": 6,
                        "category_id": 1,
                        "sku": "MED0000006",
                        "composition": "Xylometazoline Hydrochloride Nasal Solution IP",
                        "weight": 50,
                        "weight_unit": "g",
                        "name": "Lidocaine ointment",
                        "manufacturer": "Novartis",
                        "medicine_type": "Topical medicines",
                        "drug_type": "Generic",
                        "qty_per_strip": 2,
                        "price_per_strip": 65.5,
                        "rate_per_unit": 10,
                        "rx_required": 0,
                        "short_desc": null,
                        "long_desc": null,
                        "cart_desc": null,
                        "image_name": "img_15.jpg",
                        "image_url": null
                    }
                },
                {
                    "id": 78,
                    "item_id": 7,
                    "price": 100,
                    "quantity": 2,
                    "item_details": {
                        "id": 7,
                        "category_id": 1,
                        "sku": "MED0000007",
                        "composition": "GlaxoSmithKline",
                        "weight": 100,
                        "weight_unit": "g",
                        "name": "Voltaren gel",
                        "manufacturer": "GlaxoSmithKline Consumer Health",
                        "medicine_type": "Topical medicines",
                        "drug_type": "Generic",
                        "qty_per_strip": 1,
                        "price_per_strip": 100,
                        "rate_per_unit": 10,
                        "rx_required": 0,
                        "short_desc": null,
                        "long_desc": null,
                        "cart_desc": null,
                        "image_name": "img_10.jpg",
                        "image_url": null
                    }
                }
            ],
            "payments": {
                "id": 314,
                "unique_id": "PAY0000314",
                "total_amount": 440.07,
                "payment_status": "Paid",
                "created_at": "2021-03-24 02:17:11 pm"
            }
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/orders?page=1",
    "from": 1,
    "last_page": 15,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/orders?page=15",
    "next_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/orders?page=2",
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/orders",
    "per_page": 1,
    "prev_page_url": null,
    "to": 1,
    "total": 15
}
```
> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 58,
            "unique_id": "ORD0000058",
            "user_id": 3,
            "tax": 9.8,
            "subtotal": 200.5,
            "discount": 20.5,
            "delivery_charge": 100,
            "total": 289.8,
            "shipping_address_id": 75,
            "payment_status": "Paid",
            "delivery_status": "Pending",
            "delivery_info": null,
            "created_at": "2021-03-19 10:25:34 pm",
            "order_items": [
                {
                    "id": 60,
                    "item_id": 2,
                    "price": 200.5,
                    "quantity": 1,
                    "item_details": {
                        "id": 2,
                        "name": "Basic Metabolic Panel",
                        "unique_id": "LAT0000002",
                        "price": 200.5,
                        "currency_code": "INR",
                        "code": "BMP",
                        "image": null
                    }
                }
            ],
            "payments": {
                "id": 245,
                "unique_id": "PAY0000245",
                "total_amount": 289.8,
                "payment_status": "Paid",
                "created_at": "2021-03-19 10:25:34 pm"
            }
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/orders?page=1",
    "from": 1,
    "last_page": 3,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/orders?page=3",
    "next_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/orders?page=2",
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/orders",
    "per_page": 1,
    "prev_page_url": null,
    "to": 1,
    "total": 3
}
```
> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 392,
            "appointment_unique_id": "AP0000392",
            "date": "2021-03-25",
            "time": "10:29:00",
            "consultation_type": "INCLINIC",
            "shift": null,
            "payment_status": "Paid",
            "total": 449.78,
            "tax": 11.78,
            "commission": 43.8,
            "is_cancelled": 0,
            "is_completed": 0,
            "followup_id": null,
            "booking_date": "2021-03-25",
            "payments": {
                "id": 320,
                "unique_id": "PAY0000320",
                "total_amount": 449.78,
                "payment_status": "Paid",
                "created_at": "2021-03-25 03:58:47 pm"
            }
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/orders?page=1",
    "from": 1,
    "last_page": 33,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/orders?page=33",
    "next_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/orders?page=2",
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/orders",
    "per_page": 1,
    "prev_page_url": null,
    "to": 1,
    "total": 33
}
```

### HTTP Request
`GET api/patient/orders`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `type` |  required  | string MED for orders from pharmacy , LAB for orders from laboratory. APPOINTMENT for appointment list orders

<!-- END_b820ab723ab5015f9ab21c080915bbb3 -->

<!-- START_4c37afb98690552c49ff74bbcdd3a076 -->
## Patient Get order by Id

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/patient/orders/1?id=suscipit&type=aliquam" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/patient/orders/1"
);

let params = {
    "id": "suscipit",
    "type": "aliquam",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "id": 392,
    "appointment_unique_id": "AP0000392",
    "date": "2021-03-25",
    "time": "10:29:00",
    "consultation_type": "INCLINIC",
    "shift": null,
    "payment_status": "Paid",
    "total": 449.78,
    "commission": 43.8,
    "tax": 11.78,
    "is_cancelled": 0,
    "is_completed": 0,
    "followup_id": null,
    "booking_date": "2021-03-25",
    "payments": {
        "id": 320,
        "unique_id": "PAY0000320",
        "total_amount": 449.78,
        "payment_status": "Paid",
        "created_at": "2021-03-25 03:58:47 pm"
    }
}
```
> Example response (200):

```json
{
    "id": 58,
    "unique_id": "ORD0000058",
    "user_id": 3,
    "tax": 9.8,
    "subtotal": 200.5,
    "discount": 20.5,
    "delivery_charge": 100,
    "total": 289.8,
    "shipping_address_id": 75,
    "payment_status": "Paid",
    "delivery_status": "Pending",
    "delivery_info": null,
    "created_at": "2021-03-19 10:25:34 pm",
    "order_items": [
        {
            "id": 60,
            "item_id": 2,
            "price": 200.5,
            "quantity": 1,
            "item_details": {
                "id": 2,
                "name": "Basic Metabolic Panel",
                "unique_id": "LAT0000002",
                "price": 200.5,
                "currency_code": "INR",
                "code": "BMP",
                "image": null
            }
        }
    ],
    "payments": {
        "id": 245,
        "unique_id": "PAY0000245",
        "total_amount": 289.8,
        "payment_status": "Paid",
        "created_at": "2021-03-19 10:25:34 pm"
    }
}
```
> Example response (200):

```json
{
    "id": 74,
    "unique_id": "ORD0000074",
    "user_id": 3,
    "tax": 3.57,
    "subtotal": 396.5,
    "discount": 10,
    "delivery_charge": 50,
    "total": 440.07,
    "shipping_address_id": 75,
    "payment_status": "Paid",
    "delivery_status": "Pending",
    "delivery_info": null,
    "created_at": "2021-03-24 02:17:11 pm",
    "order_items": [
        {
            "id": 77,
            "item_id": 6,
            "price": 65.5,
            "quantity": 3,
            "item_details": {
                "id": 6,
                "category_id": 1,
                "sku": "MED0000006",
                "composition": "Xylometazoline Hydrochloride Nasal Solution IP",
                "weight": 50,
                "weight_unit": "g",
                "name": "Lidocaine ointment",
                "manufacturer": "Novartis",
                "medicine_type": "Topical medicines",
                "drug_type": "Generic",
                "qty_per_strip": 2,
                "price_per_strip": 65.5,
                "rate_per_unit": 10,
                "rx_required": 0,
                "short_desc": null,
                "long_desc": null,
                "cart_desc": null,
                "image_name": "img_15.jpg",
                "image_url": null
            }
        },
        {
            "id": 78,
            "item_id": 7,
            "price": 100,
            "quantity": 2,
            "item_details": {
                "id": 7,
                "category_id": 1,
                "sku": "MED0000007",
                "composition": "GlaxoSmithKline",
                "weight": 100,
                "weight_unit": "g",
                "name": "Voltaren gel",
                "manufacturer": "GlaxoSmithKline Consumer Health",
                "medicine_type": "Topical medicines",
                "drug_type": "Generic",
                "qty_per_strip": 1,
                "price_per_strip": 100,
                "rate_per_unit": 10,
                "rx_required": 0,
                "short_desc": null,
                "long_desc": null,
                "cart_desc": null,
                "image_name": "img_10.jpg",
                "image_url": null
            }
        }
    ],
    "payments": {
        "id": 314,
        "unique_id": "PAY0000314",
        "total_amount": 440.07,
        "payment_status": "Paid",
        "created_at": "2021-03-24 02:17:11 pm"
    }
}
```

### HTTP Request
`GET api/patient/orders/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of order or appointment id
    `type` |  required  | string MED for orders from pharmacy , LAB for orders from laboratory. APPOINTMENT for appointment list orders

<!-- END_4c37afb98690552c49ff74bbcdd3a076 -->

#Pharmacy


<!-- START_d66d96dae139e0225bdb13ecd9dd8dbe -->
## Pharmacy get profile details

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/pharmacy/profile" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/pharmacy/profile"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "id": 1,
    "pharmacy_unique_id": "PHA0000001",
    "gstin": "GSTN49598E4",
    "dl_number": "LAB12345",
    "dl_issuing_authority": "AIMS",
    "dl_date_of_issue": "2020-10-15",
    "dl_valid_upto": "2030-10-15",
    "pharmacy_name": "Pharmacy Name",
    "pharmacist_name": "Dereck Konopelski",
    "course": "Bsc",
    "pharmacist_reg_number": "PHAR1234",
    "issuing_authority": "GOVT",
    "alt_mobile_number": null,
    "alt_country_code": null,
    "reg_date": "2020-10-15",
    "reg_valid_upto": "2030-10-15",
    "home_delivery": 0,
    "order_amount": "300.00",
    "payout_period": 0,
    "dl_file": "http:\/\/localhost\/fms-api-laravel\/public\/storage",
    "reg_certificate": "http:\/\/localhost\/fms-api-laravel\/public\/storage",
    "user": {
        "id": 31,
        "first_name": "Dedric Ortiz",
        "middle_name": "Grayce Schiller",
        "last_name": "Dereck Konopelski",
        "email": "pharmacy@logidots.com",
        "username": "pharmacy",
        "country_code": "+91",
        "mobile_number": "602-904-9875",
        "user_type": "PHARMACIST",
        "is_active": "0",
        "currency_code": "INR",
        "profile_photo_url": null
    },
    "address": [
        {
            "id": 74,
            "street_name": "East Road",
            "city_village": "Edamon",
            "district": "Kollam",
            "state": "Kerala",
            "country": "India",
            "pincode": "691307",
            "country_code": null,
            "contact_number": null,
            "latitude": "10.53034500",
            "longitude": "76.21472900",
            "clinic_name": null
        }
    ],
    "bank_account_details": [
        {
            "id": 26,
            "bank_account_number": "BANK12345",
            "bank_account_holder": "BANKER",
            "bank_name": "BANK",
            "bank_city": "India",
            "bank_ifsc": "IFSC45098",
            "bank_account_type": "SAVINGS"
        }
    ]
}
```
> Example response (404):

```json
{
    "message": "profile details not found."
}
```

### HTTP Request
`GET api/pharmacy/profile`


<!-- END_d66d96dae139e0225bdb13ecd9dd8dbe -->

<!-- START_267a0a433aa23eb504cfa2b0ec3d9d14 -->
## Pharmacy edit profile details

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/pharmacy/profile" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"pharmacy_name":"est","country_code":"quo","mobile_number":"ut","email":"non","gstin":"ut","dl_number":"reprehenderit","dl_issuing_authority":"dolor","dl_date_of_issue":"et","dl_valid_upto":"aperiam","dl_file":"dicta","payout_period":false,"pincode":10,"street_name":"voluptas","city_village":"quia","district":"et","state":"ad","country":"et","home_delivery":false,"order_amount":"quibusdam","currency_code":"quasi","latitude":403.181,"longitude":544.8821,"pharmacist_name":"doloremque","course":"est","pharmacist_reg_number":"vero","issuing_authority":"non","alt_mobile_number":"quis","alt_country_code":"enim","reg_certificate":"perferendis","reg_date":"voluptas","reg_valid_upto":"qui","bank_account_number":"ut","bank_account_holder":"ea","bank_name":"consequatur","bank_city":"numquam","bank_ifsc":"rerum","bank_account_type":"inventore"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/pharmacy/profile"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "pharmacy_name": "est",
    "country_code": "quo",
    "mobile_number": "ut",
    "email": "non",
    "gstin": "ut",
    "dl_number": "reprehenderit",
    "dl_issuing_authority": "dolor",
    "dl_date_of_issue": "et",
    "dl_valid_upto": "aperiam",
    "dl_file": "dicta",
    "payout_period": false,
    "pincode": 10,
    "street_name": "voluptas",
    "city_village": "quia",
    "district": "et",
    "state": "ad",
    "country": "et",
    "home_delivery": false,
    "order_amount": "quibusdam",
    "currency_code": "quasi",
    "latitude": 403.181,
    "longitude": 544.8821,
    "pharmacist_name": "doloremque",
    "course": "est",
    "pharmacist_reg_number": "vero",
    "issuing_authority": "non",
    "alt_mobile_number": "quis",
    "alt_country_code": "enim",
    "reg_certificate": "perferendis",
    "reg_date": "voluptas",
    "reg_valid_upto": "qui",
    "bank_account_number": "ut",
    "bank_account_holder": "ea",
    "bank_name": "consequatur",
    "bank_city": "numquam",
    "bank_ifsc": "rerum",
    "bank_account_type": "inventore"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "pharmacy_name": [
            "The pharmacy name field is required."
        ],
        "country_code": [
            "The country code field is required."
        ],
        "mobile_number": [
            "The mobile number field is required."
        ],
        "email": [
            "The email field is required."
        ],
        "gstin": [
            "GSTIN (Goods and Services Tax Identification Number) is required."
        ],
        "dl_number": [
            "Drug licence number is required."
        ],
        "dl_issuing_authority": [
            "Drug licence Issuing Authority is required."
        ],
        "dl_date_of_issue": [
            "Drug licence date of issue is required."
        ],
        "dl_valid_upto": [
            "Drug licence valid upto is required."
        ],
        "pincode": [
            "The pincode field is required."
        ],
        "street_name": [
            "The street name field is required."
        ],
        "city_village": [
            "The city village field is required."
        ],
        "district": [
            "The district field is required."
        ],
        "state": [
            "The state field is required."
        ],
        "country": [
            "The country field is required."
        ],
        "home_delivery": [
            "The home delivery field is required."
        ],
        "latitude": [
            "The latitude field is required."
        ],
        "longitude": [
            "The longitude field is required."
        ],
        "pharmacist_name": [
            "The pharmacist name field is required."
        ],
        "course": [
            "The course field is required."
        ],
        "pharmacist_reg_number": [
            "Pharmacist Registration Number is required."
        ],
        "issuing_authority": [
            "The issuing authority field is required."
        ],
        "reg_date": [
            "Registration date field is required."
        ],
        "reg_valid_upto": [
            "Registration valid up to is required."
        ],
        "bank_account_number": [
            "The bank account number field is required."
        ],
        "bank_account_holder": [
            "The bank account holder field is required."
        ],
        "bank_name": [
            "The bank name field is required."
        ],
        "bank_city": [
            "The bank city field is required."
        ],
        "bank_ifsc": [
            "The bank ifsc field is required."
        ],
        "bank_account_type": [
            "The bank account type field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Details saved successfully."
}
```
> Example response (422):

```json
{
    "message": "Something went wrong."
}
```

### HTTP Request
`POST api/pharmacy/profile`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `pharmacy_name` | string |  required  | 
        `country_code` | string |  required  | 
        `mobile_number` | string |  required  | 
        `email` | string |  required  | 
        `gstin` | string |  required  | 
        `dl_number` | string |  required  | 
        `dl_issuing_authority` | string |  required  | 
        `dl_date_of_issue` | date |  required  | format:Y-m-d
        `dl_valid_upto` | date |  required  | format:Y-m-d
        `dl_file` | image |  optional  | file nullable mime:jpg,jpeg,png size max 2mb
        `payout_period` | boolean |  required  | 0 or 1
        `pincode` | integer |  required  | length 6
        `street_name` | string |  required  | Street Name/ House No./ Area
        `city_village` | string |  required  | City/Village
        `district` | string |  required  | 
        `state` | string |  required  | 
        `country` | string |  required  | 
        `home_delivery` | boolean |  required  | 0 or 1
        `order_amount` | decimal |  optional  | nullable required if home_delivery is filled
        `currency_code` | stirng |  required  | 
        `latitude` | float |  required  | 
        `longitude` | float |  required  | 
        `pharmacist_name` | string |  required  | 
        `course` | string |  required  | 
        `pharmacist_reg_number` | string |  required  | 
        `issuing_authority` | string |  required  | 
        `alt_mobile_number` | string |  optional  | nullable
        `alt_country_code` | string |  required  | when alt_mobile_number is present
        `reg_certificate` | file |  optional  | nullable mime:jpg,jpeg,png size max 2mb
        `reg_date` | string |  required  | 
        `reg_valid_upto` | string |  required  | 
        `bank_account_number` | string |  required  | 
        `bank_account_holder` | string |  required  | 
        `bank_name` | string |  required  | 
        `bank_city` | string |  required  | 
        `bank_ifsc` | string |  required  | 
        `bank_account_type` | string |  required  | 
    
<!-- END_267a0a433aa23eb504cfa2b0ec3d9d14 -->

<!-- START_85a7452cced8cfdddc8d538d5066f519 -->
## Pharmacy get Quotes Request

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/pharmacy/quote/request?filter[search]=est&filter[doctor]=assumenda&filter[status]=deserunt&dispense_request=13" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/pharmacy/quote/request"
);

let params = {
    "filter[search]": "est",
    "filter[doctor]": "assumenda",
    "filter[status]": "deserunt",
    "dispense_request": "13",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 59,
            "unique_id": "QR0000059",
            "prescription_id": 89,
            "quote_reply": null,
            "status": "0",
            "submission_date": null,
            "file_path": null,
            "created_at": "2021-02-10 09:55:20 pm",
            "medicine_list": [
                {
                    "id": 8,
                    "prescription_id": 13,
                    "medicine_id": 1,
                    "quote_generated": 1,
                    "dosage": "1 - 0 - 0 - 1",
                    "instructions": null,
                    "duration": "3 days",
                    "no_of_refill": "0",
                    "substitution_allowed": 1,
                    "medicine_status": "Dispensed outside.",
                    "medicine_name": "Ammu",
                    "medicine": {
                        "id": 1,
                        "category_id": 1,
                        "sku": "MED0000001",
                        "composition": "Paracetamol",
                        "weight": 50,
                        "weight_unit": "kg",
                        "name": "Ammu",
                        "manufacturer": "Ammu Corporation",
                        "medicine_type": "Drops",
                        "drug_type": "Branded",
                        "qty_per_strip": 10,
                        "price_per_strip": 45,
                        "rate_per_unit": 4.5,
                        "rx_required": 0,
                        "short_desc": "This is a good product",
                        "long_desc": "This is a good product",
                        "cart_desc": "This is a good product",
                        "image_name": null,
                        "image_url": null
                    }
                },
                {
                    "id": 9,
                    "prescription_id": 13,
                    "medicine_id": 4,
                    "quote_generated": 1,
                    "dosage": "1 - 0 - 0 - 1",
                    "instructions": null,
                    "duration": "3 days",
                    "no_of_refill": "3",
                    "substitution_allowed": 0,
                    "medicine_status": "Dispensed at associated pharmacy.",
                    "medicine_name": "Paraceta Test",
                    "medicine": {
                        "id": 4,
                        "category_id": 2,
                        "sku": "MED0000004",
                        "composition": "test data compo",
                        "weight": 170.56,
                        "weight_unit": "mg",
                        "name": "Paraceta Test",
                        "manufacturer": "Pfizer",
                        "medicine_type": "Suppositories",
                        "drug_type": "Branded",
                        "qty_per_strip": 5,
                        "price_per_strip": 100.3,
                        "rate_per_unit": 6,
                        "rx_required": 1,
                        "short_desc": null,
                        "long_desc": "null",
                        "cart_desc": null,
                        "image_name": null,
                        "image_url": null
                    }
                }
            ],
            "prescription": {
                "id": 89,
                "appointment_id": 248,
                "unique_id": "PX0000087",
                "created_at": "2021-02-10",
                "pdf_url": "http:\/\/localhost\/fms-api-laravel\/public\/storage\/uploads\/prescription\/89-1612974321.pdf",
                "status_medicine": "Yet to dispense.",
                "patient": {
                    "id": 22,
                    "first_name": "Vishnu",
                    "middle_name": "S",
                    "last_name": "Sharma",
                    "email": "vishnusharmatest123@yopmail.com",
                    "country_code": "+91",
                    "mobile_number": "3736556464",
                    "profile_photo_url": null
                },
                "appointment": {
                    "id": 248,
                    "doctor_id": 2,
                    "patient_id": 47,
                    "appointment_unique_id": "AP0000248",
                    "date": "2021-02-11",
                    "time": "12:05:00",
                    "consultation_type": "ONLINE",
                    "shift": null,
                    "payment_status": null,
                    "transaction_id": null,
                    "total": null,
                    "is_cancelled": 0,
                    "is_completed": 1,
                    "followup_id": null,
                    "booking_date": "2021-02-10",
                    "current_patient_info": {
                        "user": {
                            "first_name": "Diana",
                            "middle_name": "Princess",
                            "last_name": "Wales",
                            "email": "diana@gmail.com",
                            "country_code": "+91",
                            "mobile_number": "7878787878",
                            "profile_photo_url": null
                        },
                        "case": 1,
                        "info": {
                            "first_name": "Diana",
                            "middle_name": "Princess",
                            "last_name": "Wales",
                            "email": "diana@gmail.com",
                            "country_code": "+91",
                            "mobile_number": "7878787878",
                            "height": 156,
                            "weight": 55,
                            "gender": "FEMALE",
                            "age": 23
                        },
                        "address": {
                            "id": 132,
                            "street_name": "Vadakkaparampill",
                            "city_village": "PATHANAMTHITTA",
                            "district": "Pathanamthitta",
                            "state": "Kerala",
                            "country": "India",
                            "pincode": "689667",
                            "country_code": null,
                            "contact_number": "+917591985087",
                            "latitude": null,
                            "longitude": null,
                            "clinic_name": null
                        }
                    },
                    "doctor": {
                        "id": 2,
                        "first_name": "Theophilus",
                        "middle_name": "Jos",
                        "last_name": "Simeon",
                        "email": "theophilus@logidots.com",
                        "username": "theo",
                        "country_code": "+91",
                        "mobile_number": "8940330536",
                        "user_type": "DOCTOR",
                        "is_active": "1",
                        "role": null,
                        "currency_code": "INR",
                        "approved_date": "2021-01-04",
                        "profile_photo_url": null
                    },
                    "clinic_address": {
                        "id": 1,
                        "street_name": "South Road",
                        "city_village": "Edamatto",
                        "district": "Kottayam",
                        "state": "Kerala",
                        "country": "India",
                        "pincode": "686575",
                        "country_code": null,
                        "contact_number": "9786200983",
                        "latitude": "10.53034500",
                        "longitude": "76.21472900",
                        "clinic_name": "Neo clinic"
                    }
                }
            }
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/pharmacy\/quote\/request?page=1",
    "from": 1,
    "last_page": 11,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/pharmacy\/quote\/request?page=11",
    "next_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/pharmacy\/quote\/request?page=2",
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/pharmacy\/quote\/request",
    "per_page": 1,
    "prev_page_url": null,
    "to": 1,
    "total": 11
}
```
> Example response (404):

```json
{
    "message": "Quotes request not found."
}
```

### HTTP Request
`GET api/pharmacy/quote/request`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `filter` |  optional  | nullable array
    `filter.search` |  optional  | nullable string present
    `filter.doctor` |  optional  | nullable string present
    `filter.status` |  optional  | nullable boolean present 0 or 1
    `dispense_request` |  optional  | nullable number send 1

<!-- END_85a7452cced8cfdddc8d538d5066f519 -->

<!-- START_1219567473e0a824beba6d99f764e5a5 -->
## Pharmacy get Quotes Request by Id

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/pharmacy/quote/request/1?quote_request_id=quia" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/pharmacy/quote/request/1"
);

let params = {
    "quote_request_id": "quia",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "id": 59,
    "unique_id": "QR0000059",
    "prescription_id": 89,
    "quote_reply": null,
    "status": "0",
    "submission_date": null,
    "file_path": null,
    "created_at": "2021-02-10 09:55:20 pm",
    "medicine_list": [
        {
            "id": 8,
            "prescription_id": 13,
            "medicine_id": 1,
            "quote_generated": 1,
            "dosage": "1 - 0 - 0 - 1",
            "instructions": null,
            "duration": "3 days",
            "no_of_refill": "0",
            "substitution_allowed": 1,
            "medicine_status": "Dispensed outside.",
            "medicine_name": "Ammu",
            "medicine": {
                "id": 1,
                "category_id": 1,
                "sku": "MED0000001",
                "composition": "Paracetamol",
                "weight": 50,
                "weight_unit": "kg",
                "name": "Ammu",
                "manufacturer": "Ammu Corporation",
                "medicine_type": "Drops",
                "drug_type": "Branded",
                "qty_per_strip": 10,
                "price_per_strip": 45,
                "rate_per_unit": 4.5,
                "rx_required": 0,
                "short_desc": "This is a good product",
                "long_desc": "This is a good product",
                "cart_desc": "This is a good product",
                "image_name": null,
                "image_url": null
            }
        },
        {
            "id": 9,
            "prescription_id": 13,
            "medicine_id": 4,
            "quote_generated": 1,
            "dosage": "1 - 0 - 0 - 1",
            "instructions": null,
            "duration": "3 days",
            "no_of_refill": "3",
            "substitution_allowed": 0,
            "medicine_status": "Dispensed at associated pharmacy.",
            "medicine_name": "Paraceta Test",
            "medicine": {
                "id": 4,
                "category_id": 2,
                "sku": "MED0000004",
                "composition": "test data compo",
                "weight": 170.56,
                "weight_unit": "mg",
                "name": "Paraceta Test",
                "manufacturer": "Pfizer",
                "medicine_type": "Suppositories",
                "drug_type": "Branded",
                "qty_per_strip": 5,
                "price_per_strip": 100.3,
                "rate_per_unit": 6,
                "rx_required": 1,
                "short_desc": null,
                "long_desc": "null",
                "cart_desc": null,
                "image_name": null,
                "image_url": null
            }
        }
    ],
    "prescription": {
        "id": 89,
        "appointment_id": 248,
        "unique_id": "PX0000087",
        "created_at": "2021-02-10",
        "pdf_url": "http:\/\/localhost\/fms-api-laravel\/public\/storage\/uploads\/prescription\/89-1612974321.pdf",
        "status_medicine": "Yet to dispense.",
        "patient": {
            "id": 22,
            "first_name": "Vishnu",
            "middle_name": "S",
            "last_name": "Sharma",
            "email": "vishnusharmatest123@yopmail.com",
            "country_code": "+91",
            "mobile_number": "3736556464",
            "profile_photo_url": null
        },
        "appointment": {
            "id": 248,
            "doctor_id": 2,
            "patient_id": 47,
            "appointment_unique_id": "AP0000248",
            "date": "2021-02-11",
            "time": "12:05:00",
            "consultation_type": "ONLINE",
            "shift": null,
            "payment_status": null,
            "transaction_id": null,
            "total": null,
            "is_cancelled": 0,
            "is_completed": 1,
            "followup_id": null,
            "booking_date": "2021-02-10",
            "current_patient_info": {
                "user": {
                    "first_name": "Diana",
                    "middle_name": "Princess",
                    "last_name": "Wales",
                    "email": "diana@gmail.com",
                    "country_code": "+91",
                    "mobile_number": "7878787878",
                    "profile_photo_url": null
                },
                "case": 1,
                "info": {
                    "first_name": "Diana",
                    "middle_name": "Princess",
                    "last_name": "Wales",
                    "email": "diana@gmail.com",
                    "country_code": "+91",
                    "mobile_number": "7878787878",
                    "height": 156,
                    "weight": 55,
                    "gender": "FEMALE",
                    "age": 23
                },
                "address": {
                    "id": 132,
                    "street_name": "Vadakkaparampill",
                    "city_village": "PATHANAMTHITTA",
                    "district": "Pathanamthitta",
                    "state": "Kerala",
                    "country": "India",
                    "pincode": "689667",
                    "country_code": null,
                    "contact_number": "+917591985087",
                    "latitude": null,
                    "longitude": null,
                    "clinic_name": null
                }
            },
            "doctor": {
                "id": 2,
                "first_name": "Theophilus",
                "middle_name": "Jos",
                "last_name": "Simeon",
                "email": "theophilus@logidots.com",
                "username": "theo",
                "country_code": "+91",
                "mobile_number": "8940330536",
                "user_type": "DOCTOR",
                "is_active": "1",
                "role": null,
                "currency_code": "INR",
                "approved_date": "2021-01-04",
                "profile_photo_url": null
            },
            "clinic_address": {
                "id": 1,
                "street_name": "South Road",
                "city_village": "Edamatto",
                "district": "Kottayam",
                "state": "Kerala",
                "country": "India",
                "pincode": "686575",
                "country_code": null,
                "contact_number": "9786200983",
                "latitude": "10.53034500",
                "longitude": "76.21472900",
                "clinic_name": "Neo clinic"
            }
        }
    }
}
```
> Example response (404):

```json
{
    "message": "Record not found."
}
```

### HTTP Request
`GET api/pharmacy/quote/request/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `quote_request_id` |  required  | integer id of quote_request object

<!-- END_1219567473e0a824beba6d99f764e5a5 -->

<!-- START_9c0c8bb0c9025824cc368009ec84a0a5 -->
## Pharmacy edit Quotes Request by Id

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/pharmacy/quote/request" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"quote_request_id":"modi","status":"ea"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/pharmacy/quote/request"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "quote_request_id": "modi",
    "status": "ea"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "Updated successfully."
}
```

### HTTP Request
`POST api/pharmacy/quote/request`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `quote_request_id` | required |  optional  | integer id of quote request
        `status` | required |  optional  | string send -> Dispensed
    
<!-- END_9c0c8bb0c9025824cc368009ec84a0a5 -->

<!-- START_60c3eaada366386205023d6f2f3be4f8 -->
## Pharmacy add Quote

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/pharmacy/quote" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"quote_request_id":20,"medicine_list":[{"medicine_id":2,"price":"sunt","unit":38768126.558015816,"dosage":"laboriosam","duration":"explicabo","instructions":"omnis"}],"total":"voluptatem","discount":"accusamus","delivery_charge":"et","valid_till":"deserunt"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/pharmacy/quote"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "quote_request_id": 20,
    "medicine_list": [
        {
            "medicine_id": 2,
            "price": "sunt",
            "unit": 38768126.558015816,
            "dosage": "laboriosam",
            "duration": "explicabo",
            "instructions": "omnis"
        }
    ],
    "total": "voluptatem",
    "discount": "accusamus",
    "delivery_charge": "et",
    "valid_till": "deserunt"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "quote_request_id": [
            "The quote request id field is required."
        ],
        "total": [
            "The total field is required."
        ],
        "medicine_list.0.medicine_id": [
            "The medicine id field is required."
        ],
        "medicine_list.0.price": [
            "The price field is required."
        ],
        "medicine_list.0.unit": [
            "The unit must be a number."
        ]
    }
}
```
> Example response (200):

```json
{
    "message": "Quotes saved successfully."
}
```

### HTTP Request
`POST api/pharmacy/quote`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `quote_request_id` | integer |  required  | 
        `medicine_list` | array |  required  | 
        `medicine_list.*.medicine_id` | integer |  required  | medicine id
        `medicine_list.*.price` | decimal |  required  | price
        `medicine_list.*.unit` | number |  required  | 
        `medicine_list.*.dosage` | string |  required  | 
        `medicine_list.*.duration` | string |  required  | 
        `medicine_list.*.instructions` | string |  required  | 
        `total` | decimal |  required  | price
        `discount` | decimal |  optional  | present nullable price
        `delivery_charge` | present |  optional  | nullable price
        `valid_till` | required |  optional  | date format-> Y-m-d
    
<!-- END_60c3eaada366386205023d6f2f3be4f8 -->

<!-- START_496e7a540135befaf483c105f019e737 -->
## Pharmacy get Quotes by QuoteRequest Id

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/pharmacy/quote/1/request?quote_request_id=dolor" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/pharmacy/quote/1/request"
);

let params = {
    "quote_request_id": "dolor",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "id": 6,
    "quote_request_id": 65,
    "status": "0",
    "medicine": {
        "total": 188.3,
        "discount": "1",
        "delivery_charge": "1",
        "medicine_list": [
            {
                "unit": 1,
                "price": 10,
                "dosage": "1 - 0 - 1 - 0",
                "duration": "4 days",
                "medicine_id": 2,
                "instructions": null,
                "no_of_refill": "1",
                "medicine": {
                    "id": 2,
                    "category_id": 1,
                    "sku": "MED0000002",
                    "composition": "water",
                    "weight": 12,
                    "weight_unit": "g",
                    "name": "test",
                    "manufacturer": "dndnd",
                    "medicine_type": "Capsules",
                    "drug_type": "Generic",
                    "qty_per_strip": 3,
                    "price_per_strip": 10,
                    "rate_per_unit": 12,
                    "rx_required": 0,
                    "short_desc": "good",
                    "long_desc": "null",
                    "cart_desc": "cart good",
                    "image_name": "medicine.png",
                    "image_url": null
                }
            },
            {
                "unit": 1,
                "price": 100.3,
                "dosage": "1 - 0 - 1 - 0",
                "duration": "2 days",
                "medicine_id": 4,
                "instructions": null,
                "no_of_refill": "1",
                "medicine": {
                    "id": 4,
                    "category_id": 2,
                    "sku": "MED0000004",
                    "composition": "test data compo",
                    "weight": 170.56,
                    "weight_unit": "mg",
                    "name": "Paraceta Test",
                    "manufacturer": "Pfizer",
                    "medicine_type": "Suppositories",
                    "drug_type": "Branded",
                    "qty_per_strip": 5,
                    "price_per_strip": 100.3,
                    "rate_per_unit": 6,
                    "rx_required": 1,
                    "short_desc": null,
                    "long_desc": "null",
                    "cart_desc": null,
                    "image_name": null,
                    "image_url": null
                }
            }
        ]
    },
    "prescription": {
        "id": 76,
        "appointment_id": 234,
        "unique_id": "PX0000076",
        "created_at": "2021-02-10",
        "pdf_url": null,
        "status_medicine": "Yet to dispense.",
        "patient": {
            "id": 22,
            "first_name": "Vishnu",
            "middle_name": "S",
            "last_name": "Sharma",
            "email": "vishnusharmatest123@yopmail.com",
            "country_code": "+91",
            "mobile_number": "3736556464",
            "profile_photo_url": null
        },
        "appointment": {
            "id": 234,
            "doctor_id": 2,
            "patient_id": 47,
            "appointment_unique_id": "AP0000234",
            "date": "2021-02-10",
            "time": "10:00:00",
            "consultation_type": "INCLINIC",
            "shift": null,
            "payment_status": null,
            "transaction_id": null,
            "total": null,
            "is_cancelled": 0,
            "is_completed": 1,
            "followup_id": null,
            "booking_date": "2021-02-10",
            "current_patient_info": {
                "user": {
                    "first_name": "Diana",
                    "middle_name": "Princess",
                    "last_name": "Wales",
                    "email": "diana@gmail.com",
                    "country_code": "+91",
                    "mobile_number": "7878787878",
                    "profile_photo_url": null
                },
                "case": 1,
                "info": {
                    "first_name": "Diana",
                    "middle_name": "Princess",
                    "last_name": "Wales",
                    "email": "diana@gmail.com",
                    "country_code": "+91",
                    "mobile_number": "7878787878",
                    "height": 156,
                    "weight": 55,
                    "gender": "FEMALE",
                    "age": 23
                },
                "address": {
                    "id": 132,
                    "street_name": "Vadakkaparampill",
                    "city_village": "PATHANAMTHITTA",
                    "district": "Pathanamthitta",
                    "state": "Kerala",
                    "country": "India",
                    "pincode": "689667",
                    "country_code": null,
                    "contact_number": "+917591985087",
                    "latitude": null,
                    "longitude": null,
                    "clinic_name": null
                }
            },
            "doctor": {
                "id": 2,
                "first_name": "Theophilus",
                "middle_name": "Jos",
                "last_name": "Simeon",
                "email": "theophilus@logidots.com",
                "username": "theo",
                "country_code": "+91",
                "mobile_number": "8940330536",
                "user_type": "DOCTOR",
                "is_active": "1",
                "role": null,
                "currency_code": "INR",
                "approved_date": "2021-01-04",
                "profile_photo_url": null
            }
        }
    }
}
```
> Example response (404):

```json
{
    "message": "No record found."
}
```

### HTTP Request
`GET api/pharmacy/quote/{id}/request`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `quote_request_id` |  required  | id of Quote request list

<!-- END_496e7a540135befaf483c105f019e737 -->

<!-- START_f01b5214190fb8598a11944bd8c5e4ad -->
## Pharmacy get Quotes

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/pharmacy/quote" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/pharmacy/quote"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 75,
            "created_at": "2021-03-02 09:12:58 pm",
            "unique_id": "QT0000076",
            "quote_request": {
                "created_at": "2021-02-12 12:01:26 am",
                "quote_type": null
            },
            "order": {
                "id": 1,
                "user_id": 3,
                "tax": 10,
                "subtotal": 20,
                "discount": 2,
                "delivery_charge": 2,
                "total": 500.49,
                "shipping_address_id": 1,
                "payment_status": "Not Paid",
                "delivery_status": "Open",
                "delivery_info": null,
                "created_at": "2021-03-02 06:29:02 pm"
            },
            "prescription": {
                "id": 114,
                "appointment_id": 285,
                "unique_id": "PX0000114",
                "created_at": "2021-02-11",
                "pdf_url": null,
                "status_medicine": "Quote generated.",
                "patient": {
                    "id": 22,
                    "first_name": "Vishnu",
                    "middle_name": "S",
                    "last_name": "Sharma",
                    "email": "vishnusharmatest123@yopmail.com",
                    "country_code": "+91",
                    "mobile_number": "3736556464",
                    "profile_photo_url": null
                },
                "appointment": {
                    "id": 285,
                    "doctor_id": 2,
                    "patient_id": 3,
                    "appointment_unique_id": "AP0000285",
                    "date": "2021-02-11",
                    "time": "18:28:00",
                    "start_time": null,
                    "end_time": null,
                    "consultation_type": "ONLINE",
                    "shift": null,
                    "payment_status": null,
                    "transaction_id": null,
                    "total": null,
                    "tax": null,
                    "is_cancelled": 0,
                    "is_completed": 1,
                    "followup_id": null,
                    "booking_date": "2021-02-11",
                    "current_patient_info": {
                        "user": {
                            "first_name": "Ben",
                            "middle_name": null,
                            "last_name": "Patient",
                            "email": "patient@logidots.com",
                            "country_code": "+91",
                            "mobile_number": "9876543210",
                            "profile_photo_url": null
                        },
                        "case": 2,
                        "info": {
                            "first_name": "James",
                            "middle_name": "s",
                            "last_name": "Bond",
                            "email": "patient@logidots.com",
                            "country_code": "+91",
                            "mobile_number": 9876543210,
                            "height": 0,
                            "weight": 0,
                            "gender": "MALE",
                            "age": 10
                        },
                        "address": {
                            "id": 36,
                            "street_name": "Sreekariyam",
                            "city_village": "Trivandrum",
                            "district": "Alappuzha",
                            "state": "Kerala",
                            "country": "India",
                            "pincode": "688001",
                            "country_code": null,
                            "contact_number": null,
                            "land_mark": null,
                            "latitude": null,
                            "longitude": null,
                            "clinic_name": null
                        }
                    },
                    "doctor": {
                        "id": 2,
                        "first_name": "Theophilus",
                        "middle_name": "Jos",
                        "last_name": "Simeon",
                        "email": "theophilus@logidots.com",
                        "username": "theo",
                        "country_code": "+91",
                        "mobile_number": "8940330536",
                        "user_type": "DOCTOR",
                        "is_active": "1",
                        "role": null,
                        "currency_code": "INR",
                        "approved_date": "2021-01-04",
                        "profile_photo_url": null
                    }
                }
            }
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/pharmacy\/quote?page=1",
    "from": 1,
    "last_page": 11,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/pharmacy\/quote?page=11",
    "next_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/pharmacy\/quote?page=2",
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/pharmacy\/quote",
    "per_page": 1,
    "prev_page_url": null,
    "to": 1,
    "total": 11
}
```
> Example response (404):

```json
{
    "message": "Quotes not found."
}
```

### HTTP Request
`GET api/pharmacy/quote`


<!-- END_f01b5214190fb8598a11944bd8c5e4ad -->

<!-- START_2ce5c862df806499dc012a08674116c5 -->
## Pharmacy get Quotes by Id

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/pharmacy/quote/1?id=nesciunt" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/pharmacy/quote/1"
);

let params = {
    "id": "nesciunt",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "id": 75,
    "created_at": "2021-03-02 09:12:58 pm",
    "unique_id": "QT0000076",
    "order": {
        "id": 5,
        "user_id": 3,
        "tax": 10,
        "subtotal": 20,
        "discount": 2,
        "delivery_charge": 2,
        "total": 500.49,
        "shipping_address_id": 1,
        "payment_status": "Not Paid",
        "delivery_status": "Open",
        "delivery_info": null,
        "created_at": "2021-03-04 12:07:08 am",
        "billing_address": [
            {
                "id": 1,
                "street_name": "South Road",
                "city_village": "Edamatto",
                "district": "Kottayam",
                "state": "Kerala",
                "country": "India",
                "pincode": "686575",
                "country_code": null,
                "contact_number": "9786200983",
                "land_mark": null,
                "latitude": "10.53034500",
                "longitude": "76.21472900",
                "clinic_name": "Neo clinic"
            }
        ],
        "payments": {
            "id": 1,
            "unique_id": "PAY0000001",
            "total_amount": 500.49,
            "payment_status": "Not Paid",
            "created_at": "2021-03-04 12:07:08 am"
        }
    },
    "prescription": {
        "id": 114,
        "appointment_id": 285,
        "unique_id": "PX0000114",
        "created_at": "2021-02-11",
        "pdf_url": null,
        "patient": {
            "id": 22,
            "first_name": "Vishnu",
            "middle_name": "S",
            "last_name": "Sharma",
            "email": "vishnusharmatest123@yopmail.com",
            "country_code": "+91",
            "mobile_number": "3736556464",
            "profile_photo_url": null
        },
        "status_medicine": "Quote generated.",
        "appointment": {
            "id": 285,
            "doctor_id": 2,
            "patient_id": 3,
            "appointment_unique_id": "AP0000285",
            "date": "2021-02-11",
            "time": "18:28:00",
            "start_time": null,
            "end_time": null,
            "consultation_type": "ONLINE",
            "shift": null,
            "payment_status": null,
            "transaction_id": null,
            "total": null,
            "tax": null,
            "is_cancelled": 0,
            "is_completed": 1,
            "followup_id": null,
            "razorpay_payment_id": null,
            "razorpay_order_id": null,
            "razorpay_signature": null,
            "booking_date": "2021-02-11",
            "current_patient_info": {
                "user": {
                    "first_name": "Ben",
                    "middle_name": null,
                    "last_name": "Patient",
                    "email": "patient@logidots.com",
                    "country_code": "+91",
                    "mobile_number": "9876543210",
                    "profile_photo_url": null
                },
                "case": 2,
                "info": {
                    "first_name": "James",
                    "middle_name": "s",
                    "last_name": "Bond",
                    "email": "patient@logidots.com",
                    "country_code": "+91",
                    "mobile_number": 9876543210,
                    "height": 0,
                    "weight": 0,
                    "gender": "MALE",
                    "age": 10
                }
            },
            "doctor": {
                "id": 2,
                "first_name": "Theophilus",
                "middle_name": "Jos",
                "last_name": "Simeon",
                "email": "theophilus@logidots.com",
                "username": "theo",
                "country_code": "+91",
                "mobile_number": "8940330536",
                "user_type": "DOCTOR",
                "is_active": "1",
                "role": null,
                "currency_code": "INR",
                "approved_date": "2021-01-04",
                "profile_photo_url": null
            }
        }
    }
}
```
> Example response (404):

```json
{
    "message": "Record not found."
}
```

### HTTP Request
`GET api/pharmacy/quote/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of quote

<!-- END_2ce5c862df806499dc012a08674116c5 -->

<!-- START_96cf6d531705086581ad64edfa4c3665 -->
## Pharmacy list payouts

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/pharmacy/payouts?paid=quisquam" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/pharmacy/payouts"
);

let params = {
    "paid": "quisquam",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "paid": [
            "The paid field must be present."
        ]
    }
}
```
> Example response (200):

```json
{
    "next_payout_period": "28 March 2021 11:59 PM",
    "current_page": 1,
    "data": [
        {
            "id": 64,
            "unique_id": "ORD0000064",
            "user_id": 3,
            "tax": 1.8,
            "subtotal": 200,
            "discount": 5,
            "delivery_charge": 10,
            "total": 206.8,
            "commission": 10,
            "shipping_address_id": 75,
            "payment_status": "Paid",
            "delivery_status": "Open",
            "delivery_info": null,
            "created_at": "2021-03-23 06:08:39 pm",
            "user": {
                "id": 3,
                "first_name": "Test",
                "middle_name": "middle",
                "last_name": "Patient",
                "email": "patient@logidots.com",
                "country_code": "+91",
                "mobile_number": "9876543210",
                "profile_photo_url": null
            },
            "payments": {
                "id": 285,
                "unique_id": "PAY0000285",
                "total_amount": 206.8,
                "payment_status": "Paid",
                "created_at": "2021-03-23 06:08:39 pm"
            }
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/pharmacy\/payouts?page=1",
    "from": 1,
    "last_page": 7,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/pharmacy\/payouts?page=7",
    "next_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/pharmacy\/payouts?page=2",
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/pharmacy\/payouts",
    "per_page": 1,
    "prev_page_url": null,
    "to": 1,
    "total": 7
}
```
> Example response (404):

```json
{
    "message": "No records found."
}
```

### HTTP Request
`GET api/pharmacy/payouts`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `paid` |  optional  | present integer 0 for unpaid , 1 for paid

<!-- END_96cf6d531705086581ad64edfa4c3665 -->

#Reviews


<!-- START_59712962b9cb62fbd066a9615707407d -->
## Patient Review add

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/patient/review" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"to_id":7,"rating":16,"title":"error","review":"et"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/patient/review"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "to_id": 7,
    "rating": 16,
    "title": "error",
    "review": "et"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "to_id": [
            "The to id field is required."
        ],
        "rating": [
            "The rating field is required."
        ],
        "title": [
            "The title field is required."
        ]
    }
}
```
> Example response (404):

```json
{
    "message": "Doctor not found"
}
```
> Example response (200):

```json
{
    "message": "Review added successfully"
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`POST api/patient/review`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `to_id` | integer |  required  | id of doctor
        `rating` | integer |  required  | 
        `title` | string |  required  | 
        `review` | string |  optional  | nullable
    
<!-- END_59712962b9cb62fbd066a9615707407d -->

<!-- START_ec59e3ca76ce92d0340b5a8bb96efb17 -->
## Patient Review update

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/patient/review/1?id=illum" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"rating":2,"title":"qui","review":"impedit"}'

```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/patient/review/1"
);

let params = {
    "id": "illum",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "rating": 2,
    "title": "qui",
    "review": "impedit"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "rating": [
            "The rating field is required."
        ],
        "title": [
            "The title field is required."
        ]
    }
}
```
> Example response (404):

```json
{
    "message": "Review not found"
}
```
> Example response (200):

```json
{
    "message": "Review updated successfully"
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`POST api/patient/review/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of record
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `rating` | integer |  required  | 
        `title` | string |  required  | 
        `review` | string |  optional  | nullable
    
<!-- END_ec59e3ca76ce92d0340b5a8bb96efb17 -->

<!-- START_41f991b72547af0b32d2d18311dd8acc -->
## Patient Review list

Authorization: &quot;Bearer {access_token}&quot;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/patient/review" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/patient/review"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 21,
            "rating": 2,
            "title": "very good doctor",
            "review": "wait and update",
            "created_time": "Reviewed 5 minutes ago",
            "doctor": {
                "id": 1,
                "first_name": "theophilus",
                "middle_name": null,
                "last_name": "simeon"
            }
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/review?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/review?page=1",
    "next_page_url": null,
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/patient\/review",
    "per_page": 10,
    "prev_page_url": null,
    "to": 1,
    "total": 1
}
```
> Example response (404):

```json
{
    "message": "Reviews not found."
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/patient/review`


<!-- END_41f991b72547af0b32d2d18311dd8acc -->

<!-- START_b30829f480c0493526a3cea75d101633 -->
## Patient Review delete

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X DELETE \
    "http://localhost/fms-api-laravel/public/api/patient/review/1?id=excepturi" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/patient/review/1"
);

let params = {
    "id": "excepturi",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "Review deleted successfully"
}
```
> Example response (404):

```json
{
    "message": "Review not found"
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`DELETE api/patient/review/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of record

<!-- END_b30829f480c0493526a3cea75d101633 -->

#Search


<!-- START_4aabe596f7546edea21802df8bb1b74b -->
## Get Address list based on search

> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/guest/search/address?location=16" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/guest/search/address"
);

let params = {
    "location": "16",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 91,
            "address_type": "CLINIC",
            "street_name": "Boyle Radial",
            "city_village": "56152 Mallory Passage",
            "district": "Abbottside",
            "state": "Washington",
            "country": "Somalia",
            "pincode": "49690",
            "country_code": "+91",
            "contact_number": "803-327-3274",
            "latitude": "84.37410600",
            "longitude": "-26.71904700",
            "clinic_name": "batz"
        },
        {
            "id": 96,
            "address_type": "CLINIC",
            "street_name": "Schaden Light",
            "city_village": "72768 Lloyd Ridges",
            "district": "South Cassiemouth",
            "state": "Washington",
            "country": "Trinidad and Tobago",
            "pincode": "00966-2863",
            "country_code": "+91",
            "contact_number": "879-713-4248 x0178",
            "latitude": "68.83947400",
            "longitude": "-112.17728600",
            "clinic_name": "batz"
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/guest\/search\/address?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/guest\/search\/address?page=1",
    "next_page_url": null,
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/guest\/search\/address",
    "per_page": 10,
    "prev_page_url": null,
    "to": 4,
    "total": 4
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "location": [
            "The location must be an array.."
        ]
    }
}
```
> Example response (404):

```json
{
    "message": "We couldn't find address for you"
}
```

### HTTP Request
`GET api/guest/search/address`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `location` |  required  | array location[street_name] = "Washington" or location[city_village] = "Washington" or location[state] = "Washington" or location[district] = "Washington" or location[country] = "Washington"

<!-- END_4aabe596f7546edea21802df8bb1b74b -->

<!-- START_c8e2ec131aa46e32895f681aa4a0ed70 -->
## Get Specialization list based on search

> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/guest/search/specialization?specialization=est" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/guest/search/specialization"
);

let params = {
    "specialization": "est",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
[
    {
        "id": 4,
        "name": "General Physician"
    },
    {
        "id": 5,
        "name": "General Surgeon"
    }
]
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "specialization": [
            "The specialization field is required."
        ]
    }
}
```

### HTTP Request
`GET api/guest/search/specialization`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `specialization` |  required  | string

<!-- END_c8e2ec131aa46e32895f681aa4a0ed70 -->

<!-- START_e15e3926817e374034feb4f9bf4362e5 -->
## Search doctor list based on Address and Specialization

filter[specialization] = 1
or filter[specialization] = 1,2,3
filter[gender] = &#039;FEMALE&#039;
filter[consulting_fee_start] = 500
filter[consulting_fee_end] = 500
shift[0] = &#039;MORNING&#039;
shift[1] = &#039;AFTERNOON&#039;
shift[2] = &#039;EVENING&#039;
shift[3] = &#039;NIGHT&#039;

> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/guest/search/doctor?location=12&filter=harum&shift=sit&sortBy=nihil&orderBy=consectetur&timezone=vero&latitude=corrupti&longitude=provident" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/guest/search/doctor"
);

let params = {
    "location": "12",
    "filter": "harum",
    "shift": "sit",
    "sortBy": "nihil",
    "orderBy": "consectetur",
    "timezone": "vero",
    "latitude": "corrupti",
    "longitude": "provident",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "location": [
            "The location field is required."
        ],
        "filter": [
            "The filter must be an array."
        ],
        "shift": [
            "The shift must be an array."
        ]
    }
}
```
> Example response (404):

```json
{
    "message": "We couldn't find doctors for you"
}
```
> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 7,
            "doctor_unique_id": "D0000007",
            "title": "Dr.",
            "gender": "FEMALE",
            "date_of_birth": "2020-09-10",
            "age": 3,
            "qualification": "quaerat",
            "years_of_experience": "5",
            "alt_country_code": "+91",
            "alt_mobile_number": "1-914-676-8725",
            "clinic_name": null,
            "career_profile": null,
            "education_training": null,
            "experience": null,
            "clinical_focus": null,
            "awards_achievements": null,
            "memberships": null,
            "doctor_profile_photo": "http:\/\/localhost\/fms-api-laravel\/public\/storage\/uploads\/1\/1601267114-f03757bd-2cbb-49d8-8415-d45174811aaf.jpeg",
            "appointment_type_online": null,
            "appointment_type_offline": null,
            "consulting_online_fee": 681,
            "consulting_offline_fee": 107,
            "available_from_time": null,
            "available_to_time": null,
            "service": null,
            "reviews_count": 1,
            "average_rating": "4.3333",
            "user": {
                "id": 10,
                "first_name": "Rasheed Hettinger",
                "last_name": "Demario Senger Jr."
            },
            "address": [
                {
                    "id": 21,
                    "street_name": "East Road",
                    "city_village": "Air Village",
                    "district": "Kollam",
                    "state": "Kerala",
                    "country": "India",
                    "pincode": "601021",
                    "country_code": "+91",
                    "contact_number": null,
                    "latitude": "10.53034500",
                    "longitude": "76.21472900",
                    "clinic_name": "batz"
                }
            ]
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/guest\/search\/doctor?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/guest\/search\/doctor?page=1",
    "next_page_url": null,
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/guest\/search\/doctor",
    "per_page": 10,
    "prev_page_url": null,
    "to": 1,
    "total": 1
}
```

### HTTP Request
`GET api/guest/search/doctor`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `location` |  required  | array location[street_name] = "Washington" or location[city_village] = "Washington" or location[state] = "Washington" or location[district] = "Washington" or location[country] = "Washington"
    `filter` |  optional  | nullable array filter[gender],filter[consulting_fee_start],filter[consulting_fee_end],filter[specialization]
    `shift` |  optional  | nullable array any of ['MORNING','AFTERNOON','EVENING','NIGHT']
    `sortBy` |  optional  | nullable any on of (consulting_online_fee,consulting_offline_fee,years_of_experience)
    `orderBy` |  optional  | nullable any one of (asc,desc)
    `timezone` |  required  | string format -> Asia/Kolkata
    `latitude` |  optional  | nullable string
    `longitude` |  optional  | nullable string

<!-- END_e15e3926817e374034feb4f9bf4362e5 -->

<!-- START_1cfcad2c93adc8993f852935ff78a6c5 -->
## Get Doctor details by id

> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/guest/search/doctor/1?id=ea" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/guest/search/doctor/1"
);

let params = {
    "id": "ea",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "id": 21,
    "doctor_unique_id": "D0000021",
    "title": "Dr.",
    "gender": "MALE",
    "date_of_birth": "1993-06-19",
    "age": 4,
    "qualification": "BA",
    "years_of_experience": 5,
    "alt_country_code": "+91",
    "alt_mobile_number": null,
    "clinic_name": "GRACE",
    "career_profile": "heart",
    "education_training": "heart",
    "experience": "5",
    "clinical_focus": null,
    "awards_achievements": null,
    "memberships": null,
    "doctor_profile_photo": "http:\/\/localhost\/fms-api-laravel\/public\/storage\/uploads\/1\/1601267114-f03757bd-2cbb-49d8-8415-d45174811aaf.jpeg",
    "appointment_type_online": 1,
    "appointment_type_offline": 1,
    "consulting_online_fee": 400,
    "consulting_offline_fee": 500,
    "available_from_time": null,
    "available_to_time": null,
    "service": "INPATIENT",
    "address_count": 3,
    "reviews_count": 3,
    "average_rating": "4.3333",
    "user": {
        "id": 1,
        "first_name": "Surgeon",
        "middle_name": "Heart",
        "last_name": "Heart surgery"
    },
    "specialization": [
        {
            "id": 1,
            "name": "Orthopedician"
        },
        {
            "id": 3,
            "name": "Pediatrician"
        },
        {
            "id": 5,
            "name": "General Surgeon"
        }
    ],
    "address_first": [
        {
            "id": 202,
            "address_type": "CLINIC",
            "street_name": "address 2",
            "city_village": "garden",
            "district": "kollam",
            "state": "kerala",
            "country": "India",
            "pincode": "680002",
            "contact_number": "+919876543210",
            "latitude": "13.06743900",
            "longitude": "80.23761700",
            "clinic_name": "batz"
        }
    ]
}
```
> Example response (404):

```json
{
    "message": "Doctor not found"
}
```

### HTTP Request
`GET api/guest/search/doctor/{id}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of doctor

<!-- END_1cfcad2c93adc8993f852935ff78a6c5 -->

<!-- START_97bfc9dd509d9afb9c2769047a8b7d85 -->
## Get Doctor overview

> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/guest/search/doctor/1/overview?id=excepturi" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/guest/search/doctor/1/overview"
);

let params = {
    "id": "excepturi",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "career_profile": "heart",
    "experience": "5",
    "education_training": "heart",
    "awards_achievements": null,
    "service": "INPATIENT"
}
```
> Example response (200):

```json
{
    "career_profile": null,
    "experience": null,
    "education_training": null,
    "awards_achievements": null,
    "service": null
}
```

### HTTP Request
`GET api/guest/search/doctor/{id}/overview`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of doctor

<!-- END_97bfc9dd509d9afb9c2769047a8b7d85 -->

<!-- START_37db301c4542f564e74f3b822f702f8a -->
## Get Doctor Locations

> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/guest/search/doctor/1/location?id=asperiores&timezone=explicabo" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/guest/search/doctor/1/location"
);

let params = {
    "id": "asperiores",
    "timezone": "explicabo",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 2,
            "street_name": "address 2",
            "city_village": "garden",
            "district": "kollam",
            "state": "kerala",
            "country": "India",
            "pincode": "680002",
            "country_code": "+91",
            "contact_number": "9876543210",
            "latitude": "13.06743900",
            "longitude": "80.23761700",
            "clinic_name": "batz",
            "timeslot": [
                {
                    "id": 4,
                    "day": "MONDAY",
                    "slot_start": "19:40:00",
                    "slot_end": "19:50:00",
                    "type": "ONLINE",
                    "doctor_clinic_id": 1,
                    "shift": "MORNING",
                    "laravel_through_key": 2
                }
            ]
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/guest\/search\/doctor\/1\/location?page=1",
    "from": 1,
    "last_page": 5,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/guest\/search\/doctor\/1\/location?page=5",
    "next_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/guest\/search\/doctor\/1\/location?page=2",
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/guest\/search\/doctor\/1\/location",
    "per_page": 1,
    "prev_page_url": null,
    "to": 1,
    "total": 5
}
```
> Example response (404):

```json
{
    "message": "Location not found"
}
```

### HTTP Request
`GET api/guest/search/doctor/{id}/location`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of doctor
    `timezone` |  required  | string format -> Asia/Kolkata

<!-- END_37db301c4542f564e74f3b822f702f8a -->

<!-- START_7805892756eee3156169d49f61da9d84 -->
## Get Doctor Reviews

> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/guest/search/doctor/1/review?id=perferendis" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/guest/search/doctor/1/review"
);

let params = {
    "id": "perferendis",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "average_rating": 4.33,
    "current_page": 1,
    "data": [
        {
            "id": 3,
            "rating": 7,
            "title": "very good doctor",
            "review": "wait and seee",
            "created_time": "Reviewed 19 minutes ago",
            "patient": {
                "id": 5,
                "first_name": "ammu",
                "middle_name": null,
                "last_name": "prasad",
                "profile_photo_url": null
            }
        },
        {
            "id": 2,
            "rating": 2,
            "title": "very good doctor",
            "review": "wait and seee",
            "created_time": "Reviewed 42 minutes ago",
            "patient": {
                "id": 4,
                "first_name": "Test",
                "middle_name": null,
                "last_name": "Patient",
                "profile_photo_url": null
            }
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/guest\/search\/doctor\/2\/review?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/guest\/search\/doctor\/2\/review?page=1",
    "next_page_url": null,
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/guest\/search\/doctor\/2\/review",
    "per_page": 10,
    "prev_page_url": null,
    "to": 3,
    "total": 3
}
```
> Example response (404):

```json
{
    "message": "Reviews not found."
}
```

### HTTP Request
`GET api/guest/search/doctor/{id}/review`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of doctor

<!-- END_7805892756eee3156169d49f61da9d84 -->

<!-- START_4498f78fb686d49ae44d6dabe54b903e -->
## Get Doctor Business Hours

> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/guest/search/doctor/1/businesshours?id=officiis" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/guest/search/doctor/1/businesshours"
);

let params = {
    "id": "officiis",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "MORNING": [
        {
            "id": 1,
            "day": "THURSDAY",
            "slot_start": "19:30:00",
            "slot_end": "19:40:00",
            "type": "ONLINE",
            "doctor_clinic_id": 1,
            "shift": "MORNING",
            "address": {
                "id": 1,
                "street_name": "North Road",
                "city_village": "water Village",
                "district": "Thrissur",
                "state": "Kerala",
                "country": "India",
                "pincode": "680001",
                "country_code": "+91",
                "contact_number": null,
                "latitude": "10.53034500",
                "longitude": "76.21472900",
                "clinic_name": "batz",
                "laravel_through_key": 1
            }
        }
    ],
    "NIGHT": [
        {
            "id": 3,
            "day": "MONDAY",
            "slot_start": "19:30:00",
            "slot_end": "19:40:00",
            "type": "ONLINE",
            "doctor_clinic_id": 1,
            "shift": "NIGHT",
            "address": {
                "id": 1,
                "street_name": "North Road",
                "city_village": "water Village",
                "district": "Thrissur",
                "state": "Kerala",
                "country": "India",
                "pincode": "680001",
                "country_code": "+91",
                "contact_number": null,
                "latitude": "10.53034500",
                "longitude": "76.21472900",
                "clinic_name": "batz",
                "laravel_through_key": 1
            }
        }
    ],
    "EVENING": [
        {
            "id": 5,
            "day": "FRIDAY",
            "slot_start": "19:30:00",
            "slot_end": "19:40:00",
            "type": "OFFLINE",
            "doctor_clinic_id": 3,
            "shift": "EVENING",
            "address": {
                "id": 1,
                "street_name": "North Road",
                "city_village": "water Village",
                "district": "Thrissur",
                "state": "Kerala",
                "country": "India",
                "pincode": "680001",
                "country_code": "+91",
                "contact_number": null,
                "latitude": "10.53034500",
                "longitude": "76.21472900",
                "clinic_name": "batz",
                "laravel_through_key": 1
            }
        }
    ]
}
```
> Example response (404):

```json
{
    "message": "Time slots not found"
}
```

### HTTP Request
`GET api/guest/search/doctor/{id}/businesshours`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of doctor

<!-- END_4498f78fb686d49ae44d6dabe54b903e -->

<!-- START_49e8e8c9ef8a7908ddc7087897d47189 -->
## Get Doctor Available Time slots

> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/guest/search/doctor/1/schedule?id=et&date=dolores&timezone=pariatur&clinic_address_id=est" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/guest/search/doctor/1/schedule"
);

let params = {
    "id": "et",
    "date": "dolores",
    "timezone": "pariatur",
    "clinic_address_id": "est",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "MORNING": [
        {
            "id": 1,
            "day": "THURSDAY",
            "slot_start": "19:30:00",
            "slot_end": "19:40:00",
            "type": "ONLINE",
            "doctor_clinic_id": 1,
            "shift": "MORNING",
            "show_emergency": true,
            "address": {
                "id": 68,
                "street_name": "Test street",
                "city_village": "Test villa",
                "district": "Thiruvananthapuram",
                "state": "Kerala",
                "country": "India",
                "pincode": "695001",
                "country_code": null,
                "contact_number": null,
                "latitude": "8.49730180",
                "longitude": "76.94846240",
                "clinic_name": "Back End Developer",
                "laravel_through_key": 27
            }
        }
    ],
    "NIGHT": [
        {
            "id": 3,
            "day": "MONDAY",
            "slot_start": "19:30:00",
            "slot_end": "19:40:00",
            "type": "ONLINE",
            "doctor_clinic_id": 1,
            "shift": "NIGHT",
            "show_emergency": false,
            "address": {
                "id": 68,
                "street_name": "Test street",
                "city_village": "Test villa",
                "district": "Thiruvananthapuram",
                "state": "Kerala",
                "country": "India",
                "pincode": "695001",
                "country_code": null,
                "contact_number": null,
                "latitude": "8.49730180",
                "longitude": "76.94846240",
                "clinic_name": "Back End Developer",
                "laravel_through_key": 27
            }
        }
    ],
    "EVENING": [
        {
            "id": 5,
            "day": "FRIDAY",
            "slot_start": "19:30:00",
            "slot_end": "19:40:00",
            "type": "OFFLINE",
            "doctor_clinic_id": 3,
            "shift": "EVENING",
            "show_emergency": false,
            "address": {
                "id": 68,
                "street_name": "Test street",
                "city_village": "Test villa",
                "district": "Thiruvananthapuram",
                "state": "Kerala",
                "country": "India",
                "pincode": "695001",
                "country_code": null,
                "contact_number": null,
                "latitude": "8.49730180",
                "longitude": "76.94846240",
                "clinic_name": "Back End Developer",
                "laravel_through_key": 27
            }
        }
    ]
}
```
> Example response (404):

```json
{
    "message": "Time slots not found."
}
```

### HTTP Request
`GET api/guest/search/doctor/{id}/schedule`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  required  | integer id of doctor
    `date` |  required  | date format Y-m-d
    `timezone` |  required  | string format -> Asia/Kolkata
    `clinic_address_id` |  optional  | send clinic_address_id for followup appointments

<!-- END_49e8e8c9ef8a7908ddc7087897d47189 -->

<!-- START_b93c84659cd39405e758849a2210863e -->
## User search Medicine

> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/search/medicine?name=sit&category=voluptas&paginate=quae" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/search/medicine"
);

let params = {
    "name": "sit",
    "category": "voluptas",
    "paginate": "quae",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "name": [
            "The name field is required."
        ]
    }
}
```
> Example response (200):

```json
[
    {
        "id": 1,
        "category_id": 1,
        "sku": "MED0000001",
        "composition": "paracet",
        "weight": 0.5,
        "weight_unit": "mg",
        "name": "cita",
        "manufacturer": "Inc",
        "medicine_type": "Tablet",
        "drug_type": "Generic",
        "qty_per_strip": 10,
        "price_per_strip": 200,
        "rate_per_unit": 10,
        "rx_required": 1,
        "short_desc": "Take for fever",
        "long_desc": null,
        "cart_desc": null,
        "image_name": "tiger.jpg",
        "image_url": "http:\/\/localhost\/fms-api-laravel\/public\/storage\/uploads\/medicine\/1608640035tiger.jpg",
        "category": {
            "id": 1,
            "parent_id": null,
            "name": "Tablets"
        }
    }
]
```
> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "category_id": 1,
            "sku": "MED0000001",
            "composition": "paracet",
            "weight": 0.5,
            "weight_unit": "mg",
            "name": "cita",
            "manufacturer": "Inc",
            "medicine_type": "Tablet",
            "drug_type": "Generic",
            "qty_per_strip": 10,
            "price_per_strip": 200,
            "rate_per_unit": 10,
            "rx_required": 1,
            "short_desc": "Take for fever",
            "long_desc": null,
            "cart_desc": null,
            "image_name": "tiger.jpg",
            "image_url": "http:\/\/localhost\/fms-api-laravel\/public\/storage\/uploads\/medicine\/1608640035tiger.jpg",
            "category": {
                "id": 1,
                "parent_id": null,
                "name": "Tablets"
            }
        }
    ],
    "first_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/admin\/medicine\/search?page=1",
    "from": 1,
    "last_page": 3,
    "last_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/admin\/medicine\/search?page=3",
    "next_page_url": "http:\/\/localhost\/fms-api-laravel\/public\/api\/admin\/medicine\/search?page=2",
    "path": "http:\/\/localhost\/fms-api-laravel\/public\/api\/admin\/medicine\/search",
    "per_page": 1,
    "prev_page_url": null,
    "to": 1,
    "total": 3
}
```
> Example response (404):

```json
{
    "message": "Medicine not found."
}
```

### HTTP Request
`GET api/search/medicine`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `name` |  optional  | nullable string
    `category` |  optional  | nullable string
    `paginate` |  optional  | nullable integer nullable paginate = 0

<!-- END_b93c84659cd39405e758849a2210863e -->

#general


<!-- START_8b1955a3392635c623b2a3346f71a60e -->
## api/guest/makepdf
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/guest/makepdf" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/guest/makepdf"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
403
```

### HTTP Request
`GET api/guest/makepdf`


<!-- END_8b1955a3392635c623b2a3346f71a60e -->

<!-- START_c4c361e2a9c64f098339a28238c497b4 -->
## api/facebook/deletioncallback
> Example request:

```bash
curl -X POST \
    "http://localhost/fms-api-laravel/public/api/facebook/deletioncallback" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/facebook/deletioncallback"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/facebook/deletioncallback`


<!-- END_c4c361e2a9c64f098339a28238c497b4 -->

<!-- START_1b4bcac85e1a64bd4a75b936e438ae19 -->
## api/facebook/deletionconfirm
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/facebook/deletionconfirm" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/facebook/deletionconfirm"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "Your account details has been deactivated. Please contact administrator for more information."
}
```

### HTTP Request
`GET api/facebook/deletionconfirm`


<!-- END_1b4bcac85e1a64bd4a75b936e438ae19 -->

<!-- START_25ccdeb69d205a758a7bcd3ead3b3186 -->
## api/test/config
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/test/config" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/test/config"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/test/config`


<!-- END_25ccdeb69d205a758a7bcd3ead3b3186 -->

<!-- START_460fc4753d3894489ebafab36bae6456 -->
## api/test/sendmail
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/test/sendmail" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/test/sendmail"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/test/sendmail`


<!-- END_460fc4753d3894489ebafab36bae6456 -->

<!-- START_947bb49fe9ebeef4217faa3c7e46b5f6 -->
## api/test/seed/medicine
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/test/seed/medicine" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/test/seed/medicine"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/test/seed/medicine`


<!-- END_947bb49fe9ebeef4217faa3c7e46b5f6 -->

<!-- START_e9aac51c8b7458aaa8e03f32af28c820 -->
## api/test/haconvert
> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/test/haconvert" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/test/haconvert"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/test/haconvert`


<!-- END_e9aac51c8b7458aaa8e03f32af28c820 -->

<!-- START_9677625ea7b6e199288bdf7b01c39baf -->
## Display the specified resource.

> Example request:

```bash
curl -X GET \
    -G "http://localhost/fms-api-laravel/public/api/patient/review/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/fms-api-laravel/public/api/patient/review/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/patient/review/{id}`


<!-- END_9677625ea7b6e199288bdf7b01c39baf -->


