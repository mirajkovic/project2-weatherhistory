FROM alpine:latest
RUN apk update \
    && apk add --virtual build-deps gcc python3-dev musl-dev \
    && apk add --no-cache mariadb-dev \
    && apk add gcc musl-dev mariadb-connector-c-dev
RUN apk add python3 py-pip && pip install mysqlclient && pip install mariadb
COPY metar.py .
CMD ["python3", "-u" ,"./metar.py"]