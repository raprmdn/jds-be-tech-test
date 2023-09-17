## JDS Backend Technical Test

### Installation

Clone the repository:

```bash
git clone https://github.com/raprmdn/jds-be-tech-test.git
```

cd into the project directory:

```bash
cd jds-be-tech-test
```

Install the dependencies:

```bash
composer install
```

> Note: If you're facing any issue with installation `laravel/passport` package `ext-sodium`. Please enable in your `php.ini` file.

Copy the `.env.example` file to `.env`:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Link the storage directory:

```bash
php artisan storage:link
```

Run the database migrations and seeders:

```bash
php artisan migrate --seed
```

Install the passport keys:

```bash
php artisan passport:install
```

### Usage

Start the local development server:

```bash
php artisan serve
```

Redis is required to run the queue worker.
You can download and install it from [here](https://redis.io/docs/getting-started/installation/).

After installing redis, run the redis server:

```bash
redis-server
```

Run the queue worker:

```bash
php artisan queue:work
```

### API Documentation

The API Documentation is available at [Postman](https://documenter.getpostman.com/view/13401148/2s9YC7SX1J)

