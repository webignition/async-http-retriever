FROM php:7.2-cli

ARG APP_ENV
ARG APP_SECRET
ARG CALLBACK_ALLOWED_HOSTS
ARG RETRIEVER_TIMEOUT_SECONDS
ARG CONSUMER_COUNT

ENV APP_SECRET=$APP_SECRET
ENV APP_ENV=$APP_ENV
ENV CALLBACK_ALLOWED_HOSTS=$CALLBACK_ALLOWED_HOSTS
ENV RETRIEVER_TIMEOUT_SECONDS=$RETRIEVER_TIMEOUT_SECONDS
ENV CONSUMER_COUNT=$CONSUMER_COUNT

RUN apt-get -qq update && apt-get install -qq -y librabbitmq-dev libssh-dev libmemcached-dev supervisor wget
RUN pecl -q install amqp
RUN pecl -q install memcached
RUN docker-php-ext-enable amqp > /dev/null
RUN docker-php-ext-enable memcached > /dev/null
RUN docker-php-ext-install pdo_mysql > /dev/null

ENV DOCKERIZE_VERSION v1.2.0
RUN wget -q https://github.com/presslabs/dockerize/releases/download/$DOCKERIZE_VERSION/dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && tar -C /usr/local/bin -xzvf dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && rm dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz

COPY supervisor/supervisord.conf /etc/supervisor/supervisord.conf
COPY supervisor/conf.d/app.conf /etc/supervisor/conf.d/supervisord.conf

RUN mkdir -p var/log/supervisor
RUN mkdir -p var/log/callback-responses

WORKDIR /app

CMD dockerize -wait tcp://rabbitmq:5672 -timeout 30s -wait tcp://mysql:3306 -timeout 30s supervisord -c /etc/supervisor/supervisord.conf
