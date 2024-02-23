# Dockerfile
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev \
    librabbitmq-dev

# Install PHP extensions for MySQL, PostgreSQL, and others
# Adding 'sockets' extension in the line below
RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd sockets

# Install AMQP extension via PECL
RUN pecl install amqp \
    && docker-php-ext-enable amqp

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Avoid running as root for security
RUN useradd -m myuser
USER myuser

# Copy the application code to the container
COPY --chown=myuser:myuser . /app/

# Expose port 8000 for the users service
EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
