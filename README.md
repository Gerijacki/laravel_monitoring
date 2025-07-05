# Laravel Monitoring

**Laravel Monitoring** és una aplicació per monitoritzar i analitzar esdeveniments i errors de diversos projectes, amb un panell d'administració basat en [Filament](https://filamentphp.com/).

## Característiques

- API per registrar esdeveniments (errors, warnings, info, debug) des de qualsevol projecte.
- Panell d'administració amb Filament per consultar i filtrar esdeveniments.
- Estadístiques i gràfiques d'errors i projectes.
- Gestió de projectes i categories.
- Autenticació per token per a l'API.
- Resum diari automàtic dels esdeveniments.

## Instal·lació

1. **Clona el repositori:**
   ```sh
   git clone https://github.com/Gerijacki/laravel_monitoring
   cd laravel-monitoring
   ```

2. **Instal·la les dependències:**
   ```sh
   composer install
   ```

3. **Configura l'entorn:**
   ```sh
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configura la base de dades** al fitxer `.env`.

5. **Executa les migracions i seeders:**
   ```sh
   php artisan migrate --seed
   ```

6. **Inicia el servidor:**
   ```sh
   php artisan serve
   ```

## Accés al panell d'administració

- Accedeix a `/admin` amb l'usuari:
  - **Email:** admin@example.com
  - **Contrasenya:** password123

## Exemple d'ús de l'API

Pots registrar un esdeveniment amb una petició com aquesta:

```sh
curl -X POST https://monitor.local/api/events \
  -H "Authorization: Bearer ACTUAL_TOKEN_DEL_PROJECTE" \
  -H "Content-Type: application/json" \
  -d '{
        "type": "error",
        "title": "Database timeout",
        "payload": {
          "exception": "PDOException",
          "code": 500
        },
        "occurred_at": "2025-07-04T10:00:00Z"
      }'
```

## Estructura principal

- **app/Filament**: Recursos, pàgines i widgets del panell d'administració.
- **app/Models**: Models Eloquent.
- **routes/api.php**: Rutes de l'API.
- **database/migrations**: Migracions de la base de dades.
- **database/seeders**: Seeders per dades inicials.

## Requisits

- PHP 8.1 o superior
- MySQL o MariaDB
- Composer

## Llicència

Aquest projecte està sota llicència MIT.

---

Fet amb ❤️ per Gerijacki.
