# Welcome to the Skills and certification management system

- [Installation](#installation)
- [Usage](#usage)
- [Admin Documentation](#admin-documentation)
- [Menu Builder](#menu-builder)
- [Developer Guide](#developer-guide)
- [Contributions and Support](#contributions-and-support)
- [License](#license)


## Installation

```sh
git clone this-url
```

```sh
cd project-root
```

##### install [composer](https://getcomposer.org/) dependencies of this project by running

```sh
composer install
```

##### copy `.env-example` to `.env` and configure your database and other connection.

##### run this two command also

```shell
php artisan key:generate
php artisan storage:link 
```

##### run migration and seeder

```shell
php artisan migrate:fresh --seed
php artisan db:seed --class=TablePermissionKeySeeder
```

## Usage

Go to the link `/admin/login` for login and enter the admin credentials below.

```shell
email: admin@gmail.com
password: password
```

## Admin Documentation

[Admin Documentation](docs/index.md) link.

## Menu Builder
You can import/export menu using menu builder. goto `/menu-builder/menus`, then for the first time press `import menu`
button. it will help you to import menu from menu-backup folder. If you create any menu, you could push it to git using
export.

## Developer Guide

### Basic Instruction

- All model should extend BaseModel class.
- All controller should extend BaseController class.

### Javascript Guideline

- use ```serverSideDatatableFactory()``` function for datatable.js rendering.

#### Date time helper. (Date time output format is always - ```Y-m-d H:i```)

- use .flat-date class to enable date input. **(input type should be text.)
- use .flat-time class to enable time input. **(input type should be text.)
- use .flat-datetime class to enable time input. **(input type should be text.)

### CSS/JS compilation

- There are no benefit to edit public/css or public/js file. If you need any customization, you have to edit it from
  resources/js or resources/sass, and then compile

### Policy & Permission

```php
$this->authorize('viewUserPermission', $user);
public function viewUserPermission(User $user, User $model)
{
    return $user->hasPermission('view_user_permission');
}
```

### File Handle

```php
App\Helpers\Classes\FileHandler::storePhoto(?UploadedFile $file, ?string $dir = '', ?string $fileName = ''): ?string
App\Helpers\Classes\FileHandler::deleteFile(?string $path): bool


// image storing example:
$filename = FileHandler::storePhoto($file, 'dirname', 'custom-file-name');
$user = new User();
$user->pic = 'dirname/'. $filename;
$user->save();
```

```html
<!--image show/retrieving example-->
<img src="{{asset('storage/'. $user->pic)}}"/>
```

### Select2 API html format

Just add class ```select2-ajax-wizard``` to enable select2 on your select element

```html
<select class="form-control select2-ajax-wizard"
        name="user_id2"
        id="user_id2"
        data-model="{{base64_encode(Softbd\Acl\Models\User::class)}}"
        data-label-fields="{title} - {institute.title}"
        data-depend-on="user_type_id:#user_type_id"
        data-depend-on-optional="user_type_id:#user_type_id"
        data-dependent-fields="#name"
        data-filters="{{json_encode(['name' => 'Baker Hasan'])}}"
        data-preselected-option="{{json_encode(['text' => 'Baker Hasan', 'id' => 1])}}"
        data-placeholder="Select option"
>
    <option selected disabled>Select User</option>
</select>
```

***

##### Model ```data-model```

This will define which model you want to fetch.

Model namespace should encode using base64_encode. Otherwise, it won't work.

excepted format
```data-model="{{base64_encode(Softbd\Acl\Models\User::class)}}"```


***

##### Label Fields ```data-label-fields```

The definition of which field you want to fetch from model and display in select2.

```data-label-fields="{name}"```

if its relational column

```data-label-fields="{institute.title}"```

if you want to show multiple column.

```data-label-fields="{name} - {institute.title}"```

***

##### Depend on fields ```data-depend-on```

When the resource depends on some other input field, then

```data-depend-on="user_type_id"```

Here, user_type_id field value passed to ajax request for filter.

You may define column name and field name as well, Otherwise it will parse automatically

ID
```data-depend-on="user_type_id:#user_type_id"```

Class
```data-depend-on="user_type_id:.user_type_id"```

Name
```data-depend-on="user_type_id:[name=user_type_id]"```

***

##### Depend on optional ```data-depend-on-optional```

Where depend on always pass the value to ajax, but ```data-depend-on-optional``` only pass the value if the value isn't
empty.

```data-depend-on-optional="user_type_id:#user_type_id"```

selector criteria same as ```data-depend-on```.

***

##### Dependant field ```data-dependent-fields```

If any of the field dependent to this field, then.

```data-dependent-fields="#name_en"```

multiple
```data-dependent-fields="#name_en|.name_bn|[name=email]"```

***

##### Filters ```data-filters```

Additional filter.
```html
data-filters="{{json_encode(['name_en' => 'Hasan'])}}"
```
```html
data-filters="{{json_encode(['id' => [\App\Models\User::USER_TYPE_TRAINER_USER_CODE, 'type' => 'not-equal']])}}"
```
```html
data-filters="{{json_encode(['id' => [\App\Models\User::USER_TYPE_TRAINER_USER_CODE, 'type' => 'equal']])}}"
```

***

##### Scopes ```data-scopes```

Apply scopes.
```data-scopes="acl|bcl"```

***

##### Preselected option ```data-preselected-option```

```html
data-preselected-option="{{json_encode(['text' => 'Hasan', 'id' => 1])}}"
```

***

##### Placeholder ```data-placeholder```

```data-data-placeholder="Select User"```

### Fetch model using AJAX

```javascript
$.ajax({
    type: 'post',
    url: '{{route('web-api.model-resources')}}',
    data: {
        resource: {
            model: "{{base64_encode(\Softbd\Acl\Models\User::class)}}",
            columns: 'name_en|institute.title_en|institute.title_bn',
            scopes: 'acl',
        }
    }
}).then(function (res) {
    console.log(res);
});
```
## To set locale, locale currency and locale country code
Go to config/settings.php and set your locales 

## Contributions and Support

Thanks to everyone who has contributed to this project!

Please see CONTRIBUTING.md to contribute.

If you have any query please email me to [ringku369@gmail.com]

