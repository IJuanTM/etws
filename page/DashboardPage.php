<?php

use JetBrains\PhpStorm\Pure;

class DashboardPage
{
    // Create static variable kwh
    private static string $kwh;
    private static array $week = [];

    // Function to display the right day to the table
    public static function selectDate($col_day): bool|string
    {
        // Gets real day in numeric value with monday = 1, tuesday = 2, wedne...
        $real_day = date("N");
        // Checks if the current column is the same as the real day (-1, -2,-...)
        if ($col_day == $real_day) {
            // Returns the current date
            $date = DATE;
        } elseif ($col_day == ($real_day - 1)) {
            // Returns the current date -1, same for the other days below but -2, -3, -...
            $date = date("Y-m-d", strtotime('-1 day', strtotime(DATE)));
        } elseif ($col_day == ($real_day - 2)) {
            $date = date("Y-m-d", strtotime('-2 day', strtotime(DATE)));
        } elseif ($col_day == ($real_day - 3)) {
            $date = date("Y-m-d", strtotime('-3 day', strtotime(DATE)));
        } elseif ($col_day == ($real_day - 4)) {
            $date = date("Y-m-d", strtotime('-4 day', strtotime(DATE)));
        } elseif ($col_day == ($real_day - 5)) {
            $date = date("Y-m-d", strtotime('-5 day', strtotime(DATE)));
        } elseif ($col_day == ($real_day - 6)) {
            $date = date("Y-m-d", strtotime('-6 day', strtotime(DATE)));
        } else {
            // Return a "-" if in day has yet to come this week
            return "-";
        }
        array_push(self::$week, $date);
        return $date;
    }

    // Function to get the kilowatt value from the data base, pushes it to calculate wattage function.
    public static function getKilowatt($date): string
    {
        // Make new variable from class Database
        $db = new Database();
        // Query to select the data from the kilowatt column in the etws_data table where the date is set to the date returned by the setDate function
        $db->query('SELECT kilowatt FROM etws_data WHERE date = :date');
        // Binds the pdo value date to the variable date
        $db->bind(':date', $date);
        // Checks if query has returned anything
        if (!empty($db->single())) {
            // Put the query output in the static variable kwh
            self::$kwh = $db->single()['kilowatt'];
            // Returns a rounded kilowatt per hour as well as adding kWh at the end
            return round(self::$kwh, 2) . " kWh";
        } else {
            // Set the static variable kwh to be null
            self::$kwh = "";
            // Return "-" if query is empty
            return "-";
        }
    }

    // Function to calculate the saved amount in euro
    #[Pure] public static function calcEuro(): string
    {
        // Check if kwh is not empty
        if (!empty(self::$kwh)) {
            // Returns a string with a rounded value in euro
            return "&plusmn; € " . round(COST * self::$kwh, 2);
        } else {
            // Returns "-" as string
            return "-";
        }
    }

    public static function calcWeekKilowattTotal()
    {
        var_dump(self::$week);
    }

    public static function calcWeekEuroTotal()
    {

    }
}