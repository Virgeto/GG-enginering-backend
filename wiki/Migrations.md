### **Creating migrations**

Create a new table.

```
create_{my_new_table_name_in_plural}_table

php artisan make:migration create_movies_table --create=movies
```


Add column to existing table.

```
add_{my_new_column_name}_column_to_{table_name}_table

php artisan make:migration add_is_free_comlumn_to_movies_table --table=movies
```

Update existing column.

```
update_{some_column_name}_column_on_{table_name}_table

php artisan make:migration update_name_column_on_movies_table --table=movies
```

Drop column.

```
drop_{column_name}_column_on_{table_name}_table

php artisan make:migration drop_director_column_on_movies_table --table=movies
```

### **Tables naming**

All table names should be in plural.

```
movies
```
Name of table that has "One to Many" relation should consists both related objects as first object is in singular and second is in plural.

```
movie_images
```
Name of pivot table should consists names of both related objects in singular ordered alphabetically.

```
director_movie
```

### **Indexes and foreign keys**

Foreign key columns should be `unsignedInteger` or `unsignedBigInteger` if is needed. Indexes should be placed under table columns.

```
$table->increments('id');
$table->unsignedInteger('director_id');
$table->unsignedInteger('movie_id');
$table->timestamps();

$table->index(['director_id', 'movie_id']);

$table->foreign('director_id')
      ->references('id')
      ->on('directors')
      ->onDelete('cascade')
      ->onUpdate('cascade');

$table->foreign('movie_id')
      ->references('id')
      ->on('movies')
      ->onDelete('cascade')
      ->onUpdate('cascade');
```

### **Rollback**

Always check if table exists.

```
if (Schema::hasTable('movies')) {}
```
or
```
Schema::dropIfExists('movies');
```

If there are some foreign keys drop them first.

```
if (Schema::hasTable('director_movie')) {
    Schema::table('director_movie', function (Blueprint $table) {
        $table->dropForeign('director_movie_director_id_foreign');
        $table->dropForeign('director_movie_movie_id_foreign');
    });

    Schema::drop('director_movie');
}
```

When you need to drop a column check if table and column exists.

```
if (Schema::hasTable('movies') && Schema::hasColumn('movies', 'is_free')) {
    Schema::table('movies', function (Blueprint $table) {
        $table->dropColumn('is_free');
    });
}
```











