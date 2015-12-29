# 158ltd Laravel 5.1 CMS

> This is a boilerplate that should be used when you start new Laravel Project.

### Project initialization

Clone the project

```
git clone git@gitlab.158dev.com:xpuc7o/158ltd_laravel_boilerplate.git
```

and remove `.git` folder from Project's base directory

```
cd /paht/to/158ltd_laravel_boilerplate
```

```
sudo rm -r .git
```

Now you can create your new Project on gitlab and rename your project folder.

```
sudo mv /paht/to/158ltd_laravel_boilerplate /paht/to/my_new_project
```

Add your Project to gitlab

```
git init
```

```
git remote add origin git@gitlab.158dev.com:{username}/my_new_project.git
```

```
git add -A
```

```
git commit -m "My first commit!"
```

```
git push origin master
```

Install dependencies. If you use a Homestead or another Vagrant instance first connect to ssh.

```
composer install
```

run migrations and seeders

```
php artisan migrate --seed
```




