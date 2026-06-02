# 🔐 `sdlogin` - The login service for Curio SD

This project is the login service for Curio SD. It is open-source for educational purposes.

## 📦 Getting Started

This is a Laravel application. To get started, clone the repository and install the dependencies:

```bash
git clone https://github.com/curio-team/sdlogin.git
cd sdlogin
```

> [!TIP]
> On production you may want to use `composer install --no-dev` to avoid installing development dependencies.

```bash
composer install
```

> [!TIP]
> If you get errors during the `composer install`, make sure you have the correct PHP version and extensions installed (like `sodium`). [&raquo; Read how to install PHP extensions on Windows](https://www.php.net/manual/en/install.pecl.windows.php)

```bash
npm install
```

Then, copy the `.env.example` file to `.env` and configure your environment variables:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Ensure the OAuth keys are generated:

```bash
php artisan passport:install
```

Finally, run the migrations:

```bash
php artisan migrate
```

You can now start the Vue development server and the Laravel application:

```bash
npm run dev
php artisan serve
```

## 🚀 Adding SD Login to your project

1. Ask a teacher to create a new client application for you.

2. Install the [`curio/sdclient` package](https://github.com/curio-team/sdclient)

    ```bash
    composer require curio/sdclient
    ```

3. Follow the instructions in the [`sdclient` README](https://github.com/curio-team/sdclient)

## 👷‍♀️ Contributing

We welcome contributions from the community. Please see the [contributing guide](CONTRIBUTING.md) for more information.
