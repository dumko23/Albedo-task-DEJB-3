# Albedo-Test-Task №3
ALbedo Internship Task 


### How to run this project?
```sample.env.example``` is located in project root folder. Create your own ```.env``` file to adjust project configurations.


Run ```php artisan key:generate``` to generate your project key.


Adjust following section to configurate your DB connection:
```
DB_CONNECTION=mysql
...
```


Adjust following section to configure admin user authenticate credentials:
```
ADMIN_EMAIL=test@example.com
ADMIN_PASSWORD=xm46c8XdzDaXH_7
ADMIN_NAME="Test User"
```


Adjust ```database/seeders```, run ```php artisan migrate``` and ```php artisan db:seed``` to initiate database table, seed your admin record and some dummy member data.


Run ```npm run watch``` to compile project Mix files in development.


Run ```php artisan serve``` to run Laravel development server.



### Aditional info
```_socials.php``` is located in ```/config```. Here you can change social sharing message.
