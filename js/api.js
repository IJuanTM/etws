const express = require("express");
const mysql = require("mysql");
const SerialPort = require("serialport");
const Readline = require("@serialport/parser-readline");

const com = new SerialPort("COM3", {baudRate: 9600});
const parser = new Readline();
const app = express();

// Set database vars
const con = mysql.createConnection({
  host: "localhost",
  user: "etws",
  password: "login",
  database: "etws_db"
});

// Log connection
con.connect((err) => {
  if (err) throw err;
  console.log("Connected to MySQL Server!");
});

com.pipe(parser);

function insertSqlData(line) {
  // Remove all string from line and only keep numbers
  line = line.replace(/[^\d.-]/g, "");

  // Prepare line to database
  if (line) {
    // Return when activity
    console.log("Water flowing...");

    con.query(`INSERT INTO etws_data (product, kilowatt, date) VALUES (1, ${line}, curdate())`, function (err) {
      // Error throw
      if (err) throw err;

      // Return console log
      return console.log(`${line}` + " kilowatts of data have been pushed to the database");
    })
  }
}

// Insert sql query to database
parser.on("data", line => insertSqlData(line));