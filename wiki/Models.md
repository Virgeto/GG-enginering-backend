### **Creating migrations**

```
php artisan make:model Movie
```

## **Structure**
> Use this structure when create a new Model.

#### Related table

```
protected $table = 'movies';
```

#### Fillable fields

```
protected $fillable = ['name'];
```

#### Hidden fields

```
protected $hidden = ['updated_at'];
```

#### Relations

```
public function city()
{
    return $this->belongsTo(City::class);
}
```

#### Scope methods

```
public function scopeTopRated($query) {
    return $query->orderBy('rating', 'desc');
}
```

#### Other methods

```
public function associateDirector($director)
{
    if (!empty($director)) {
        $this->director()->associate($director);
    }
}
```









