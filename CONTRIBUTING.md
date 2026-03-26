# 👷‍♀️ Contributing

## 🚀 Getting Started

1. Fork the repository

2. Clone your fork

3. Install the dependencies:

    ```bash
    composer install
    ```

    ```bash
    npm install
    ```

4. You can start the project like any other Laravel project:

    - Copy the `.env.example` file to `.env`:

        ```bash
        cp .env.example .env
        ```

    - Generate a new application key and run the migrations (with seeds):

        ```bash
        php artisan key:generate
        php artisan migrate:fresh --seed
        ```

    - Start the server and compile the assets:

        ```bash
        php artisan serve
        ```

        ```bash
        npm run dev
        ```

5. Additionally you will have to install the Laravel Passport keys:

    ```bash
    php artisan passport:keys
    ```

    After generating the keys, set the correct ownership and file permissions to avoid OAuth errors:

    ```bash
    chown www-data:www-data storage/oauth-private.key storage/oauth-public.key
    chmod 600 storage/oauth-private.key storage/oauth-public.key
    ```

    > If the keys were generated as root (e.g. via `sudo` or in a Docker container), the web server user (`www-data`) may not be able to read them. The `chown` command above transfers ownership so the web server can access them. If you cannot change ownership, use `chmod 640` instead so the group can read the files.

6. For testing you can login with the following credentials:

    - **Username:** `xy10`
    - **Password:** `password`

Now then, time for you to start contributing!

7. Create a new branch for your feature:

    ```bash
    git checkout -b feature/my-feature
    ```

8. Run the tests:

    ```bash
    php artisan test
    ```

9. Make your changes

10. Run the tests to ensure your changes are working:

    ```bash
    php artisan test
    ```

11. Commit your changes

12. Push your branch to your fork:

    ```bash
    git push origin feature/my-feature
    ```

13. Create a pull request

## ✨ Testing a client application

The client application must use the latest version of [sdclient](https://github.com/curio-team/sdclient). Afterwards add this to the `.env` of the client application:

```env
SD_DEV_URL=http://localhost:8080
```

Start this sdlogin project with:
    
```bash
php artisan serve --port=8080
```

The client application can now login to the local sdlogin server.
