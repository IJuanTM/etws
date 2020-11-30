const express = require("express");
const mysql = require("mysql");
const SerialPort = require('serialport');
const Readline = require('@serialport/parser-readline');

const com = new SerialPort("COM4", {baudRate: 9600});
const parser = new Readline();
const app = express();

const con = mysql.createConnection({
  host: "localhost",
  user: "root",
  password: "",
  database: "etws_db"
});

con.connect((err) => {
  if (err) throw err;
  console.log('Connected to MySQL Server!');
});

com.pipe(parser);

parser.on('data', line => con.query(`INSERT INTO etws_data (volt) VALUES ("${line}")`, function (err, result, fields) {
    if (err) throw err;
    return console.log(`${line}`);
  })
);

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