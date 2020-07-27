FROM mysql:5.7

ARG TZ

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

ADD docker/db/init/*.sql /docker-entrypoint-initdb.d/

ADD docker/db/my.cnf /etc

EXPOSE 3306
