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

4. Create a new branch for your feature:

    ```bash
    git checkout -b feature/my-feature
    ```

5. Run the tests:

    ```bash
    composer test
    ```

6. You can start the project like any other Laravel project:

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

7. For testing you can login with the following credentials:

    - **Username:** `xy10`
    - **Password:** `password`

8. Make your changes

9. Run the tests to ensure your changes are working:

    ```bash
    composer test
    ```

10. Commit your changes

11. Push your branch to your fork:

    ```bash
    git push origin feature/my-feature
    ```

12. Create a pull request
