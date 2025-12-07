# **Hotel El Palacio**

## Configuración del proyecto por primera vez

### Pasos a seguir

1. Primero se clona el repositorio con git clone

2. Una vez clonado, entramos en la carpeta y ejecutamos:

```console
php artisan key:generate
```

3. Configuramos el .env para la base de datos mysql que hayamos creado en local.

4. Y ejecutamos el siguiente comando para tener las primeras tablas en nuestra base de datos:

```console
php artisan migrate
php artisan serve
```

