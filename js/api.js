const express = require("express");
const mysql = require("mysql");
const SerialPort = require('serialport');
const Readline = require('@serialport/parser-readline');

const com = new SerialPort("COM3", {baudRate: 9600});
const parser = new Readline();
const app = express();

const con = mysql.createConnection({
  host: "localhost",
  user: "etws",
  password: "login",
  database: "etws_db"
});

con.connect((err) => {
  if (err) throw err;
  console.log('Connected to MySQL Server!');
});

com.pipe(parser);

// var values = parser.on('data', line => line.replace(/[^\d.-]/g, ''));

function insertSqlData(line) {
  line = line.replace(/[^\d.-]/g, '');
  if (line) {
    con.query(`INSERT INTO etws_data (product, kilowatt, date) VALUES (1, "${line}", curdate())`, function (err, result, fields) {
      if (err) throw err;
      return console.log(`${line}`);
    })
  }
}

parser.on('data', line => insertSqlData(line));

app.get("/api/etws_serialdata", (req, res) => {
  con.query("SELECT * FROM etws_data", function (err, result, fields) {
    if (err) throw err;
    return res.json(result);
  });
});

app.get("/api/etws_serialdata/:id", (req, res) => {
  let id = req.params.id;
  con.query(`SELECT * FROM etws_data WHERE id = ${id}`, function (err, result, fields) {
    if (err) throw err;
    return res.json(result);
  });
});