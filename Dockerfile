FROM bitnami/symfony

COPY . /app/cat_cas_car/

WORKDIR /app/

ENV SYMFONY_PROJECT_NAME=cat_cas_car

EXPOSE 8000