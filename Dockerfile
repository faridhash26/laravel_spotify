# Base Image for Laravel
FROM php:7.4-apache as laravel_base


# Install dependencies
RUN apk add --no-cache curl python3 py3-pip

# Install Docker Compose
RUN curl -L "https://github.com/docker/compose/releases/download/$(curl -s https://api.github.com/repos/docker/compose/releases/latest | grep -oP '(?<="tag_name": ")[^"]*')/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose \
    && chmod +x /usr/local/bin/docker-compose

# Verify installation
RUN docker-compose --version

# Your custom commands
CMD ["sh"]
