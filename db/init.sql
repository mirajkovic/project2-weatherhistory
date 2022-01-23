CREATE DATABASE IF NOT EXISTS testdb;
CREATE TABLE WeatherData (
    City varchar(255),
    Temperature double,
    Pressure double,
    Wind int,
    MeasureTime datetime
);